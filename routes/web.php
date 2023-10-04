<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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



//Start Drop Zone Routes==============================================================
Route::view('drop-zone', 'DropZone.index');
Route::post('/drop-zone', [DropZoneController::class, 'upload']);
//End Drop Zone Routes==============================================================

//Start Auto-Suggest Search==============================================================
Route::view('auto-suggest', 'AutoSuggest.index');
Route::get('/search', [ProductsController::class, 'search']);
//End Auto-Suggest Search==============================================================

//start Lazy Load======================================================================
Route::view('lazy-load', 'LazyLoad.index');
Route::get('/lazy-load-data', [DropZoneController::class, 'index']);
//End Lazy Load======================================================================

//Start Excel Import and Export========================================================
Route::view('import-export', 'ImportExport.index');
Route::get('prodcts/export/', [ProductsController::class, 'export']);
Route::post('/products/import', [ProductsController::class, 'import']);
//End Excel Import and Export========================================================

// Start PDF Generate===================================================================
Route::get('generate-pdf', [ProductsController::class, 'generatePDF']);
// End PDF Generate===================================================================

// Start CRUD===========================================================================
Route::resource('products', ProductsController::class);
// End CRUD===========================================================================

// Start CSV Import and Export===========================================================
Route::view('csv', 'ImportExport.csv');
Route::get('export-csv', [ProductsController::class, 'exportToCSV']);
Route::post('import-csv', [ProductsController::class, 'importCSV']);
// End CSV Import and Export===========================================================
// Auth::routes();



Route::view('login', 'auth.login');
Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('throttle:5,1');

Route::view('register', 'auth.register');
Route::post('register', [RegisterController::class, 'create'])->name('register');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
