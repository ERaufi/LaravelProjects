<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CustomHelperController;
use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SSEController;
use App\Http\Controllers\WeatherController;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Minishlink\WebPush\VAPID;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'success';
});

// Video Link https://youtu.be/KzZR9A7Xk14
// Start Full Calender=================================================================
Route::get('fullcalender', [ScheduleController::class, 'index'])->middleware('permission:Full Calendar');
Route::get('/events', [ScheduleController::class, 'getEvents'])->middleware('permission:Full Calendar');
Route::get('/schedule/delete/{id}', [ScheduleController::class, 'deleteEvent'])->middleware('permission:Full Calendar');
Route::post('/schedule/{id}', [ScheduleController::class, 'update'])->middleware('permission:Full Calendar');
Route::post('/schedule/{id}/resize', [ScheduleController::class, 'resize'])->middleware('permission:Full Calendar');
Route::get('/events/search', [ScheduleController::class, 'search'])->middleware('permission:Full Calendar');

Route::view('add-schedule', 'schedule.add')->middleware('permission:Full Calendar');
Route::post('create-schedule', [ScheduleController::class, 'create'])->middleware('permission:Full Calendar');
// End Full Calender=================================================================



// Video Link https://youtu.be/SdwA3YKW35g
//Start Drop Zone Routes==============================================================
Route::view('drop-zone', 'DropZone.index')->middleware('permission:Drop Zone');
Route::post('/drop-zone', [DropZoneController::class, 'upload'])->middleware('permission:Drop Zone');
//End Drop Zone Routes==============================================================


// Video Link https://youtu.be/7nvN0q77P-k
//Start Auto-Suggest Search==============================================================
Route::view('auto-suggest', 'AutoSuggest.index')->middleware('permission:Auto-Suggest Search');
Route::get('/search', [ProductsController::class, 'search'])->middleware('permission:Auto-Suggest Search');
//End Auto-Suggest Search==============================================================



// Video Link https://youtu.be/5eG3PIriMgU
//start Lazy Load======================================================================
Route::view('lazy-load', 'LazyLoad.index')->middleware('permission:Lazy Load');
Route::get('/lazy-load-data', [DropZoneController::class, 'index'])->middleware('permission:Lazy Load');
//End Lazy Load======================================================================


// Video Link https://youtu.be/BKPkN7XEwxA
//Start Excel Import and Export========================================================
Route::view('import-export', 'ImportExport.index')->middleware('permission:Excel Import and Export');
Route::get('prodcts/export/', [ProductsController::class, 'export'])->middleware('permission:Excel Import and Export');
Route::post('/products/import', [ProductsController::class, 'import'])->middleware('permission:Excel Import and Export');
//End Excel Import and Export========================================================


// video Link https://youtu.be/my9XgQHQoKM
// Start PDF Generate===================================================================
Route::get('generate-pdf', [ProductsController::class, 'generatePDF'])->middleware('permission:PDF Generate');
// End PDF Generate===================================================================


// Video Link https://youtu.be/gVP0EIS5j5A
// Start CRUD===========================================================================
Route::resource('products', ProductsController::class)->middleware('permission:CRUD');
// End CRUD===========================================================================



// video Link https://youtu.be/6tEsCSatPXE
// Start CSV Import and Export===========================================================
Route::view('csv', 'ImportExport.csv')->middleware('permission:CSV Import and Export');
Route::get('export-csv', [ProductsController::class, 'exportToCSV'])->middleware('permission:CSV Import and Export');
Route::post('import-csv', [ProductsController::class, 'importCSV'])->middleware('permission:CSV Import and Export');
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
Route::view('weather', 'Weather.index')->middleware('permission:Weather');
Route::get('get-weather', [WeatherController::class, 'index'])->middleware('permission:Weather');
// End Weather========================================================================


// Video Link https://youtu.be/E40z1dDL0YY
// Start Encrypt and Decrypt===========================================================
Route::get('notes', [NotesController::class, 'index'])->middleware('permission:Encrypt and Decrypt');
Route::get('notes/create', [NotesController::class, 'create'])->middleware('permission:Encrypt and Decrypt');
Route::post('notes/store', [NotesController::class, 'store'])->middleware('permission:Encrypt and Decrypt');
Route::get('notes/{note}', [NotesController::class, 'show'])->middleware('permission:Encrypt and Decrypt');
Route::get('notes/{note}/edit', [NotesController::class, 'edit'])->middleware('permission:Encrypt and Decrypt');
Route::put('notes/{note}', [NotesController::class, 'update'])->middleware('permission:Encrypt and Decrypt');
Route::delete('notes/{note}', [NotesController::class, 'destroy'])->middleware('permission:Encrypt and Decrypt');
// End Encrypt and Decrypt=============================================================

// Video Link https://youtu.be/VXFSe-D5SCA
// Start Form Builder===============================================================
// Step 1
Route::get('form-builder', [FormBuilderController::class, 'index'])->middleware('permission:Form Builder');
// Step 2
Route::view('formbuilder', 'FormBuilder.create')->middleware('permission:Form Builder');
// Step 3
Route::post('save-form-builder', [FormBuilderController::class, 'create'])->middleware('permission:Form Builder');
// Step 4
Route::delete('form-delete/{id}', [FormBuilderController::class, 'destroy'])->middleware('permission:Form Builder');

