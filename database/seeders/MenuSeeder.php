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
                'name' => 'Item Type',
                'route' => '/admin/item-type',
            ],
            [
                'id' => 3,
                'name' => 'Size',
                'route' => '/admin/size',
            ],
            [
                'id' => 4,
                'name' => 'Item',
                'route' => '/admin/item',
            ],
            [
                'id' => 5,
                'name' => 'Purchase',
                'route' => '/admin/purchase',
            ],
            [
                'id' => 6,
                'name' => 'Report',
                'route' => '/admin/report',
            ],
        ]);
    }
}
