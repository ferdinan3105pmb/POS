<?php

namespace App\Repositories\admin;

use App\Models\ItemModel;
use App\Models\ItemVariantModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemRepositories
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] != null) {
            $data = $data->where('name', 'like', "%{$request['name']}%");
        }

        return $data;
    }

    function getItem($request)
    {
        $outlet_id = Auth::guard('admin')->user()->outlet_id;
        $data = ItemModel::where('outlet_id', $outlet_id)->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getItemByOutletId()
    {
        $outlet_id = getAuth();
        $item = ItemModel::where('outlet_id', $outlet_id)->get();
        return $item;
    }

    function getItemById($id)
    {
        $outlet_id = getAuth();
        $item = ItemModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
        return $item;
    }

    function addItem($request)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
                'item_type_id' => $request['type_id'],
                'outlet_id' => $outlet_id,
            ];

            $insert = ItemModel::create($data);

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


    function editItem($request)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $data = [
                'email' => $request['email'],
            ];

            $item = ItemModel::where('id', $request['id'])->where('outlet_id', $outlet_id)->firstOrFail();
            checkOutlet($item->outlet_id);

            $item->update($data);

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

    function deleteItem($id)
    {
        $outlet_id = getAuth();
        DB::beginTransaction();
        try {
            $item = ItemModel::where('id', $id)->where('outlet_id', $outlet_id)->firstOrFail();
            checkOutlet($item->outlet_id);
            $item->delete();

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

    function getItemVariantByItemId($id)
    {
        $data = ItemVariantModel::where('item_id', $id)->with(['Item', 'Size'])->get();
        return $data;
    }

    function getItemVariantById($id)
    {
        $data = ItemVariantModel::where('id', $id)->with(['Item', 'Size'])->first();
        return $data;
    }

    function addVariant($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'color' => strtolower($request['color']),
                'size_id' => $request['size'],
                'item_id' => $request['id'],
                'stock' => $request['stock'],
                'price' => $request['price'],
            ];

            $insert = ItemVariantModel::create($data);

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

    function editVariant($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'color' => $request['color'],
                'size_id' => $request['size'],
                'price' => $request['price'],
                'stock' => $request['stock'],
            ];

            ItemVariantModel::where('id', $request['id'])->update($data);

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
