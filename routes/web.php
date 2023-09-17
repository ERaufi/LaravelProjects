<?php

use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



//Start Drop Zone Routes
Route::view('drop-zone', 'DropZone.index');
Route::post('/drop-zone', [DropZoneController::class, 'upload']);
//End Drop Zone Routes

//Start Auto-Suggest Search
Route::view('auto-suggest', 'AutoSuggest.index');
Route::get('/search', [ProductsController::class, 'search']);
//End Auto-Suggest Search

//start Lazy Load
Route::view('lazy-load', 'LazyLoad.index');
Route::get('/lazy-load-data', [DropZoneController::class, 'index']);
//End Lazy Load

//Start Excel Import and Export
Route::view('import-export', 'ImportExport.index');
Route::get('prodcts/export/', [ProductsController::class, 'export']);
Route::post('/products/import', [ProductsController::class, 'import']);
//End Excel Import and Export
