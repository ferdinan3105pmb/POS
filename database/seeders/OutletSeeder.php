<?php

namespace Database\Seeders;

use App\Models\OutletModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OutletModel::truncate();
        OutletModel::insert([
            [
                'id' => 1,
                'name' => 'Test',
                'email' => 'test@gmail.com',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
