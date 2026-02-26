<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffModel extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'staff';


    protected $fillable = [
        'email',
        'password',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];
}
