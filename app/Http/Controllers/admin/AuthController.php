<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OutletModel;
use App\Models\StaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function viewLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('admin_dashboard');
        } else {
            return view('admin/index');
        }
    }

    public function login(Request $request)
    {
        if(empty($request->outlet_id)){
            return redirect()->route('outlet_login')->with('login_message', 'Login gagal. Masukan email yang benar');
        }
        $credentials = $request->only('email', 'password');

        $user = StaffModel::where('email', $credentials['email'])->first();

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin_dashboard');
        } else {
            return redirect()->route('admin_login')->with('login_message', 'Login gagal. Periksa kembali username dan password anda');
        }
    }

    public function outlet_login(Request $request)
    {
        $data['outlet'] = OutletModel::where('email', $request->email)->first();

        if(!empty($data['outlet'])){
            return view('admin/index', $data);
        }else{
            return redirect()->route('outlet_login')->with('login_message', 'Login gagal. Masukan email yang benar');
        }


    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('outlet_login')->with('logout', 'Logout Berhasil');
    }
}
