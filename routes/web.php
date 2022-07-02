<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTreeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StandardCostController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function() {
    //HOME ROUTES
    Route::get('/',[HomeController::class, 'index'])->name('home');

    //PRODUCTS ROUTES
    Route::get('/products',[ProductController::class, 'index'])->name('products');
    Route::post('/add-product',[ProductController::class, 'addProduct'])->name('add-product');
    Route::post('/update-product',[ProductController::class, 'updateProduct'])->name('update-product');

    Route::get('/get-product',[ProductController::class, 'getProduct'])->name('get-product');


    //PRODUCT TREE ROUTES
    Route::get('/product-tree',[ProductTreeController::class, 'index'])->name('product-tree');
    Route::get('/add-product-tree',[ProductTreeController::class, 'getAddProductTree'])->name('get-add-product-tree');
    Route::get('/get-product-in-tree',[ProductTreeController::class, 'getProduct'])->name('get-product-in-tree');

    Route::post('/add-product-tree',[ProductTreeController::class, 'addProductTree'])->name('add-product-tree');

    Route::get('/get-product-tree-details/{id}', [ProductTreeController::class, 'getProductTreeDetails'])->name('get-product-tree-details');
    Route::post('/update-product-tree/{id}',[ProductTreeController::class, 'updateProductTree'])->name('update-product-tree');
    Route::get('/delete-product-from-tree/{id}', [ProductTreeController::class, 'deleteProductFromTree'])->name('delete-product-from-tree');


    Route::get('/delete-product-tree/{id}', [ProductTreeController::class, 'deleteProductTree'])->name('delete-product-tree');


    // SECTORS ROUTES
    Route::get('/all-sectors', [SectorController::class, 'index'])->name('all-sectors');
    Route::post('/add-sector', [SectorController::class, 'addSector'])->name('add-sector');
    Route::post('/update-sector', [SectorController::class, 'updateSector'])->name('update-sector');
    Route::get('/delete-sector', [SectorController::class, 'deleteSector'])->name('delete-sectors');

    // EQUIPMENTS ROUTES
    Route::get('/all-equipments', [EquipmentController::class, 'index'])->name('all-equipments');
    Route::get('/get-equipment', [EquipmentController::class, 'getEquipment'])->name('get-equipment');
    Route::post('/add-equipment', [EquipmentController::class, 'addEquipment'])->name('add-equipment');
    Route::post('/update-equipment', [EquipmentController::class, 'updateEquipment'])->name('update-equipment');

    // PATHES ROUTES
    Route::get('/all-paths', [PathController::class, 'index'])->name('all-paths');
    Route::get('/add-path',[PathController::class, 'getAddPath'])->name('get-add-path');
    Route::get('/get-path-details/{id}', [PathController::class, 'getPathDetails'])->name('get-path-details');
    Route::get('/get-path-expenses/{id}', [PathController::class, 'getPathExpenses'])->name('get-path-expenses');
    Route::get('/check-standard-path-for-the-product', [PathController::class, 'checkProductStandardPath'])->name('check-product-standard-path');

    Route::post('/add-path',[PathController::class, 'addPath'])->name('add-path');
    Route::post('/update-path',[PathController::class, 'updatePath'])->name('update-path');

    // STOCKS ROUTES
    Route::get('/all-stocks', [StockController::class, 'index'])->name('all-stocks');
    Route::post('/add-stock', [StockController::class, 'addStock'])->name('add-Stock');
    Route::post('/update-stock', [StockController::class, 'updateStock'])->name('update-Stock');
    Route::get('/delete-stock', [StockController::class, 'deleteStock'])->name('delete-Stock');

    // STANDARD COST ROUTES
    Route::get('/standard-cost', [StandardCostController::class, 'index'])->name('standard-cost');
    Route::post('/get-product-paths-and-trees', [StandardCostController::class, 'getProductPathsAndTrees']);
    Route::post('/update-product-standard-cost', [StandardCostController::class, 'updateProductStandardCost']);

    // DAILY REPORT
    Route::get('/daily-report', [DailyReportController::class, 'index'])->name('daily-report');
    Route::get('/get-product-daily-report', [DailyReportController::class, 'getProduct'])->name('daily-report-get-product');
    Route::post('/add-daily-report', [DailyReportController::class, 'addDailyReport'])->name('add-daily-report');

    // Actuall Pdf REPORTS 
    Route::get('/products-report', [ReportController::class, 'productsOfDay'])->name('products-report');
    Route::post('/products-report', [ReportController::class, 'printProductsOfDay'])->name('print-products-report');
    Route::get('/product-tree-report', [ReportController::class, 'productsOfTree'])->name('product-tree-report');
    Route::post('/product-tree-report', [ReportController::class, 'PrintProductsOfTree'])->name('print-product-tree-report');
    Route::get('/path-report', [ReportController::class, 'pathSteps'])->name('path-report');
    Route::post('/print-path', [ReportController::class, 'printPathDetails'])->name('print-path');

});
