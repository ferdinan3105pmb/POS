<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\ItemTypeModel;
use App\Repositories\admin\ItemRepositories;
use App\Repositories\admin\ItemTypeRepositories;
use App\Repositories\admin\PurchaseRepositories;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchase_r, $itemT_r, $item_r;

    function __construct()
    {
        $this->purchase_r  = new PurchaseRepositories;
        $this->itemT_r  = new ItemTypeRepositories;
        $this->item_r  = new ItemRepositories;
    }

    function index(Request $request)
    {
        return view('admin/purchase/index');
    }

    function data(Request $request)
    {
        $data['purchase'] = $this->purchase_r->getPurchase($request);
        $data['total_sales'] = $this->purchase_r->getTotalSalesToday($request);
        return view('admin.purchase.data', $data);
    }

    function add()
    {
        $data['types'] = $this->itemT_r->getItemTypeByOutletId();
        $data['item'] = ItemModel::with('ItemType')->get();
        return view('admin.purchase.add', $data);
    }

    function store(Request $request)
    {
        $response =  $this->purchase_r->addPurchase($request);
        return response()->json($response);
    }

    function detail($id)
    {
        $data['purchase'] = $this->purchase_r->getPurchaseDetail($id);
        return view('admin.purchase.detail', $data);
    }
}
