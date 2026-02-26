<?php

namespace App\Repositories\admin;

use App\Models\ItemVariantModel;
use App\Models\PurchaseDetailModel;
use App\Models\PurchaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseRepositories
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['date']) && $request['date'] != null) {
            $data = $data->whereDate('date', $request['date']);
        }

        return $data;
    }

    function getPurchase($request)
    {
        $data = PurchaseModel::orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getPurchaseDetail($id)
    {
        $data = PurchaseModel::with('Detail')->where('id', $id)->first();
        return $data;
    }

    function getPurchaseById($id)
    {
        $staff = PurchaseModel::where('id', $id)->firstOrFail();
        return $staff;
    }

    function getAllPurchase()
    {
        $data = PurchaseModel::get();
        return $data;
    }

    function addPurchase($request)
    {
        DB::beginTransaction();
        try {

            $detail = [];
            $total = 0;
            $stock = [];
            foreach ($request->items as $data) {
                $total += $data['price'];
            }

            $data = [
                'date' => Carbon::now(),
                'staff_id' => Auth::guard('admin')->user()->id,
                'item_type_id' => $request['type_id'],
                'total' => $total,
            ];

            $insert = PurchaseModel::create($data);

            foreach ($request->items as $data) {
                $detail[] = [
                    'purchase_id' => $insert->id,
                    'item_variant_id' => $data['variant_id'],
                    'qty' => $data['qty'],
                    'created_at' => Carbon::now(),
                ];
            }

            $insert->Detail()->createMany($detail);

            $grouped = collect($detail)
                ->groupBy('item_variant_id')
                ->map(function ($items, $variantId) {

                    return [
                        'item_variant_id' => $variantId,
                        'qty' => $items->sum('qty'),
                    ];
                })->values()
                ->toArray();

            foreach ($grouped as $value) {
                ItemVariantModel::where('id', $value['item_variant_id'])->decrement('stock', $value['qty']);
            }

            DB::commit();
            $message = [
                'status' => true,
                'data' => $insert,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
        return $message;
    }
}
