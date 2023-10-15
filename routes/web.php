<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WeatherController;
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



// Video Link https://youtu.be/KzZR9A7Xk14
// Start Full Calender=================================================================
Route::get('fullcalender', [ScheduleController::class, 'index']);
Route::get('/events', [ScheduleController::class, 'getEvents']);
Route::delete('/schedule/{id}', [ScheduleController::class, 'deleteEvent']);
Route::put('/schedule/{id}', [ScheduleController::class, 'update']);
Route::put('/schedule/{id}/resize', [ScheduleController::class, 'resize']);
Route::get('/events/search', [ScheduleController::class, 'search']);
// End Full Calender=================================================================



// Video Link https://youtu.be/SdwA3YKW35g
//Start Drop Zone Routes==============================================================
Route::view('drop-zone', 'DropZone.index');
Route::post('/drop-zone', [DropZoneController::class, 'upload']);
//End Drop Zone Routes==============================================================


// Video Link https://youtu.be/7nvN0q77P-k
//Start Auto-Suggest Search==============================================================
Route::view('auto-suggest', 'AutoSuggest.index');
Route::get('/search', [ProductsController::class, 'search']);
//End Auto-Suggest Search==============================================================



// Video Link https://youtu.be/5eG3PIriMgU
//start Lazy Load======================================================================
Route::view('lazy-load', 'LazyLoad.index');
Route::get('/lazy-load-data', [DropZoneController::class, 'index']);
//End Lazy Load======================================================================


// Video Link https://youtu.be/BKPkN7XEwxA
//Start Excel Import and Export========================================================
Route::view('import-export', 'ImportExport.index');
Route::get('prodcts/export/', [ProductsController::class, 'export']);
Route::post('/products/import', [ProductsController::class, 'import']);
//End Excel Import and Export========================================================


// video Link https://youtu.be/my9XgQHQoKM
// Start PDF Generate===================================================================
Route::get('generate-pdf', [ProductsController::class, 'generatePDF']);
// End PDF Generate===================================================================


// Video Link https://youtu.be/gVP0EIS5j5A
// Start CRUD===========================================================================
Route::resource('products', ProductsController::class);
// End CRUD===========================================================================



// video Link https://youtu.be/6tEsCSatPXE
// Start CSV Import and Export===========================================================
Route::view('csv', 'ImportExport.csv');
Route::get('export-csv', [ProductsController::class, 'exportToCSV']);
Route::post('import-csv', [ProductsController::class, 'importCSV']);
// End CSV Import and Export===========================================================



// video Link https://youtu.be/ktTK2LZcyk4
// Start Login using Name,Email or phone number====================================================
Route::view('login', 'auth.login');
Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('throttle:5,1');
Route::view('register', 'auth.register');
Route::post('register', [RegisterController::class, 'create'])->name('register');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// End Login using Name,Email or phone number====================================================



// Video link https://youtu.be/Hyw8w65Ru5U
// Start Weather========================================================================
Route::view('weather', 'Weather.index');
Route::get('get-weather', [WeatherController::class, 'index']);
// End Weather========================================================================



// Start Encrypt and Decrypt===========================================================
Route::get('notes', [NotesController::class, 'index']);
Route::get('notes/create', [NotesController::class, 'create']);
Route::post('notes/store', [NotesController::class, 'store']);
Route::get('notes/{note}', [NotesController::class, 'show']);
Route::get('notes/{note}/edit', [NotesController::class, 'edit']);
Route::put('notes/{note}', [NotesController::class, 'update']);
Route::delete('notes/{note}', [NotesController::class, 'destroy']);
// End Encrypt and Decrypt=============================================================





// Auth::routes();




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
