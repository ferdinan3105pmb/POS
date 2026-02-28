<?php

use App\Http\Controllers\admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\admin\QuizController as AdminQuizController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\QuizController;
use App\Models\ItemModel;
use App\Models\ItemVariantModel;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminIndexController::class, 'login_page'])->name('admin_login');
Route::get('/admin', [AdminIndexController::class, 'login_page'])->name('admin_login');
Route::get('/admin/dashboard', [AdminIndexController::class, 'dashboard'])->name('admin_dashboard');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin_login_process_admin');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');

Route::get('/items/by-type/{type_id}', [ItemController::class, 'getByTypeAjax']);
Route::get('/variants/by-item/{item_id}', [ItemController::class, 'getItemVariantByItemAjax']);



Route::post('/barcode', function (\Illuminate\Http\Request $request) {
    dd($request->barcode);
})->name('barcode.store');


Route::middleware('admin')->group(function () {
    Route::prefix('/admin/staff')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin_user');
        Route::get('/data', [UserController::class, 'data'])->name('admin_data_user');
        Route::get('/add', [UserController::class, 'add'])->name('admin_add_user');
        Route::post('/post', [UserController::class, 'store'])->name('admin_post_user');
        Route::post('/change_password', [UserController::class, 'changePassword'])->name('admin_password_user');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin_edit_user');
        Route::post('/update', [UserController::class, 'update'])->name('admin_update_user');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('admin_delete_user');
    });

    Route::prefix('/admin/item')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('admin_item');
        Route::get('/data', [ItemController::class, 'data'])->name('admin_data_item');
        Route::get('/add', [ItemController::class, 'add'])->name('admin_add_item');
        Route::post('/post', [ItemController::class, 'store'])->name('admin_post_item');
        Route::post('/change_password', [ItemController::class, 'changePassword'])->name('admin_password_item');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('admin_edit_item');
        Route::post('/update', [ItemController::class, 'update'])->name('admin_update_item');
        Route::delete('/delete/{id}', [ItemController::class, 'delete'])->name('admin_delete_item');
        Route::get('/data-variant/{id}', [ItemController::class, 'data_variant'])->name('admin_data_variant');
        Route::get('/ajax-data-variant/{id}', [ItemController::class, 'ajax_data_variant'])->name('admin_ajax_data_variant');
        Route::post('/add-variant', [ItemController::class, 'add_variant'])->name('admin_add_variant');
        Route::post('/update-option', [ItemController::class, 'updateVariant'])->name('admin_update_variant');
        // Route::get('/data-question/{id}', [AdminQuizController::class, 'data_question'])->name('admin_data_question');
    });

    Route::prefix('/admin/purchase')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('admin_purchase');
        Route::get('/data', [PurchaseController::class, 'data'])->name('admin_data_purchase');
        Route::get('/add', [PurchaseController::class, 'add'])->name('admin_add_purchase');
        Route::post('/post', [PurchaseController::class, 'store'])->name('admin_post_purchase');
        Route::get('/detail/{id}', [PurchaseController::class, 'detail'])->name('admin_detail_purchase');
    });

    Route::prefix('/admin/report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('admin_report');
        Route::get('/monthly-sales', [ReportController::class, 'monthlySales'])->name('admin_data_monthly_sales_report');
        Route::get('/doughnut-chart', [ReportController::class, 'doughnutChart'])->name('doughnutChart');
        Route::get('/item-sales-report', [ReportController::class, 'itemSalesReport'])->name('admin_data_monthly_sales_report');
        Route::get('/sales-summary', [ReportController::class, 'salesSummary'])->name('admin_data_monthly_sales_report');
    });
});
