<?php

namespace Database\Seeders;

use App\Models\OutletModel;
use App\Models\StaffModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewOutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlet = OutletModel::create([
            'name' => 'new Test',
            'email' => 'new_test@gmail.com',
            'created_at' => Carbon::now(),
        ]);

        StaffModel::insert([
            'email' => 'budi@mail.com',
            'password' => bcrypt('password'),
            'outlet_id' => $outlet->id,
            'created_at' => Carbon::now(),
        ]);
    }
}
