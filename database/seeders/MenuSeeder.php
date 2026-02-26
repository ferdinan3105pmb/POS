<?php

namespace Database\Seeders;

use App\Models\MenuModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuModel::truncate();
        MenuModel::insert([
            [
                'id' => 1,
                'name' => 'Staff',
                'route' => '/admin/staff',
            ],
            [
                'id' => 2,
                'name' => 'Item',
                'route' => '/admin/item',
            ],
            [
                'id' => 3,
                'name' => 'Purchase',
                'route' => '/admin/purchase',
            ],
        ]);
    }
}
