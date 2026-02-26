<?php

namespace Database\Seeders;

use App\Models\SizeModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = Carbon::now();
        // SizeModel::truncate();
        SizeModel::insert([
            [
                'id' => 1,
                'name' => 'S',
                'created_at' => $time,
            ],
            [
                'id' => 2,
                'name' => 'M',
                'created_at' => $time,

            ],
            [
                'id' => 3,
                'name' => 'L',
                'created_at' => $time,
            ],
            [
                'id' => 4,
                'name' => 'XL',
                'created_at' => $time,
            ],
            [
                'id' => 5,
                'name' => 'XXL',
                'created_at' => $time,
            ],
            [
                'id' => 6,
                'name' => 'XXXL',
                'created_at' => $time,
            ],
            [
                'id' => 7,
                'name' => 'XXXXL',
                'created_at' => $time,
            ],
        ]);
    }
}
