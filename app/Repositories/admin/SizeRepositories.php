<?php

namespace App\Repositories\admin;

use App\Models\SizeModel;
use Illuminate\Support\Facades\DB;

class SizeRepositories
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] != null) {
            $data = $data->where('name', 'like', "%{$request['name']}%");
        }

        return $data;
    }

    function getSize($request)
    {
        $outlet_id = getAuth();
        $data = SizeModel::where('outlet_id', $outlet_id)->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getSizeByOutletId()
    {
        $outlet_id = getAuth();
        $type = SizeModel::where('outlet_id', $outlet_id)->get();
        return $type;
    }

    function getSizeById($id)
    {
        $outlet_id = getAuth();
        $item = SizeModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
        return $item;
    }

    function addSize($request)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
                'outlet_id' => $outlet_id,
            ];

            $insert = SizeModel::create($data);

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


    function editSize($request)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
            ];

            $size = SizeModel::where('id', $request['id'])->where('outlet_id', $outlet_id)->firstOrFail();
            checkOutlet($size->outlet_id);
            $size->update($data);

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

    function deleteSize($id)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $size = SizeModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
            checkOutlet($size->outlet_id);
            $size->delete();

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
