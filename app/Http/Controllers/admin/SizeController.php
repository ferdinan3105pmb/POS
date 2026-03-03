<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\admin\SizeRepositories;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    protected $size_r;

    function __construct()
    {
        $this->size_r  = new SizeRepositories;
    }    

    function index(Request $request)
    {
        return view('admin/size/index');
    }

    function data(Request $request)
    {
        $data['sizes'] = $this->size_r->getSize($request);
        return view('admin.size.data', $data);
    }

    function add()
    {
        return view('admin.size.add');
    }

    function store(Request $request)
    {
        $response =  $this->size_r->addSize($request);
        return response()->json($response);
    }

    function edit($id)
    {
        $data['size'] = $this->size_r->getSizeById($id);
        return view('admin.size.edit', $data);
    }

    function update(Request $request)
    {
        $response =  $this->size_r->editSize($request);
        return response()->json($response);
    }

    function delete($id)
    {
        $response =  $this->size_r->deleteSize($id);
        return response()->json($response);
    }
}
