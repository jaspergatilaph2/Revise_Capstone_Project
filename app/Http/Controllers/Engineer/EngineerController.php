<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalPlan;
use App\Models\User;
use App\Models\PermitApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\StructuralPlan;
use App\Models\LogsHistory;
use App\Models\DeletedPlanFile;
use App\Models\ElectricalPlans;
use App\Models\PlumbingPlan;
use PhpParser\Node\Expr\BinaryOp\Plus;

class EngineerController extends Controller
{
    // Engineer Index Dashboard
    public function EngineerIndex()
    {
        $currentUser = Auth::user();

        // ===============================
        // Counting
        // ===============================
        $totalApplications = PermitApplication::count();
        $PendingApplications = PermitApplication::where('status', 'pending')->count();
        $UnderReviewApplications = PermitApplication::where('status', 'under_review')->count();
        $ApprovedApplication = PermitApplication::where('status', 'approved')->count();

        // ===============================
        // Activity Chart (Last 7 Days)
        // ===============================
        $weeklyApplications = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $weeklyApplications[] = [
                'date' => $date->format('D'), // Mon, Tue, etc.
                'count' => PermitApplication::whereDate('created_at', $date)->count(),
            ];
        }

        // ===============================
        // Recent Activity (Users + Plans)
        // ===============================
        $recentUsers = User::with([
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan'
        ])
            ->where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('Engineer.Dashboard.index', compact(
            'currentUser',
            'recentUsers',
            'totalApplications',
            'PendingApplications',
            'UnderReviewApplications',
            'ApprovedApplication',
            'weeklyApplications'
        ));
    }


    // Engineer View Accounts
    public function ViewAccountsIndex()
    {
        $accounts = Auth::user();
        return view(
            'Engineer.Accounts.view',
            compact('accounts'),
            [
                'ActiveTabMenu' => 'View',
                'SubActiveTab' => 'Accounts'
            ]
        );
    }

    // Engineer Viewing Update Accounts
    public function ViewUpdateIndex()
    {
        $currentUser = Auth::user();
        return view(
            'Engineer.Accounts.update',
            compact('currentUser'),
            [
                'ActiveTabMenu' => 'View-Update',
                'SubActiveTab' => 'Accounts'
            ]
        );
    }

    // Engineer Update Accounts
    public function UpdateIndex(Request $request)
    {
        $accounts = Auth::user();

        // Ensure $accounts is an instance of App\Models\User
        if (!($accounts instanceof User)) {
            $accounts = User::findOrFail(Auth::id());
        }

        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $accounts->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update basic fields
        $accounts->name = $request->name;
        $accounts->email = $request->email;

        // Handle avatar if uploaded
        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('avatars'), $filename);
            $accounts->avatar = 'avatars/' . $filename;
        }

        $accounts->save();

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Updated account profile information.',
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Engineeri View Applicants
    public function ViewApplicantsIndex()
    {
        $currentUser = Auth::user();

        // Fetch all users with role 'user' and their permit applications
        $users = User::where('role', 'user')
            ->with('permitApplications')
            ->get();

        // Transform each user's permitApplications to add document URLs
        $permitApplications = PermitApplication::whereIn('status', ['pending', 'under_review', 'approved', 'rejected'])
            ->select('id', 'user_id', 'project_name', 'location', 'address', 'radiusRange', 'status', 'documents', 'created_at', 'description')
            ->get();

        // Add document URLs safely
        $users->each(function ($user) {
            $user->permitApplications->transform(function ($permit) {
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    // Ensure it's an array
                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        // Remove any escaped slashes or quotes
                        $doc = str_replace(['\\', '"'], '', $doc);

                        // Generate proper URL using 'public' disk
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;

                return $permit;
            });

            return $user;
        });


        return view(
            'Engineer.Applicants.index',
            compact('users', 'currentUser', 'permitApplications'),
            [
                'ActiveTabMenu' => 'View-Applicants',
                'SubActiveTab' => 'Dashboard'
            ]
        );
    }

    // Engineer View Activities
    public function ActvitiesIndex()
    {
        $currentUser = Auth::user();

        $users = User::with([
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan'
        ])
            ->where('role', 'user')
            ->latest()
            ->get();


        return view('Engineer.Activities.index', compact('users', 'currentUser'));
    }

    // View Uploaded Documents
    public function ViewUploadedIndex()
    {
        $currentUser = Auth::user();
        $users = User::with('permitApplications')
            ->where('role', 'user')
            ->latest()
            ->get();

        $permitApplications = PermitApplication::whereIn('status', ['pending', 'under_review', 'approved', 'rejected'])
            ->select('id', 'user_id', 'project_name', 'location', 'address', 'radiusRange', 'status', 'documents', 'created_at', 'description')
            ->get();

        // Add document URLs safely
        $users->each(function ($user) {
            $user->permitApplications->transform(function ($permit) {
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    // Ensure it's an array
                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        // Remove any escaped slashes or quotes
                        $doc = str_replace(['\\', '"'], '', $doc);

                        // Generate proper URL using 'public' disk
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;

                return $permit;
            });

            return $user;
        });

        return view(
            'Engineer.Applicants.view-uploaded',
            compact('currentUser', 'users', 'permitApplications'),
            [
                'ActiveTabMenu' => 'View-Uploaded',
                'SubActiveTab' => 'Documents'
            ]
        );
    }

    // Review Architectural Plan
    public function ReviewArchitecturalPlanIndex()
    {
        $currentUser = Auth::user();

        $users = User::with([
            'permitApplications:id,user_id,project_name,status',
            'permitApplications.architecturalPlans:id,permit_application_id,plan_name,file_path'
        ])
            ->where('role', 'user')
            ->latest()
            ->get();


        // Transform everything properly
        $users->each(function ($user) {

            $user->permitApplications->transform(function ($permit) {

                // ===============================
                // PERMIT DOCUMENTS
                // ===============================
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        $doc = str_replace(['\\', '"'], '', $doc);
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;


                // ===============================
                // ARCHITECTURAL PLANS
                // ===============================
                $permit->architecturalPlans->transform(function ($plan) {

                    $planUrls = [];

                    if ($plan->file_path) {

                        $files = is_array($plan->file_path)
                            ? $plan->file_path
                            : json_decode($plan->file_path, true);

                        if (!is_array($files)) {
                            $files = [$plan->file_path];
                        }

                        foreach ($files as $file) {
                            $file = str_replace(['\\', '"'], '', $file);

                            // If stored in storage/app/public
                            $planUrls[] = Storage::url($file);
                        }
                    }

                    $plan->file_urls = $planUrls;

                    return $plan;
                });

                return $permit;
            });

            return $user;
        });

        return view(
            'Engineer.Review.architectural-plan',
            compact('currentUser', 'users'),
            [
                'ActiveTabMenu' => 'View-Architectural',
                'SubActiveTab' => 'Plan'
            ]
        );
    }

    // View Structural Plan
    public function StructuralPlanIndex()
    {
        $currentUser = Auth::user();

        $users = User::with([
            'permitApplications:id,user_id,project_name,status',
            'permitApplications.structuralPlans:id,permit_application_id,plan_name,documents'
        ])
            ->where('role', 'user')
            ->latest()
            ->get();

        // Transform everything properly
        $users->each(function ($user) {

            $user->permitApplications->transform(function ($permit) {

                // ===============================
                // PERMIT DOCUMENTS
                // ===============================
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        $doc = str_replace(['\\', '"'], '', $doc);
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;


                // ===============================
                // ARCHITECTURAL PLANS
                // ===============================
                $permit->architecturalPlans->transform(function ($plan) {

                    $planUrls = [];

                    if ($plan->file_path) {

                        $files = is_array($plan->file_path)
                            ? $plan->file_path
                            : json_decode($plan->file_path, true);

                        if (!is_array($files)) {
                            $files = [$plan->file_path];
                        }

                        foreach ($files as $file) {
                            $file = str_replace(['\\', '"'], '', $file);

                            // If stored in storage/app/public
                            $planUrls[] = Storage::url($file);
                        }
                    }

                    $plan->file_urls = $planUrls;

                    return $plan;
                });

                return $permit;
            });

            return $user;
        });

        return view(
            'Engineer.Review.structural-plan',
            compact('currentUser', 'users'),
            [
                'ActiveTabMenu' => 'View-Structural',
                'SubActiveTab' => 'Plan'
            ]
        );
    }

    // Engineer Logs History View
    public function ViewHistoryIndex()
    {
        $currentUser = Auth::user();

        $logs = LogsHistory::where('user_id', $currentUser->id)
            ->latest()
            ->paginate(10);

        return view(
            'Engineer.History.log-history',
            [
                'logs' => $logs,
                'currentUser' => $currentUser,
                'ActiveTabMenu' => 'View-Logs',
                'SubActiveTab' => 'History'
            ]
        );
    }

    // Engineer View Electrical Plan
    public function ElectricalPlanIndex()
    {
        $currentUser = Auth::user();
        $users = User::with([
            'permitApplications:id,user_id,project_name,status',
            'permitApplications.electricalPlans:id,permit_application_id,plan_name,documents'
        ])
            ->where('role', 'user')
            ->latest()
            ->get();

        // Transform everything properly
        $users->each(function ($user) {

            $user->permitApplications->transform(function ($permit) {

                // ===============================
                // PERMIT DOCUMENTS
                // ===============================
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        $doc = str_replace(['\\', '"'], '', $doc);
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;



                // ===============================
// ELECTRICAL PLANS
// ===============================
                $permit->electricalPlans->transform(function ($plan) {

                    $planUrls = [];

                    if ($plan->documents) {

                        $files = is_array($plan->documents)
                            ? $plan->documents
                            : json_decode($plan->documents, true);

                        if (!is_array($files)) {
                            $files = [$plan->documents];
                        }

                        foreach ($files as $file) {

                            $file = str_replace(['\\', '"'], '', $file);

                            // If files are stored inside:
                            // storage/app/public/electrical_plans/
                            $planUrls[] = Storage::url('electrical_plans/' . $file);
                        }
                    }

                    $plan->file_urls = $planUrls;

                    return $plan;
                });

                return $permit;
            });

            return $user;
        });

        return view(
            'Engineer.Review.electrical-plan',
            compact('currentUser', 'users'),
            [
                'ActiveTabMenu' => 'View-Electrical',
                'SubActiveTab' => 'Plan'
            ]
        );
    }

    // Engineer View Approval documents
    public function ViewApprovalIndex()
    {
        $currentUser = Auth::user();

        // Fetch all users with role 'user' and their permit applications
        $users = User::where('role', 'user')
            ->with('permitApplications')
            ->get();

        // Transform each user's permitApplications to add document URLs
        $permitApplications = PermitApplication::whereIn('status', ['pending', 'under_review', 'approved', 'rejected'])
            ->select('id', 'user_id', 'project_name', 'location', 'address', 'radiusRange', 'status', 'documents', 'created_at', 'description')
            ->get();

        // Add document URLs safely
        $users->each(function ($user) {
            $user->permitApplications->transform(function ($permit) {
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    // Ensure it's an array
                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        // Remove any escaped slashes or quotes
                        $doc = str_replace(['\\', '"'], '', $doc);

                        // Generate proper URL using 'public' disk
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;

                return $permit;
            });

            return $user;
        });


        return view(
            'Engineer.Applicants.approval-applicants',
            compact('users', 'currentUser', 'permitApplications'),
            [
                'ActiveTabMenu' => 'View-Applicants',
                'SubActiveTab' => 'Dashboard'
            ]
        );
    }

    // Engineer Mark Under Review
    public function MarkUnderReviewIndex($id)
    {
        $currentUser = Auth::user();

        $permit = PermitApplication::findOrFail($id);

        if ($permit->status !== 'under_review') {

            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked as Under Review.');
    }

    // Engineer View Plumbing Plan
    public function PlumbingPlanIndex()
    {
        $currentUser = Auth::user();
        $users = User::with([
            'permitApplications:id,user_id,project_name,status',
            'permitApplications.plumbingPlan:id,permit_application_id,plan_name,documents'
        ])
            ->where('role', 'user')
            ->latest()
            ->get();

        // Transform everything properly
        $users->each(function ($user) {

            $user->permitApplications->transform(function ($permit) {

                // ===============================
                // PERMIT DOCUMENTS
                // ===============================
                $documentUrls = [];

                if ($permit->documents) {
                    $docs = json_decode($permit->documents, true);

                    if (!is_array($docs)) {
                        $docs = [$permit->documents];
                    }

                    foreach ($docs as $doc) {
                        $doc = str_replace(['\\', '"'], '', $doc);
                        $documentUrls[] = Storage::url($doc);
                    }
                }

                $permit->document_urls = $documentUrls;



                // ===============================
// ELECTRICAL PLANS
// ===============================
                $permit->plumbingPlan->transform(function ($plan) {

                    $planUrls = [];

                    if ($plan->documents) {

                        $files = is_array($plan->documents)
                            ? $plan->documents
                            : json_decode($plan->documents, true);

                        if (!is_array($files)) {
                            $files = [$plan->documents];
                        }

                        foreach ($files as $file) {

                            $file = str_replace(['\\', '"'], '', $file);

                            // If files are stored inside:
                            // storage/app/public/electrical_plans/
                            $planUrls[] = Storage::url('plumbing_plans/' . $file);
                        }
                    }

                    $plan->file_urls = $planUrls;

                    return $plan;
                });

                return $permit;
            });

            return $user;
        });

        return view(
            'Engineer.Review.plumbing-plan',
            compact('currentUser', 'users'),
            [
                'ActiveTabMenu' => 'View-Plumbing',
                'SubActiveTab' => 'Plan'
            ]
        );
    }

    // Engineer Mark Under Review Achitectural Plan
    public function UnderReviewIndex($id)
    {
        $currentUser = Auth::user();
        $permit = ArchitecturalPlan::findOrFail($id);

        if ($permit->status !== 'under_review') {
            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'engineer' ? $currentUser->id : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked under review successfully.');
    }

    // Engineer Mark Approved Architectural Plan
    public function ApproveIndex($id)
    {
        $currentUser = Auth::user();

        $permit = ArchitecturalPlan::findOrFail($id);

        if ($permit->status !== 'approved') {

            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit approved successfully.');
    }

    // Engineer Delete Architectural Plan
    public function DeleteIndex($id)
    {
        $plan = ArchitecturalPlan::findOrFail($id); // change model accordingly

        // Save deleted plan info to new table
        DeletedPlanFile::create([
            'permit_application_id' => $plan->permit_application_id,
            'plan_name' => $plan->plan_name,
            'file_path' => $plan->file_path, // you can store JSON if multiple files
            'deleted_by' => Auth::id(),
        ]);

        // Delete original plan
        $plan->delete();

        return back()->with('success', 'Plan deleted and logged successfully.');
    }

    // Engineer Mark Under Review Structural Plan
    public function UnderReviewStructuralIndex($id)
    {
        $currentUser = Auth::user();

        $permit = StructuralPlan::findOrFail($id);

        if ($permit->status !== 'under_review') {

            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked under review successfully.');
    }

    // Engineer Mark Approved Structural Plan
    public function ApproveStructuralIndex($id)
    {
        $currentUser = Auth::user();

        $permit = StructuralPlan::findOrFail($id);

        if ($permit->status !== 'approved') {

            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit approved successfully.');
    }

    // Engineer Delete Structural Plan
    public function DeleteStructuralIndex($id)
    {
        $plan = StructuralPlan::findOrFail($id); // change model accordingly

        // Save deleted plan info to new table
        DeletedPlanFile::create([
            'permit_application_id' => $plan->permit_application_id,
            'plan_name' => $plan->plan_name,
            'file_path' => $plan->file_path, // you can store JSON if multiple files
            'deleted_by' => Auth::id(),
        ]);

        // Delete original plan
        $plan->delete();

        return back()->with('success', 'Plan deleted and logged successfully.');
    }

    // Engineer Mark Under Review Electrical Plan
    public function UnderReviewElectricalIndex($id)
    {
        $currentUser = Auth::user();

        $permit = ElectricalPlans::findOrFail($id);

        if ($permit->status !== 'under_review') {

            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked under review successfully.');
    }

    // Engineer Mark Approved Electrical Plan
    public function ApproveElectricalIndex($id)
    {
        $currentUser = Auth::user();

        $permit = ElectricalPlans::findOrFail($id);

        if ($permit->status !== 'approved') {

            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit approved successfully.');
    }

    // Engineer Delete Electrical Plan
    public function DeleteElectricalIndex($id)
    {
        $plan = ElectricalPlans::findOrFail($id); // change model accordingly

        // Save deleted plan info to new table
        DeletedPlanFile::create([
            'permit_application_id' => $plan->permit_application_id,
            'plan_name' => $plan->plan_name,
            'file_path' => $plan->file_path, // you can store JSON if multiple files
            'deleted_by' => Auth::id(),
        ]);

        // Delete original plan
        $plan->delete();

        return back()->with('success', 'Plan deleted and logged successfully.');
    }

    // Engineer Mark Under Review Plumbing Plan
    public function UnderReviewPlumbingIndex($id)
    {
        $currentUser = Auth::user();

        $permit = PlumbingPlan::findOrFail($id);

        if ($permit->status !== 'under_review') {

            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked under review successfully.');
    }

    // Engineer Mark Approved Plumbing Plan
    public function ApprovePlumbingIndex($id)
    {
        $currentUser = Auth::user();

        $permit = PlumbingPlan::findOrFail($id);

        if ($permit->status !== 'approved') {

            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit approved successfully.');
    }

    // Engineer Delete Plumbing Plan
    public function DeletePlumbingIndex($id)
    {
        $plan = PlumbingPlan::findOrFail($id); // change model accordingly

        // Save deleted plan info to new table
        DeletedPlanFile::create([
            'permit_application_id' => $plan->permit_application_id,
            'plan_name' => $plan->plan_name,
            'file_path' => $plan->file_path, // you can store JSON if multiple files
            'deleted_by' => Auth::id(),
        ]);

        // Delete original plan
        $plan->delete();

        return back()->with('success', 'Plan deleted and logged successfully.');
    }
}