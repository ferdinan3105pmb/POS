<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutletModel extends Model
{
    protected $table = 'outlet';

    protected $fillable = [
        'name',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
