<?php

namespace App\Repositories\admin;

use App\Models\StaffModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminRepositories
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] != null) {
            $data = $data->where('name', 'like', "%{$request['name']}%");
        }

        return $data;
    }

    function getStaff($request)
    {
        $data = StaffModel::orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getStaffById($id)
    {
        $staff = StaffModel::where('id', $id)->firstOrFail();
        return $staff;
    }

    function getAllStaff()
    {
        $data = StaffModel::get();
        return $data;
    }

    function addStaff($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ];

            $insert = User::create($data);

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


    function editStaff($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'email' => $request['email'],
            ];

            User::where('id', $request['id'])->update($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => null,
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

    function editPassword($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'password' => bcrypt($request['password']),
            ];

            $user = User::where('id', $request['id'])->firstOrFail();
            $user->update($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => null,
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

    function deleteStaff($id)
    {
        DB::beginTransaction();
        try {
            $data = User::where('id', $id)->firstOrFail();
            $data->delete();

            DB::commit();
            $message = [
                'status' => true,
                'data' => null,
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
