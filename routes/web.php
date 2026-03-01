<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Applicants\ApplicantsController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Engineer\EngineerController;
use App\Http\Controllers\Mpdo\MpdoController;
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
    Route::get('/structural-uploaded', [ApplicantsController::class, 'StructuralPlanIndex'])->name('view-structural-plan');
    Route::post('/store-structural', [ApplicantsController::class, 'StoreStructuralPlanIndex'])->name('store-structural');
    Route::get('/electrical-uploaded', [ApplicantsController::class, 'ElectricalPlanIndex'])->name('view-electrical-plan');
    Route::post('/store-electrical', [ApplicantsController::class, 'StoreElectricalPlanIndex'])->name('store-electrical');
    Route::get('/plumbing-plan', [ApplicantsController::class, 'PlumbingPlanIndex'])->name('view-plumbing-plan');
    Route::post('/store-plumbing-plan', [ApplicantsController::class, 'StorePlumbingPlanIndex'])->name('store-plumbing-plan');
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
Route::group(['middleware' => ['auth', 'IfEngineer']], function () {
  Route::get('/engineer-dashboard', [EngineerController::class, 'EngineerIndex'])->name('engineer.dashboard');

  // Engineer View Accounts or Update Accounts
  Route::prefix('/revamp')->name('revamp.accounts.')->group(function () {
    Route::get('/view', [EngineerController::class, 'ViewAccountsIndex'])->name('view');
    Route::get('/view-update', [EngineerController::class, 'ViewUpdateIndex'])->name('view-update');
    Route::put('/update', [EngineerController::class, 'UpdateIndex'])->name('update');
  });

  //Engineer Get The Applicants
  Route::prefix('/candidate')->name('candidate.applicants.')->group(function () {
    Route::get('/view-applicants', [EngineerController::class, 'ViewApplicantsIndex'])->name('view');
    Route::get('/view-uploaded-documents', [EngineerController::class, 'ViewUploadedIndex'])->name('view-documents');
    Route::get('/view-approval', [EngineerController::class, 'ViewApprovalIndex'])->name('view-approval');
    Route::post('/under-review/{id}', [EngineerController::class, 'MarkUnderReviewIndex'])->name('under-review');
  });

  // Engineer Recent Activities
  Route::prefix('/activities')->name('recents.activities.')->group(function () {
    Route::get('/activity', [EngineerController::class, 'ActvitiesIndex'])->name('view');
  });

  // Engineer Review Plan
  Route::prefix('review')->name('review.proposal.')->group(function () {
    Route::get('/review-architectural-plan', [EngineerController::class, 'ReviewArchitecturalPlanIndex'])->name('review-architectural-plan');
    Route::get('/review-structural-plan', [EngineerController::class, 'StructuralPlanIndex'])->name('review-structural-plan');
    Route::get('/electrical-plan', [EngineerController::class, 'ElectricalPlanIndex'])->name('review-electrical-plan');
    Route::get('/plumbing-plan', [EngineerController::class, 'PlumbingPlanIndex'])->name('review-plumbing-plan');
    // Architectural Plan Review Actions
    Route::post('/under-review/{id}', [EngineerController::class, 'UnderReviewIndex'])->name('under-review');
    Route::post('/approve/{id}', [EngineerController::class, 'ApproveIndex'])->name('approve');
    Route::delete('/delete/{id}', [EngineerController::class, 'DeleteIndex'])->name('delete');
    // Structural Plan Review Actions
    Route::post('/under-review-structural/{id}', [EngineerController::class, 'UnderReviewStructuralIndex'])->name('under-review-structural');
    Route::post('/approve-structural/{id}', [EngineerController::class, 'ApproveStructuralIndex'])->name('approve-electrical');
    Route::delete('/delete-structural/{id}', [EngineerController::class, 'DeleteStructuralIndex'])->name('delete-structural');
    // Electrical Plan Review Actions
    Route::post('/under-review-electrical/{id}', [EngineerController::class, 'UnderReviewElectricalIndex'])->name('under-review-electrical');
    Route::post('/approve-electrical/{id}', [EngineerController::class, 'ApproveElectricalIndex'])->name('approve-electrical');
    Route::delete('/delete-electrical/{id}', [EngineerController::class, 'DeleteElectricalIndex'])->name('delete-electrical');
    // Plumbing Plan Review Actions
    Route::post('/under-review-plumbing/{id}', [EngineerController::class, 'UnderReviewPlumbingIndex'])->name('under-review-plumbing');
    Route::post('/approve-plumbing/{id}', [EngineerController::class, 'ApprovePlumbingIndex'])->name('approve-plumbing');
    Route::delete('/delete-plumbing/{id}', [EngineerController::class, 'DeletePlumbingIndex'])->name('delete-plumbing');
  });

  // Engineer Logs History
  Route::prefix('/logs')->name('logs.history.')->group(function () {
    Route::get('/view-history', [EngineerController::class, 'ViewHistoryIndex'])->name('view');
  });
});

// MPDO ROUTES
Route::group(['middleware' => 'auth', 'IfMpdo'], function () {
  Route::get('/Mpdo-dashboard', [MpdoController::class, 'MpdoIndex'])->name('mpdo.dashboard');

  // MPDO View Accounts
  Route::prefix('details')->name('details.accounts.')->group(function () {
    Route::get('/view-accounts', [MpdoController::class, 'ViewAccoutsIndex'])->name('view');
    Route::get('/update-accounts', [MpdoController::class, 'UpdateAccountsIndex'])->name('update');
    Route::put('/revise-accounts', [MpdoController::class, 'ReviseAccountsIndex'])->name('revise');
  });
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
