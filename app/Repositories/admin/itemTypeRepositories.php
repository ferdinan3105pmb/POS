<?php

namespace App\Repositories\admin;

use App\Models\ItemModel;
use App\Models\ItemTypeModel;
use App\Models\ItemVariantModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemTypeRepositories
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] != null) {
            $data = $data->where('name', 'like', "%{$request['name']}%");
        }

        return $data;
    }

    function getItemType($request)
    {
        $outlet_id = getAuth();
        $data = ItemTypeModel::where('outlet_id', $outlet_id)->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getItemTypeByOutletId()
    {
        $outlet_id = getAuth();
        $type = ItemTypeModel::where('outlet_id', $outlet_id)->get();
        return $type;
    }

    function getItemTypeById($id)
    {
        $outlet_id = getAuth();
        $item = ItemTypeModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
        return $item;
    }

    function addItemType($request)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
                'outlet_id' => $outlet_id,
            ];

            $insert = ItemTypeModel::create($data);

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


    function editItemType($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
            ];

            ItemTypeModel::where('id', $request['id'])->update($data);

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

    function deleteItemType($id)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = ItemTypeModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
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
