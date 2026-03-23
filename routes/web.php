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

  // View The Staff And Edit The staff Role
  Route::prefix('admin')->name('staff.employees.')->group(function(){
    Route::get('/view-staff', [AdminController::class, 'ViewStaffIndex'])->name('staff-view');
  });

  // Set The Maintenance Countdown
  Route::prefix('set-countdown')->name('countdown.maintenance.')->group(function(){
    Route::get('/view-countdown',[AdminController::class, 'ViewCountdownIndex'])->name('view-countdown');
    Route::post('/view-countdown/update', [AdminController::class, 'UpdateCountdownIndex'])->name('update-countdown');
  });
});

// Users Or Applicants Routes
Route::group(['middleware' => ['auth', 'IfUsers']], function () {
  Route::get('/Dashboard', [ApplicantsController::class, 'index'])->name('applicants.dashboard');

  //User View Log History Of The User Or Applicants
  Route::prefix('/record')->name('record.history.')->group(function () {
    Route::get('/log-history', [ApplicantsController::class, 'LogsIndex'])->name('log-history');
  });

  //User View And Update the User Or Applicant Accounts
  Route::prefix('accounts')->name('applicants.accounts.')->group(function () {
    Route::get('/view', [ApplicantsController::class, 'AccountsViewIndex'])->name('view');
    Route::get('/revise', [ApplicantsController::class, 'UpdateAccountsIndex'])->name('update-accounts');
    Route::put('/revise', [ApplicantsController::class, 'ReviseAccountsIndex'])->name('revise-accounts');
  });

  //User Apply Permit
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

  //User Downloads Permits
  Route::prefix('transfer')->name('applicants.downloads.')->group(function () {
    Route::get('/Downloads', [ApplicantsController::class, 'DownloadsIndex'])->name('index');
    Route::get('/Unified-application-form', [ApplicantsController::class, 'UnifiedApplicationFormDownload'])->name('unified-application-form');
    Route::get('/civil-permit', [ApplicantsController::class, 'CivilPermitDownload'])->name('civil-permit');
    Route::get('/architectural-permit', [ApplicantsController::class, 'ArchitecturalPermitDownload'])->name('architectural-permit');
    Route::get('/electrical-permit', [ApplicantsController::class, 'ElectricalPermitIndex'])->name('electrical-permit');
    Route::get('/plumbing-permit', [ApplicantsController::class, 'PlumbingPermitIndex'])->name('plumbing-permit');
    Route::get('/documents-guide', [ApplicantsController::class, 'DocumentsGuideIndex'])->name('documents');
  });

  // User Under Maintenance 
  Route::prefix('under-maintenance')->name('user.maintenance.')->group(function () {
    Route::get('/view-under-maintenance', [ApplicantsController::class, 'ViewUnderMaintenanceIndex'])->name('view-under-maintenance');
  });


  Route::prefix('options')->name('user.options.')->group(function () {
    Route::get('/view-dark-mode-options', [ApplicantsController::class, 'ViewDarkModeOptionsIndex'])->name('view-dark-mode');
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
    Route::post('/approve/{id}', [EngineerController::class, 'MarkApproveIndex'])->name('approve');
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

  // Engineer Under Maintenance
  Route::prefix('/maintenance')->name('under.maintenance.')->group(function () {
    Route::get('/under-maintenance', [EngineerController::class, 'UnderMaintenanceIndex'])->name('index');
  });

  // Engineer Inspections
  Route::prefix('/inspections')->name('engineer.inspections.')->group(function () {
    Route::get('/view-inspections', [EngineerController::class, 'ViewInspectionsIndex'])->name('view');
    Route::get('/view-scheduled-calendar', [EngineerController::class, 'ViewScheduledCalendarIndex'])->name('view-calendar');
    Route::get('/view-inspections-checklist', [EngineerController::class, 'ViewInspectionsChecklistIndex'])->name('view-checklist');
    Route::get('/view-inspections-finding', [EngineerController::class, 'ViewInspectionsFindingIndex'])->name('view-finding');
    Route::get('/view-inspections-mark-failed', [EngineerController::class, 'ViewInspectionsMarkFailedIndex'])->name('view-mark-failed');
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

  // MPDO All Permits Reviews
  Route::prefix('reviews')->name('reviews.permits.')->group(function () {
    Route::get('/view-all-permits', [MpdoController::class, 'ViewAllPermitsIndex'])->name('view-permits');
    Route::get('/view-architectural-plans', [MpdoController::class, 'ViewArchitecturalPlansIndex'])->name('view-architectural');
    Route::get('/view-structural-plans', [MpdoController::class, 'ViewStructuralPlansIndex'])->name('view-structural');
    Route::get('/view-electrical-plans', [MpdoController::class, 'ViewElectricalPlansIndex'])->name('view-electrical');
    Route::get('/view-plumbing-plans', [MpdoController::class, 'ViewPlumbingPlansIndex'])->name('view-plumbing');
    Route::get('/view-certificate-app', [MpdoController::class, 'ViewCertificateAppIndex'])->name('view-certificate');

    // Update the Status of the Permits to Under Review, Approved, and Disapproved
    Route::put('/under-review/update-status/{id}', [MpdoController::class, 'UnderReviewUpdateStatus'])->name('under-review-update-status');
    Route::put('/approved/update-status/{id}', [MpdoController::class, 'ApprovedUpdateStatus'])->name('approved-update-status');
    Route::delete('/delete-permit/{id}', [MpdoController::class, 'delete'])->name('delete');

    // MPDO Statuses in Architectural Plans
    Route::put('/under-review-architectural/update-status/{id}', [MpdoController::class, 'UnderReviewArchitecturalUpdateStatus'])
    ->name('architectural-under-review');
    Route::put('/approved-architectural/update-status/{id}', [MpdoController::class, 'ApprovedArchitecturalUpdateStatus'])
    ->name('architectural-approved');
  });

  // MPDO Adding Staff or Employees
  Route::prefix('staff')->name('staff.management.')->group(function () {
    Route::get('/view-staff', [MpdoController::class, 'ViewStaffIndex'])->name('view-staff');
    Route::get('/view-add-staff', [MpdoController::class, 'ViewAddStaffIndex'])->name('view-add-staff');

    // MPDO Store New Staff or Employees
    Route::post('/store-staff', [MpdoController::class, 'StoreStaffIndex'])->name('add-staff');
  });

  // MPDO View Logs History
  Route::prefix('logs')->name('mpdo.logs.')->group(function () {
    Route::get('/view-logs', [MpdoController::class, 'ViewLogsIndex'])->name('view-logs');
  });

  // MPDO Maintennace View
  Route::prefix('maintenance')->name('mpdo.maintenance.')->group(function(){
    Route::get('/view-maintenance', [MpdoController::class, 'ViewMaintenanceIndex'])->name('view-maintenance');
  });
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
