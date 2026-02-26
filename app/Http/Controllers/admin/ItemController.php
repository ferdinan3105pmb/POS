<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\ItemTypeModel;
use App\Models\ItemVariantModel;
use App\Models\SizeModel;
use Illuminate\Http\Request;
use App\Repositories\admin\ItemRepositories;
use Illuminate\Database\Eloquent\Model;

class ItemController extends Controller
{
    protected $item_r;

    function __construct()
    {
        $this->item_r  = new ItemRepositories;
    }

    function index(Request $request)
    {
        return view('admin/item/index');
    }

    function data(Request $request)
    {
        $data['items'] = $this->item_r->getItem($request);
        return view('admin.item.data', $data);
    }

    function add()
    {
        $data['types'] = ItemTypeModel::get();
        return view('admin.item.add', $data);
    }

    function store(Request $request)
    {
        $response =  $this->item_r->addItem($request);
        return response()->json($response);
    }

    function edit($id)
    {
        $data['types'] = ItemTypeModel::get();
        $data['sizes'] = SizeModel::get();
        $data['item'] = $this->item_r->getItemById($id);

        return view('admin.item.edit', $data);
    }

    function update(Request $request)
    {
        $response =  $this->item_r->editItem($request);
        return response()->json($response);
    }

    function delete($id)
    {
        $response =  $this->item_r->deleteItem($id);
        return response()->json($response);
    }

    function data_variant($id)
    {
        $data['sizes'] = SizeModel::get();
        $data['variant'] = $this->item_r->getItemVariantById($id);
        return view('admin.item.option', $data);
    }

    function ajax_data_variant($id)
    {
        $data['item'] = $this->item_r->getItemVariantByItemId($id);
        return view('admin.item.variant', $data);
    }

    function add_variant(Request $request)
    {
        $response = $this->item_r->addVariant($request);
        return response()->json($response);
    }

    function updateVariant(Request $request)
    {
        $response =  $this->item_r->editVariant($request);
        return response()->json($response);
    }

    function getByTypeAjax($id)
    {
        $data['model'] = ItemModel::where('item_type_id', $id)->get();
        return $data['model'];
    }

    function getItemVariantByItemAjax($id)
    {
        $data['variant'] = ItemVariantModel::where('item_id', $id)->get();
        return $data['variant'];
    }
}