// Step 5
Route::view('edit-form-builder/{id}', 'FormBuilder.edit')->middleware('permission:Form Builder');
Route::get('get-form-builder-edit', [FormBuilderController::class, 'editData'])->middleware('permission:Form Builder');
Route::post('update-form-builder', [FormBuilderController::class, 'update'])->middleware('permission:Form Builder');

// Step 6
Route::view('read-form-builder/{id}', 'FormBuilder.read')->middleware('permission:Form Builder');
Route::get('get-form-builder', [FormsController::class, 'read'])->middleware('permission:Form Builder');
Route::post('save-form-transaction', [FormsController::class, 'create'])->middleware('permission:Form Builder');

// End Form Builder===============================================================


// Video Link https://youtu.be/zT3somYJGAE
// Start Image Cropper=============================================================
Route::view('crop', 'cropperjs.index')->middleware('permission:Image Cropper');
Route::post('/upload-cropped-image', [DropZoneController::class, 'uploadCroppedImage'])->middleware('permission:Image Cropper');

// End Image Cropper===============================================================

// Video Link https://youtu.be/wNQxHo7Xj6M
// Start Laravel Dusk Test=======================================================
Route::view('dusk-test', 'Dusk.index')->middleware('permission:Laravel Dusk Test');
// End Laravel Dusk Test========================================================

// Video Link https://youtu.be/RRS7zW2SwIg
// Start Jquery Datatable========================================================
Route::view('datatable', 'Datatable.index')->middleware('permission:Jquery Datatable');
Route::get('countries', [CountriesController::class, 'index'])->middleware('permission:Jquery Datatable');
Route::post('countries/update', [CountriesController::class, 'update'])->middleware('permission:Jquery Datatable');
Route::post('countries/reordering', [CountriesController::class, 'reOrder'])->middleware('permission:Jquery Datatable');
// End Jquery Datatable==========================================================

// Video Link https://youtu.be/ZrabCjtIaCg
//Start Change Langauge (Localization)=============================================================
Route::post('change-lang', [LanguageController::class, 'change'])->middleware('permission:Change Language');
// End Change Language (Localization)========================================================

// Video Link https://youtu.be/A7I8r3Fhrww
// Start Laravel SSE (Real time Notification)============================================
Route::get('send-notification', [NotificationsController::class, 'index'])->middleware(['auth', 'permission:Laravel SSE (Real time Notification)']);
Route::post('create-notification', [NotificationsController::class, 'create'])->middleware('permission:Laravel SSE (Real time Notification)');
Route::get('/sse-updates', [SSEController::class, 'sendSSE'])->middleware('permission:Laravel SSE (Real time Notification)');
// End Laravel SSE (Real time Notification)==============================================


// Video Link https://youtu.be/Dcnud0U5-6E
// Start Chat Application===============================================================
// Route::view('chat', 'Chat.Index');
// Route::get('chats', [ChatsController::class, 'index']);
Route::get('communications', [ChatsController::class, 'index'])->middleware(['auth', 'permission:Chat Application']);
Route::post('send-message', [ChatsController::class, 'sendMessage'])->middleware('permission:Chat Application');
Route::get('get-new-messages/{user_id}', [ChatsController::class, 'getNewMessages'])->middleware('permission:Chat Application');
Route::get('communication-history', [ChatsController::class, 'getChatHistory'])->middleware('permission:Chat Application');
Route::post('upload-communication-photo', [ChatsController::class, 'uploadImage'])->middleware('permission:Chat Application');
// End Chat Application=================================================================

// Video Link https://youtu.be/5F_gRvkCoNM
// Start Custom Helper===============================================================
Route::get('custome-helper', [CustomHelperController::class, 'index'])->middleware('permission:Custom Helper');
// End Custom Helper===============================================================

// Video Link https://youtu.be/AOLigc0T5tc
// Start Push Notification==========================================================
Route::view('push-notification', 'PushNotification.Index')->middleware('permission:Push Notification');
Route::post('save-push-notification-sub', [PushNotificationController::class, 'saveSubscription'])->middleware('permission:Push Notification');
Route::post('send-push-notification', [PushNotificationController::class, 'sendNotification'])->middleware('permission:Push Notification');
// End Push Notification==========================================================
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Start Roles and Permissions==================================================================
Route::get('add-permission', [RolesAndPermissionController::class, 'addPermissions']);
Route::get('show-roles', [RolesAndPermissionController::class, 'show']);
Route::get('create-roles', [RolesAndPermissionController::class, 'createRole']);
Route::post('add-role', [RolesAndPermissionController::class, 'create']);
Route::get('edit-role/{id}', [RolesAndPermissionController::class, 'editRole']);
Route::post('update-role', [RolesAndPermissionController::class, 'updateRole']);
Route::get('delete-role/{id}', [RolesAndPermissionController::class, 'delete']);
// End Roles and Permissions==================================================================