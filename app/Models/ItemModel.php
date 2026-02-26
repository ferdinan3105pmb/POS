<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'item';

    protected $fillable = [
        'name',
        'created_at',
        'item_type_id',
        'picture',
    ];


    function ItemType()
    {
        return $this->belongsTo(ItemTypeModel::class, 'item_type_id', 'id');
    }
}
