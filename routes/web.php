<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Applicants\ApplicantsController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Engineer\EngineerController;
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
Route::group(['middleware' => ['auth', 'IfAdmin']], function () {
  Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Users Or Applicants Routes
Route::group(['middleware' => ['auth', 'IfUsers']], function () {
  Route::get('/Dashboard', [ApplicantsController::class, 'index'])->name('applicants.dashboard');

  // View Log History Of The User Or Applicants
  Route::prefix('/record')->name('record.history.')->group(function () {
    Route::get('/log-history', [ApplicantsController::class, 'LogsIndex'])->name('log-history');
  });

  // View And Update the User Or Applicant Accounts
  Route::prefix('accounts')->name('applicants.accounts.')->group(function () {
    Route::get('/view', [ApplicantsController::class, 'AccountsViewIndex'])->name('view');
    Route::get('/revise', [ApplicantsController::class, 'UpdateAccountsIndex'])->name('update-accounts');
    Route::put('/revise', [ApplicantsController::class, 'ReviseAccountsIndex'])->name('revise-accounts');
  });

  // Apply Permit
  Route::prefix('apply')->name('apply.permit.')->group(function () {
    Route::get('/index', [ApplicantsController::class, 'ApplyIndex'])->name('index');
    Route::post('/store', [ApplicantsController::class, 'ApplyPermitIndex'])->name('permit');
    Route::get('/pending', [ApplicantsController::class, 'PendingPermitIndex'])->name('pending');
    Route::get('/architectural-uploaded', [ApplicantsController::class, 'ArchitecturalUploadIndex'])->name('view-architectural');
    Route::post('/store-architectural', [ApplicantsController::class, 'ArchitecturalStoreIndex'])->name('store-architectural');
  });

  // Downloads Permits
  Route::prefix('transfer')->name('applicants.downloads.')->group(function () {
    Route::get('/Downloads', [ApplicantsController::class, 'DownloadsIndex'])->name('index');
    Route::get('/Unified-application-form', [ApplicantsController::class, 'UnifiedApplicationFormDownload'])->name('unified-application-form');
    Route::get('/civil-permit', [ApplicantsController::class, 'CivilPermitDownload'])->name('civil-permit');
    Route::get('/architectural-permit', [ApplicantsController::class, 'ArchitecturalPermitDownload'])->name('architectural-permit');
    Route::get('/electrical-permit', [ApplicantsController::class, 'ElectricalPermitIndex'])->name('electrical-permit');
    Route::get('/plumbing-permit', [ApplicantsController::class, 'PlumbingPermitIndex'])->name('plumbing-permit');
    Route::get('/documents-guide', [ApplicantsController::class, 'DocumentsGuideIndex'])->name('documents');
  });
});

// Engineer Routes
Route::group(['middleware' => ['auth', 'IfEngineer']], function(){
  Route::get('/engineer-dashboard', [EngineerController::class, 'EngineerIndex'])->name('engineer.dashboard');

  // Engineer View Accounts or Update Accounts
  Route::prefix('/revamp')->name('revamp.accounts.')->group(function(){
    Route::get('/view', [EngineerController::class, 'ViewAccountsIndex'])->name('view');
    Route::get('/view-update', [EngineerController::class, 'ViewUpdateIndex'])->name('view-update');
    Route::put('/update', [EngineerController::class, 'UpdateIndex'])->name('update');
  });

  //Engineer Get The Applicants
  Route::prefix('/candidate')->name('candidate.applicants.')->group(function(){
    Route::get('/view-applicants', [EngineerController::class, 'ViewApplicantsIndex'])->name('view');
    Route::get('/view-uploaded-documents', [EngineerController::class, 'ViewUploadedIndex'])->name('view-documents');
  });

  // Engineer Recent Activities
  Route::prefix('/activities')->name('recents.activities.')->group(function(){
    Route::get('/activity', [EngineerController::class, 'ActvitiesIndex'])->name('view');
  });
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
