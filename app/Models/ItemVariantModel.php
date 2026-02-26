<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemVariantModel extends Model
{
    protected $table = 'item_variant';
    protected $appends = ['size_label'];

    protected $fillable = [
        'color',
        'price',
        'item_id',
        'size_id',
        'stock',
        'created_at'
    ];

    function Size()
    {
        return $this->hasOne(SizeModel::class, 'id', 'size_id');
    }

    function Item()
    {
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }


    protected function sizeLabel(): Attribute
    {
        return Attribute::make(
            get: function () {

                $sizes = [
                    1 => "S",
                    2 => "M",
                    3 => "L",
                    4 => "XL",
                    5 => "XXL",
                    6 => "XXXL",
                    7 => "XXXXL",
                ];

                return $sizes[$this->size_id] ?? null;
            }
        );
    }
}
