<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTypeModel extends Model
{
    protected $table = 'item_type';

    protected $fillable = [
        'name',
        'created_at',
    ];
}
