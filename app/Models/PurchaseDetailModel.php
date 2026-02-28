<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetailModel extends Model
{
    protected $table = 'purchase_detail';

    protected $fillable = [
        'purchase_id',
        'item_variant_id',
        'qty',
        'price',
        'created_at',
    ];

    function Purchase(){
        return $this->belongsTo(PurchaseModel::class, 'purchase_id', 'id');
    }

    function ItemVariant(){
        return $this->belongsTO(ItemVariantModel::class, 'item_variant_id', 'id');
    }
}
