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
        // Counting Applications
        // ===============================
        $UserCounts = User::where('role', 'user')->count();
        $totalApplications = PermitApplication::count();
        $PendingApplications = PermitApplication::where('status', 'pending')->count();
        $UnderReviewApplications = PermitApplication::where('status', 'under_review')->count();
        $ApprovedApplication = PermitApplication::where('status', 'approved')->count();

        // ===============================
        // Counting Applications And Plans
        // ===============================
        $totalPermitApplications = PermitApplication::count();
        $totalArchitecturalPlans = ArchitecturalPlan::count();
        $totalStructuralPlans = StructuralPlan::count();
        $totalElectricalPlans = ElectricalPlans::count();
        $totalPlumbingPlans = PlumbingPlan::count();

        // ===============================
        // Counting Applications And Plans by the status "Pending"
        // ===============================
        $PendingApplications = PermitApplication::where('status', 'pending')->count();
        $pendingArchitecturalPlans = ArchitecturalPlan::where('status', 'pending')->count();
        $pendingStructuralPlans = StructuralPlan::where('status', 'pending')->count();
        $pendingElectricalPlans = ElectricalPlans::where('status', 'pending')->count();
        $pendingPlumbingPlans = PlumbingPlan::where('status', 'pending')->count();

        // ===============================
        // Counting Applications And Plans by the status "Under Review"
        // ===============================
        $UnderReviewApplications = PermitApplication::where('status', 'under_review')->count();
        $underReviewArchitecturalPlans = ArchitecturalPlan::where('status', 'under_review')->count();
        $underReviewStructuralPlans = StructuralPlan::where('status', 'under_review')->count();
        $underReviewElectricalPlans = ElectricalPlans::where('status', 'under_review')->count();
        $underReviewPlumbingPlans = PlumbingPlan::where('status', 'under_review')->count();

        // ===============================
        // Counting Applications And Plans by the status "Approved"
        // ===============================
        $ApprovedApplication = PermitApplication::where('status', 'approved')->count();
        $approvedArchitecturalPlans = ArchitecturalPlan::where('status', 'approved')->count();
        $approvedStructuralPlans = StructuralPlan::where('status', 'approved')->count();
        $approvedElectricalPlans = ElectricalPlans::where('status', 'approved')->count();
        $approvedPlumbingPlans = PlumbingPlan::where('status', 'approved')->count();

        // ===============================
        // Counting Applications And Plans by the status "Rejected"
        // ===============================
        $RejectedApplication = PermitApplication::where('status', 'rejected')->count();
        $rejectedArchitecturalPlans = ArchitecturalPlan::where('status', 'rejected')->count();
        $rejectedStructuralPlans = StructuralPlan::where('status', 'rejected')->count();
        $rejectedElectricalPlans = ElectricalPlans::where('status', 'rejected')->count();
        $rejectedPlumbingPlans = PlumbingPlan::where('status', 'rejected')->count();

        // ===============================
        // Activity Chart (Last 7 Days)
        // ===============================
        $weeklyApplications = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $count = PermitApplication::whereDate('created_at', $date)->count();

            $weeklyApplications[] = [
                'date' => $date->format('D'), // Mon, Tue, etc.
                'count' => $count, // always default 0 if no applications
            ];
        }

        // ===============================
        // Recent Activity (Users + Plans)
        // ===============================
        $recentUsers = User::with([
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan', // fixed plural
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
            'weeklyApplications',
            'UserCounts',
            'totalArchitecturalPlans',
            'totalStructuralPlans',
            'totalElectricalPlans',
            'totalPlumbingPlans',
            'totalPermitApplications',
            'pendingArchitecturalPlans',
            'pendingStructuralPlans',
            'pendingElectricalPlans',
            'pendingPlumbingPlans',
            'PendingApplications',
            'underReviewArchitecturalPlans',
            'underReviewStructuralPlans',
            'underReviewElectricalPlans',
            'underReviewPlumbingPlans',
            'ApprovedApplication',
            'approvedArchitecturalPlans',
            'approvedStructuralPlans',
            'approvedElectricalPlans',
            'approvedPlumbingPlans',
            'RejectedApplication',
            'rejectedArchitecturalPlans',
            'rejectedStructuralPlans',
            'rejectedElectricalPlans',
            'rejectedPlumbingPlans'
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
            'permitApplications.architecturalPlans:id,permit_application_id,plan_name,file_path,status'
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
            'permitApplications.structuralPlans:id,permit_application_id,plan_name,documents,status'
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
                // STRUCTURAL PLANS
                // ===============================
                $permit->structuralPlans->transform(function ($plan) {

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
            'permitApplications.electricalPlans:id,permit_application_id,plan_name,documents,status'
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

        // ✅ FIX: Exclude archived permits
        $users = User::where('role', 'user')
            ->with([
                'permitApplications' => function ($query) {
                    $query->where('archived', false); // 🔥 IMPORTANT
                }
            ])
            ->get();

        // (Optional) You can also filter this if used somewhere else
        $permitApplications = PermitApplication::whereIn('status', ['pending', 'under_review', 'approved', 'rejected'])
            ->where('archived', false) // ✅ ADD THIS TOO
            ->select('id', 'user_id', 'project_name', 'location', 'address', 'radiusRange', 'status', 'documents', 'created_at', 'description')
            ->get();

        // Transform document URLs
        $users->each(function ($user) {
            $user->permitApplications->transform(function ($permit) {
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

    // Engineer Mark Under Review Permit
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

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Updated permit status to Under Review.',
        ]);

        return back()->with('success', 'Permit marked as Under Review.');
    }

    // Engineer Mark Approved Permit
    public function MarkApproveIndex($id)
    {
        $currentUser = Auth::user();

        $permit = PermitApplication::findOrFail($id);

        if ($permit->status !== 'approved') {

            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'engineer'
                    ? $currentUser->id
                    : $permit->reviewed_by
            ]);
        }

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Updated permit status to Approved.',
        ]);

        return back()->with('success', 'Permit marked as Approved.');
    }

    // Engineer Mark Rejected Permit
    public function MarkRejectIndex(Request $request, $id)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);

        $permit = PermitApplication::findOrFail($id);

        // Optional: prevent rejecting already finalized permits
        if (!in_array($permit->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cannot reject this permit.');
        }

        // Update status and comment
        $permit->status = 'rejected';
        $permit->rejection_comment = $request->rejection_comment;
        $permit->rejected_by = Auth::id(); // optional (if you track who rejected)
        $permit->save();

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Updated permit status to Rejected. Comment: ' . $request->rejection_comment,
        ]);

        return back()->with('success', 'Permit rejected successfully.');
    }

    // Engineer Archive Permit
    public function MarkArchiveIndex($id)
    {
        $permit = PermitApplication::findOrFail($id);

        // Archive permit without deleting
        DeletedPlanFile::create([
            'permit_application_id' => $permit->id,
            'plan_name' => $permit->project_name,
            'file_path' => $permit->documents,
            'deleted_by' => Auth::id(),
            'rejection_comment' => $permit->rejection_comment ?? null,
            'rejected_by' => $permit->rejected_by ?? Auth::id(),
        ]);

        // Optionally mark the permit as archived
        $permit->archived = true;
        $permit->save();

        // Log
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Archived permit: ' . $permit->project_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permit archived successfully!',
            'permit_id' => $permit->id, // optional, useful for JS
        ]);
    }

    // View Archive of Deleted Permits & Plans
    public function ViewArchiveIndex()
    {
        $currentUser = Auth::user();

        // Get deleted plans with necessary relationships
        $deletedPlans = DeletedPlanFile::with([
            'user',                 // deleted_by relationship
            'permitApplication',    // original permit application
            'rejectedBy'      // user who rejected
        ])
            ->where('deleted_by', $currentUser->id)
            ->latest()
            ->paginate(10); // use pagination to match Blade if you want links

        return view('Engineer.Archive.archive', [
            'deletedPlans' => $deletedPlans,
            'currentUser' => $currentUser,
            'ActiveTabMenu' => 'View-Archive',
            'SubActiveTab' => 'Deleted Plans'
        ]);
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

        return back()->with('success', 'Architectural Plan marked under review successfully.');
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

        return back()->with('success', 'Architectural Plan approved successfully.');
    }

    // Engineer Mark Rejected Architectural Plan
    public function RejectIndex(Request $request, $id)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);

        $permit = ArchitecturalPlan::findOrFail($id);

        // Optional: prevent rejecting already finalized plans
        if (!in_array($permit->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cannot reject this plan.');
        }

        // Update status and comment
        $permit->status = 'rejected';
        $permit->rejection_comment = $request->rejection_comment;
        $permit->rejected_by = Auth::id(); // optional (if you track who rejected)
        $permit->save();

        return back()->with('success', 'Architectural Plan rejected successfully.');
    }

    // Engineer Archive Architectural Plan
    public function ArchiveIndex($id)
    {
        $plan = ArchitecturalPlan::findOrFail($id); // Get the plan

        // Handle file_path which may be JSON or array
        $files = [];

        if (!empty($plan->file_path)) {
            // Decode JSON if needed
            $files = is_array($plan->file_path)
                ? $plan->file_path
                : (json_decode($plan->file_path, true) ?: [$plan->file_path]);
        }

        foreach ($files as $file) {
            if (!empty($file)) {
                DeletedPlanFile::create([
                    'permit_application_id' => $plan->permit_application_id, // correct permit ID
                    'plan_name' => $plan->plan_name, // plan name
                    'file_path' => is_array($file) ? json_encode($file) : $file, // convert array to string if needed
                    'deleted_by' => Auth::id(),
                    'rejection_comment' => $plan->rejection_comment ?? null,
                    'rejected_by' => $plan->rejected_by ?? Auth::id(),
                ]);
            }
        }

        // Mark the plan as archived
        $plan->archived = true;
        $plan->save();

        // Log
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Archived plan: ' . $plan->plan_name,
        ]);

        return response()->json([
            'success' => true,
            'plan_name' => $plan->plan_name,
            'file_urls' => $plan->file_urls,
        ]);
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

        return back()->with('success', 'Structural plan marked under review successfully.');
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

    // Engineer Reject Structural Plan
    public function RejectStructuralIndex(Request $request, $id)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);

        $permit = StructuralPlan::findOrFail($id);

        // Optional: prevent rejecting already finalized plans
        if (!in_array($permit->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cannot reject this plan.');
        }

        // Update status and comment
        $permit->status = 'rejected';
        $permit->rejection_comment = $request->rejection_comment;
        $permit->rejected_by = Auth::id(); // optional (if you track who rejected)
        $permit->save();

        return back()->with('success', 'Structural Plan rejected successfully.');
    }

    // Engineer Archived Structural Plan
    public function ArchiveStructuralIndex($id)
    {
        $plan = StructuralPlan::findOrFail($id); // change model accordingly

        // Handle file_path which may be JSON or array
        $files = [];

        if (!empty($plan->file_path)) {
            // Decode JSON if needed
            $files = is_array($plan->file_path)
                ? $plan->file_path
                : (json_decode($plan->file_path, true) ?: [$plan->file_path]);
        }

        foreach ($files as $file) {
            if (!empty($file)) {
                DeletedPlanFile::create([
                    'permit_application_id' => $plan->permit_application_id, // correct permit ID
                    'plan_name' => $plan->plan_name, // plan name
                    'file_path' => is_array($file) ? json_encode($file) : $file, // convert array to string if needed
                    'deleted_by' => Auth::id(),
                    'rejection_comment' => $plan->rejection_comment ?? null,
                    'rejected_by' => $plan->rejected_by ?? Auth::id(),
                ]);
            }
        }

        // Mark the plan as archived
        $plan->archived = true;
        $plan->save();

        // Log
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Archived plan: ' . $plan->plan_name,
        ]);

        return response()->json([
            'success' => true,
            'plan_name' => $plan->plan_name,
            'file_urls' => $plan->file_urls,
        ]);
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

        return back()->with('success', 'Electrical Plan marked under review successfully.');
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

        return back()->with('success', 'Electrical Plan approved successfully.');
    }

    // Engineer Reject Electrical Plan
    public function RejectElectricalIndex(Request $request, $id)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);

        $permit = ElectricalPlans::findOrFail($id);

        // Optional: prevent rejecting already finalized plans
        if (!in_array($permit->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cannot reject this plan.');
        }

        // Update status and comment
        $permit->status = 'rejected';
        $permit->rejection_comment = $request->rejection_comment;
        $permit->rejected_by = Auth::id(); // optional (if you track who rejected)
        $permit->save();

        return back()->with('success', 'Electrical Plan rejected successfully.');
    }

    // Engineer Archive Electrical Plan
    public function ArchiveElectricalIndex($id)
    {
        $plan = ElectricalPlans::findOrFail($id); // change model accordingly

        // Handle file_path which may be JSON or array
        $files = [];

        if (!empty($plan->documents)) {
            // Decode JSON if needed
            $files = is_array($plan->documents)
                ? $plan->documents
                : (json_decode($plan->documents, true) ?: [$plan->documents]);
        }

        foreach ($files as $file) {
            if (!empty($file)) {
                DeletedPlanFile::create([
                    'permit_application_id' => $plan->permit_application_id, // correct permit ID
                    'plan_name' => $plan->plan_name, // plan name
                    'file_path' => is_array($file) ? json_encode($file) : $file, // convert array to string if needed
                    'deleted_by' => Auth::id(),
                    'rejection_comment' => $plan->rejection_comment ?? null,
                    'rejected_by' => $plan->rejected_by ?? Auth::id(),
                ]);
            }
        }

        // Mark the plan as archived
        $plan->archived = true;
        $plan->save();

        // Log
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Archived plan: ' . $plan->plan_name,
        ]);

        return response()->json([
            'success' => true,
            'plan_name' => $plan->plan_name,
            'file_urls' => $plan->file_urls,
        ]);
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

        return back()->with('success', 'Plumbing Plan marked under review successfully.');
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
    public function RejectPlumbingIndex(Request $request, $id)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);

        $permit = ElectricalPlans::findOrFail($id);

        // Optional: prevent rejecting already finalized plans
        if (!in_array($permit->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cannot reject this plan.');
        }

        // Update status and comment
        $permit->status = 'rejected';
        $permit->rejection_comment = $request->rejection_comment;
        $permit->rejected_by = Auth::id(); // optional (if you track who rejected)
        $permit->save();

        return back()->with('success', 'Plumbing Plan rejected successfully.');
    }

    // Engineer Archive Plumbing Plan
    public function ArchivePlumbingIndex($id)
    {
        $plan = PlumbingPlan::findOrFail($id); // change model accordingly

        // Handle file_path which may be JSON or array
        $files = [];

        if (!empty($plan->documents)) {
            // Decode JSON if needed
            $files = is_array($plan->documents)
                ? $plan->documents
                : (json_decode($plan->documents, true) ?: [$plan->documents]);
        }

        foreach ($files as $file) {
            if (!empty($file)) {
                DeletedPlanFile::create([
                    'permit_application_id' => $plan->permit_application_id, // correct permit ID
                    'plan_name' => $plan->plan_name, // plan name
                    'file_path' => is_array($file) ? json_encode($file) : $file, // convert array to string if needed
                    'deleted_by' => Auth::id(),
                    'rejection_comment' => $plan->rejection_comment ?? null,
                    'rejected_by' => $plan->rejected_by ?? Auth::id(),
                ]);
            }
        }

        // Mark the plan as archived
        $plan->archived = true;
        $plan->save();

        // Log
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Archived plan: ' . $plan->plan_name,
        ]);

        return response()->json([
            'success' => true,
            'plan_name' => $plan->plan_name,
            'file_urls' => $plan->file_urls,
        ]);
    }
    // Engineer Under Maintenance
    public function UnderMaintenanceIndex()
    {
        $currentUser = Auth::user();
        return view(
            'Engineer.Maintenance.under-maintenance',
            compact('currentUser'),
            [
                'ActiveTabMenu' => 'Under-Maintenance',
                'SubActiveTab' => 'Index'
            ]
        );
    }

    // Engineer View upload Inspections
    public function ViewInspectionsIndex()
    {
        $currentUser = Auth::user();
        return view(
            'Engineer.Inspections.upload-site-photo',
            compact('currentUser'),
            [
                'ActiveTabMenu' => 'View-Inspections',
                'SubActiveTab' => 'Index'
            ]
        );
    }


    // Engineer View Scheduled Calendar
    public function ViewScheduledCalendarIndex()
    {
        $currentUser = Auth::user();
        return view('Engineer.Inspections.scheduled-inspections', compact('currentUser'), [
            'ActiveTabMenu' => 'View-Inspections',
            'SubActiveTab' => 'Calendar'
        ]);
    }

    // Engineer View Inspections Checklist
    public function ViewInspectionsChecklistIndex()
    {
        $currentUser = Auth::user();
        return view('Engineer.Inspections.inspections-checklist', compact('currentUser'), [
            'ActiveTabMenu' => 'View-Inspections',
            'SubActiveTab' => 'Checklist'
        ]);
    }

    // Engineer View Inspections Finding
    public function ViewInspectionsFindingIndex()
    {
        $currentUser = Auth::user();
        return view('Engineer.Inspections.add-inspections-finding', compact('currentUser'), [
            'ActiveTabMenu' => 'View-Inspections',
            'SubActiveTab' => 'Finding'
        ]);
    }

    // Engineer View Inspections Mark Failed
    public function ViewInspectionsMarkFailedIndex()
    {
        $currentUser = Auth::user();
        return view('Engineer.Inspections.mark-failed', compact('currentUser'), [
            'ActiveTabMenu' => 'View-Inspections',
            'SubActiveTab' => 'Mark-Failed'
        ]);
    }
}