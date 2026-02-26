<?php

namespace Database\Seeders;

use App\Models\ItemTypeModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = Carbon::now();
        ItemTypeModel::insert([
            [
                'id' => 1,
                'name' => 'Jeans',
                'created_at' => $time,
            ],
            [
                'id' => 2,
                'name' => 'Dress',
                'created_at' => $time,
            ],
            [
                'id' => 3,
                'name' => 'Blus',
                'created_at' => $time,
            ],
            [
                'id' => 4,
                'name' => 'One Piece',
                'created_at' => $time,
            ],
        ]);
    }
}
