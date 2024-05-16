<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CustomHelperController;
use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\FileManagementController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductTransactionsController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SSEController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ProductTransactionsController::class, 'index']);

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'success';
});

// Video Link https://youtu.be/KzZR9A7Xk14
// Start Full Calender=================================================================
Route::get('fullcalender', [ScheduleController::class, 'index']);
Route::get('/events', [ScheduleController::class, 'getEvents']);
Route::get('/schedule/delete/{id}', [ScheduleController::class, 'deleteEvent']);
Route::post('/schedule/{id}', [ScheduleController::class, 'update']);
Route::post('/schedule/{id}/resize', [ScheduleController::class, 'resize']);
Route::get('/events/search', [ScheduleController::class, 'search']);

Route::view('add-schedule', 'schedule.add');
Route::post('create-schedule', [ScheduleController::class, 'create']);
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
// Route::view('login', 'auth.login');
// Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('throttle:5,1');
// Route::view('register', 'auth.register');
// Route::post('register', [RegisterController::class, 'create'])->name('register');
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// End Login using Name,Email or phone number====================================================


// Video link https://youtu.be/Hyw8w65Ru5U
// Start Weather========================================================================
Route::view('weather', 'Weather.index');
Route::get('get-weather', [WeatherController::class, 'index']);
// End Weather========================================================================


// Video Link https://youtu.be/E40z1dDL0YY
// Start Encrypt and Decrypt===========================================================
Route::get('notes', [NotesController::class, 'index']);
Route::get('notes/create', [NotesController::class, 'create']);
Route::post('notes/store', [NotesController::class, 'store']);
Route::get('notes/{note}', [NotesController::class, 'show']);
Route::get('notes/{note}/edit', [NotesController::class, 'edit']);
Route::put('notes/{note}', [NotesController::class, 'update']);
Route::delete('notes/{note}', [NotesController::class, 'destroy']);
// End Encrypt and Decrypt=============================================================

// Video Link https://youtu.be/VXFSe-D5SCA
// Start Form Builder===============================================================
// Step 1
Route::get('form-builder', [FormBuilderController::class, 'index']);
// Step 2
Route::view('formbuilder', 'FormBuilder.create');
// Step 3
Route::post('save-form-builder', [FormBuilderController::class, 'create']);
// Step 4
Route::delete('form-delete/{id}', [FormBuilderController::class, 'destroy']);

// Step 5
Route::view('edit-form-builder/{id}', 'FormBuilder.edit');
Route::get('get-form-builder-edit', [FormBuilderController::class, 'editData']);
Route::post('update-form-builder', [FormBuilderController::class, 'update']);

// Step 6
Route::view('read-form-builder/{id}', 'FormBuilder.read');
Route::get('get-form-builder', [FormsController::class, 'read']);
Route::post('save-form-transaction', [FormsController::class, 'create']);

// End Form Builder===============================================================


// Video Link https://youtu.be/zT3somYJGAE
// Start Image Cropper=============================================================
Route::view('crop', 'cropperjs.index');
Route::post('/upload-cropped-image', [DropZoneController::class, 'uploadCroppedImage']);

// End Image Cropper===============================================================

// Video Link https://youtu.be/wNQxHo7Xj6M
// Start Laravel Dusk Test=======================================================
Route::view('dusk-test', 'Dusk.index')->middleware('permission:Laravel Dusk Test');
// End Laravel Dusk Test========================================================

// Video Link https://youtu.be/RRS7zW2SwIg
// Start Jquery Datatable========================================================
Route::view('datatable', 'Datatable.index');
Route::get('countries', [CountriesController::class, 'index']);
Route::post('countries/update', [CountriesController::class, 'update']);
Route::post('countries/reordering', [CountriesController::class, 'reOrder']);
// End Jquery Datatable==========================================================

// Video Link https://youtu.be/ZrabCjtIaCg
//Start Change Langauge (Localization)=============================================================
Route::post('change-lang', [LanguageController::class, 'change']);
// End Change Language (Localization)========================================================

// Video Link https://youtu.be/A7I8r3Fhrww
// Start Laravel SSE (Real time Notification)============================================
Route::get('send-notification', [NotificationsController::class, 'index'])->middleware('auth');
Route::post('create-notification', [NotificationsController::class, 'create']);
Route::get('/sse-updates', [SSEController::class, 'sendSSE']);
// End Laravel SSE (Real time Notification)==============================================


// Video Link https://youtu.be/Dcnud0U5-6E
// Start Chat Application===============================================================
// Route::view('chat', 'Chat.Index');
// Route::get('chats', [ChatsController::class, 'index']);
Route::get('communications', [ChatsController::class, 'index'])->middleware(['auth', 'verified']);
Route::post('send-message', [ChatsController::class, 'sendMessage']);
Route::get('get-new-messages/{user_id}', [ChatsController::class, 'getNewMessages']);
Route::get('communication-history', [ChatsController::class, 'getChatHistory']);
Route::post('upload-communication-photo', [ChatsController::class, 'uploadImage']);
// End Chat Application=================================================================

// Video Link https://youtu.be/5F_gRvkCoNM
// Start Custom Helper===============================================================
Route::get('custome-helper', [CustomHelperController::class, 'index']);
// End Custom Helper===============================================================

// Video Link https://youtu.be/AOLigc0T5tc
// Start Push Notification==========================================================
Route::view('push-notification', 'PushNotification.Index');
Route::post('save-push-notification-sub', [PushNotificationController::class, 'saveSubscription']);
Route::post('send-push-notification', [PushNotificationController::class, 'sendNotification']);
// End Push Notification==========================================================
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Video Link https://youtu.be/EiZPls4UcH4
// Start Roles and Permissions==================================================================
Route::get('add-permission', [RolesAndPermissionController::class, 'addPermissions']);
Route::get('show-roles', [RolesAndPermissionController::class, 'show']);
Route::get('create-roles', [RolesAndPermissionController::class, 'createRole']);
Route::post('add-role', [RolesAndPermissionController::class, 'create']);
Route::get('edit-role/{id}', [RolesAndPermissionController::class, 'editRole']);
Route::post('update-role', [RolesAndPermissionController::class, 'updateRole']);
Route::get('delete-role/{id}', [RolesAndPermissionController::class, 'delete']);
// End Roles and Permissions==================================================================


// Video Link https://youtu.be/tt4HOOQ-rCc
// Start File Management=======================================================================
Route::prefix('file-management')->controller(FileManagementController::class)->group(function () {
    Route::view('/', 'FileManagement.Index');
    Route::get('get-all', 'getAllFilesAndFolders');
    Route::post('create-file', 'createFile');
    Route::post('create-folder', 'createFolder');
    Route::post('rename', 'rename');
    Route::post('paste', 'paste');
    Route::post('zip-folder', 'zipFolder');
    Route::post('delete', 'delete');
    Route::get('download', 'download');
    Route::post('/upload', 'upload');
});
// End File Management=======================================================================


// Video Link https://youtu.be/s362UfaMKtg
// Start Auto Complete Search==============================================================
Route::prefix('auto-complete-search')->group(function () {
    Route::view('/', 'AutoCompleteSearch.index');
    Route::get('search/{query}', [CountriesController::class, 'search']);
});
// End Auto Complete Search==============================================================

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Start Live Dashboard============================================================
Route::prefix('product-transaction')->controller(ProductTransactionsController::class)->group(function () {
    Route::post('add', [ProductTransactionsController::class, 'store']);
});
Route::get('dashboard-sse', [SSEController::class, 'sseForDashboard']);
// end Live Dashboard============================================================