<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\admin\ItemTypeRepositories;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    protected $itemT_r;

    function __construct()
    {
        $this->itemT_r  = new ItemTypeRepositories;
    }    

    function index(Request $request)
    {
        return view('admin/item_type/index');
    }

    function data(Request $request)
    {
        $data['types'] = $this->itemT_r->getItemType($request);
        return view('admin.item_type.data', $data);
    }

    function add()
    {
        return view('admin.item_type.add');
    }

    function store(Request $request)
    {
        $response =  $this->itemT_r->addItemType($request);
        return response()->json($response);
    }

    function edit($id)
    {
        $data['type'] = $this->itemT_r->getItemTypeById($id);
        return view('admin.item_type.edit', $data);
    }

    function update(Request $request)
    {
        $response =  $this->itemT_r->editItemType($request);
        return response()->json($response);
    }

    function delete($id)
    {
        $response =  $this->itemT_r->deleteItemType($id);
        return response()->json($response);
    }
}
