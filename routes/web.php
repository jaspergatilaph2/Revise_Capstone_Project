<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Applicants\ApplicantsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get('/welcome', function () {
  return view('welcome');
})->name('welcome');

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin Routes
Route::group(['middleware' => ['auth', 'IfAdmin']], function(){
  Route::get('/Dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Users Or Applicants Routes
Route::group(['middleware' =>['auth', 'IfUsers']], function(){
  Route::get('/Dashboard', [ApplicantsController::class, 'index'])->name('applicants.dashboard');

  // Apply Permit
  Route::prefix('apply')->name('apply.permit.')->group(function(){
    Route::get('/index', [ApplicantsController::class, 'ApplyIndex'])->name('index');
    Route::post('/store', [ApplicantsController::class, 'ApplyPermitIndex'])->name('permit');
  });

  // Downloads Permits
  Route::prefix('transfer')->name('applicants.downloads.')->group(function(){
    Route::get('/Downloads', [ApplicantsController::class, 'DownloadsIndex'])->name('index');
    Route::get('/Unified-application-form', [ApplicantsController::class, 'UnifiedApplicationFormDownload'])->name('unified-application-form');
    Route::get('/civil-permit', [ApplicantsController::class, 'CivilPermitDownload'])->name('civil-permit');
    Route::get('/architectural-permit', [ApplicantsController::class, 'ArchitecturalPermitDownload'])->name('architectural-permit');
    Route::get('/electrical-permit', [ApplicantsController::class, 'ElectricalPermitIndex'])->name('electrical-permit');
    Route::get('/plumbing-permit', [ApplicantsController::class, 'PlumbingPermitIndex'])->name('plumbing-permit');
  });
}); 