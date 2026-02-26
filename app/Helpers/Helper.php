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
