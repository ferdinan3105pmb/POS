<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function dashboard(Request $request)
    {
        return view('admin/dashboard/index');
    }

    function login_page(Request $request)
    {
        return view('admin/index');
    }
}
