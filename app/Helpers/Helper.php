<?php

use App\Models\MenuModel;

function getMenus()
{
    $menus = MenuModel::get();

    return $menus;
}


function format_idr($number)
{
    return 'Rp ' . number_format($number, 0, ',', '.');
}

function Size($id)
{
    $sizes = [
        1 => "S",
        2 => "M",
        3 => "L",
        4 => "XL",
        5 => "XXL",
        6 => "XXXL",
        7 => "XXXXL",
    ];

    return $sizes[$id] ?? null;
}
