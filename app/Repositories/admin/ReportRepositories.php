<?php

namespace App\Repositories\admin;

use App\Models\PurchaseDetailModel;
use App\Models\PurchaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepositories
{
    function doughnutChart($request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->month);

        $data = PurchaseModel::with('Detail.ItemVariant.Item')->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)->get();

        $chart['labels'] = [];
        $chart['data'] = [];

        if (count($data) > 0) {
            $grouped = $data
                ->flatMap->Detail
                ->groupBy(fn($detail) => $detail->ItemVariant->Item->name);

            $chart['labels'] = $grouped->keys()->toArray();
            $chart['data']   = $grouped->map->sum('qty')->values()->toArray();
        }

        return $chart;
    }

    // function getitemSalesReport($request)
    // {
    //     $date = Carbon::createFromFormat('Y-m', $request);

    //     $data = PurchaseDetailModel::selectRaw('
    //     item_variant_id,
    //     SUM(qty) as total_qty,
    //     SUM(qty * price) as total_sales
    // ')
    //         ->whereHas('Purchase', function ($q) use ($date) {
    //             $q->whereYear('date', $date->year)
    //                 ->whereMonth('date', $date->month);
    //         })
    //         ->groupBy('item_variant_id')
    //         ->with('ItemVariant.Item')
    //         ->get();

    //     return $data;
    // }

    function getitemSalesReport($request)
    {
        // dd($request);
        $date = Carbon::createFromFormat('Y-m', $request->month);

        $query = PurchaseDetailModel::selectRaw('
            purchase_detail.item_variant_id,
            item.name as item_name, 
            SUM(qty) as total_qty,
            SUM(qty * purchase_detail.price) as total_sales,
            item_variant.size_id as size,
            item_variant.color as color
        ')
            ->join('purchase', 'purchase_detail.purchase_id', '=', 'purchase.id')
            ->join('item_variant', 'purchase_detail.item_variant_id', '=', 'item_variant.id')
            ->join('item', 'item_variant.item_id', '=', 'item.id')
            ->whereYear('purchase.date', $date->year)
            ->whereMonth('purchase.date', $date->month)
            ->groupBy('purchase_detail.item_variant_id', 'item.name');

        // Search
        if ($search = $request->input('search.value')) {
            $query->having('item_name', 'like', "%{$search}%");
        }

        //order
        $sortColumn = 'item.name';
        $sortDirection = 'asc';
        if ($request->has('order')) {

            $columnIndex = $request->order[0]['column'];
            $direction = $request->order[0]['dir'];

            // Mapping kolom index ke nama kolom database
            $columns = [
                0 => 'item.name',
                1 => 'item_variant.size_id',
                2 => 'item_variant.color',
                3 => DB::raw('SUM(qty)'),
                4 => DB::raw('SUM(qty * purchase_detail.price)'),
            ];

            if (isset($columns[$columnIndex])) {
                $sortColumn = $columns[$columnIndex];
                $sortDirection = $direction;
            }
        }

        $query->orderBy($sortColumn, $sortDirection);

        $totalRecords = $query->count();

        if (!empty($request->start) || !empty($request->length)) {
            $data = $query->offset($request->start)
                ->limit($request->length);
        }
        // Pagination
        $data = $query->get();

        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    function salesSummary($request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->month);

        $totalDetail = PurchaseDetailModel::whereHas('purchase', function ($query) use ($date) {
            $query->whereYear('date', $date->year)
                ->whereMonth('date', $date->month);
        })->count();

        $totalSales = PurchaseDetailModel::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)->SUM(DB::raw('qty * price'));


        $data['total_sales'] = $totalSales;
        $data['total_detail'] = $totalDetail;

        return $data;
    }
}
