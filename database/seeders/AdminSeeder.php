<?php

namespace Database\Seeders;

use App\Models\admin\AdminModel;
use App\Models\StaffModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // StaffModel::truncate();
        StaffModel::insert([
            [
                'id' => 1,
                'email' => 'admin@mail.com',
                'password' => Hash::make('test123'),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
