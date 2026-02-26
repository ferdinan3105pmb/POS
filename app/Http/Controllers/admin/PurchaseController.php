<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\ItemTypeModel;
use App\Repositories\admin\PurchaseRepositories;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchase_r;

    function __construct()
    {
        $this->purchase_r  = new PurchaseRepositories;
    }

    function index(Request $request)
    {
        return view('admin/purchase/index');
    }

    function data(Request $request)
    {
        $data['purchase'] = $this->purchase_r->getPurchase($request);
        return view('admin.purchase.data', $data);
    }

    function add()
    {
        $data['types'] = ItemTypeModel::get();
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
