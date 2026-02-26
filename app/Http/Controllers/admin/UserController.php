<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Repositories\admin\AdminRepositories;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $user_r;

    function __construct()
    {
        $this->user_r  = new AdminRepositories;
    }

    function index(Request $request)
    {
        return view('admin/staff/index');
    }

    function data(Request $request)
    {
        $data['staffs'] = $this->user_r->getStaff($request);
        return view('admin.staff.data', $data);
    }

    function add()
    {
        return view('admin.staff.add');
    }

    function store(Request $request)
    {
        $response =  $this->user_r->addStaff($request);
        return response()->json($response);
    }

    function edit($id)
    {
        $data['staff'] = $this->user_r->getStaffById($id);
        return view('admin.staff.edit', $data);
    }

    function changePassword(Request $request)
    {
        $response = $this->user_r->editPassword($request);        
        return response()->json($response);
    }

    function update(Request $request)
    {
        $response =  $this->user_r->editStaff($request);
        return response()->json($response);
    }

    function delete($id)
    {
        $response =  $this->user_r->deleteStaff($id);
        return response()->json($response);
    }
}
