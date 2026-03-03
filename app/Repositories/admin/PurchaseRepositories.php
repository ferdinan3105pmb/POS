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

    function getTotalSalesToday($request)
    {
        $outlet_id = getAuth();
        $data = PurchaseModel::where('outlet_id', $outlet_id);
        $data = $this->getRequestFilter($data, $request);

        $result = $data->SUM(DB::raw('total'));
        return $result;
    }

    function getPurchase($request)
    {
        $outlet_id = getAuth();
        $data = PurchaseModel::where('outlet_id', $outlet_id)->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getPurchaseDetail($id)
    {
        $data = PurchaseModel::with('Detail')->where('id', $id)->first();
        return $data;
    }

    function addPurchase($request)
    {
        $staff = Auth::guard('admin')->user();
        DB::beginTransaction();
        try {

            $detail = [];
            $total = 0;
            foreach ($request->items as $data) {
                $total += $data['price'];
            }

            $data = [
                'date' => Carbon::now(),
                'staff_id' => $staff->id,
                'item_type_id' => $request['type_id'],
                'total' => $total,
                'outlet_id' => $staff->outlet_id,
            ];

            $insert = PurchaseModel::create($data);

            foreach ($request->items as $data) {
                $detail[] = [
                    'purchase_id' => $insert->id,
                    'item_variant_id' => $data['variant_id'],
                    'qty' => $data['qty'],
                    'price' => $data['price'],
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
