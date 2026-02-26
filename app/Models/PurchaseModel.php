<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseModel extends Model
{
    use SoftDeletes;
    protected $table = 'purchase';

    protected $fillable = [
        'date',
        'staff_id',
        'total',
        'created_at',
    ];


    function Detail() {
        return $this->hasMany(PurchaseDetailModel::class, 'purchase_id', 'id');
    }
}
