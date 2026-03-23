<?php

namespace App\Http\Controllers\Mpdo;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\LogsHistory;
use App\Models\PermitApplication;
use Illuminate\Support\Facades\Hash;
use PhpParser\Builder\Function_;

class MpdoController extends Controller
{
    // Mpdo Index Dashboard
    public function MpdoIndex()
    {
        $currentUser = Auth::user();

        // Total Applicants
        $totalApplicants = User::where('role', 'user')->count();

        // Fetch all permits with related plans
        $permits = User::where('role', 'user')
            ->with([
                'permitApplications.architecturalPlans',
                'permitApplications.structuralPlans',
                'permitApplications.electricalPlans',
                'permitApplications.plumbingPlan', // corrected plural
            ])
            ->get()
            ->flatMap(fn($user) => $user->permitApplications ?? collect());

        $totalPermits = $permits->count();

        // Approved count
        $approvedCount = $permits->filter(function ($permit) {
            if (optional($permit)->status === 'approved') {
                return true;
            }

            $plans = collect([
                $permit->architecturalPlans ?? collect(),
                $permit->structuralPlans ?? collect(),
                $permit->electricalPlans ?? collect(),
                $permit->plumbingPlans ?? collect(),
            ])->flatten();

            return $plans->contains(fn($plan) => optional($plan)->status === 'approved');
        })->count();

        // Under Review count
        $underReviewCount = $permits->filter(function ($permit) {
            if (optional($permit)->status === 'under_review') {
                return true;
            }

            $plans = collect([
                $permit->architecturalPlans ?? collect(),
                $permit->structuralPlans ?? collect(),
                $permit->electricalPlans ?? collect(),
                $permit->plumbingPlans ?? collect(),
            ])->flatten();

            return $plans->contains(fn($plan) => optional($plan)->status === 'under_review');
        })->count();

        // Declined count (everything else)
        $declinedCount = $totalPermits - ($approvedCount + $underReviewCount);

        // Percentages
        $approvedPercent = $totalPermits ? round(($approvedCount / $totalPermits) * 100) : 0;
        $underReviewPercent = $totalPermits ? round(($underReviewCount / $totalPermits) * 100) : 0;
        $declinedPercent = $totalPermits ? round(($declinedCount / $totalPermits) * 100) : 0;

        // Chart data
        $chartLabels = ['Pending', 'Under Review', 'Approved'];
        $pendingCount = $permits->filter(fn($permit) => optional($permit)->status === 'pending')->count();
        $chartData = [$pendingCount, $underReviewCount, $approvedCount];

        // Monthly data
        $monthLabels = [];
        $monthData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = date('M', mktime(0, 0, 0, $m, 1));
            $monthData[] = $permits->filter(fn($permit) => optional($permit->created_at)->month == $m)->count();
        }

        return view('MPDO.Dashboard.index', compact(
            'currentUser',
            'totalApplicants',
            'underReviewCount',
            'approvedCount',
            'chartLabels',
            'chartData',
            'declinedCount',
            'approvedPercent',
            'underReviewPercent',
            'declinedPercent',
            'monthLabels',
            'monthData'
        ));
    }

    // Mpdo View Accounts Index
    public function ViewAccoutsIndex()
    {
        $currentUser = Auth::user();

        return view('MPDO.Accounts.view', compact('currentUser'), [
            'ActiveTabMenu' => 'View',
            'SubActiveTab' => 'Accounts'
        ]);
    }

    // MPDO Update Accounts Index
    public function UpdateAccountsIndex()
    {
        $currentUser = Auth::user();

        return view('MPDO.Accounts.update', compact('currentUser'), [
            'ActiveTabMenu' => 'Update',
            'SubActiveTab' => 'Accounts'
        ]);
    }


    // MPDO Revise Accounts Index
    public function ReviseAccountsIndex(Request $request)
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


    // MPDO View All Permits Index
    public function ViewAllPermitsIndex()
    {
        $currentUser = Auth::user();

        // Fetch users with permits and their plans
        $users = User::where('role', 'user')
            ->with([
                'permitApplications.architecturalPlans',
                'permitApplications.structuralPlans',
                'permitApplications.electricalPlans',
                'permitApplications.plumbingPlan'
            ])
            ->get();

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

        return view('MPDO.Permits.all-permit-review', compact('currentUser', 'users'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Permits'
        ]);
    }


    // MPDO View Architectural Plans Index
    public function ViewArchitecturalPlansIndex()
    {
        $currentUser = Auth::user();

        // Fetch users with permits and their architectural plans
        $users = User::where('role', 'user')
            ->with([
                'permitApplications.architecturalPlans.reviewer' // ✅ FIX HERE
            ])
            ->get();

        // Loop through each user and their permits
        foreach ($users as $user) {
            foreach ($user->permitApplications as $permit) {
                // Transform architectural plans for URLs
                $permit->architecturalPlans->transform(function ($plan) {
                    $planUrls = [];

                    if ($plan->file_path) {
                        // Decode JSON if necessary
                        $files = is_array($plan->file_path)
                            ? $plan->file_path
                            : json_decode($plan->file_path, true);

                        if (!is_array($files)) {
                            $files = [$plan->file_path];
                        }

                        foreach ($files as $file) {
                            $file = str_replace(['\\', '"'], '', $file);
                            $planUrls[] = Storage::url($file);
                        }
                    }

                    $plan->file_urls = $planUrls;
                    return $plan;
                });
            }
        }

        return view('MPDO.Permits.architectural-plans', compact('currentUser', 'users'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Architectural'
        ]);
    }


    // MPDO View Structural Plans Index
    public function ViewStructuralPlansIndex()
    {
        $currentUser = Auth::user();

        // Fetch users with permits and their structural plans
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

        return view('MPDO.Permits.structural-plans', compact('currentUser', 'users'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Structural'
        ]);
    }

    // MPDO View Electrical Plans Index
    public function ViewElectricalPlansIndex()
    {
        $currentUser = Auth::user();

        // Fetch users with permits and their structural plans
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

        return view('MPDO.Permits.electrical-plans', compact('currentUser', 'users'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Electrical'
        ]);
    }

    // MPDO View Plumbing Plans Index
    public function ViewPlumbingPlansIndex()
    {
        $currentUser = Auth::user();

        // Fetch users with permits and their structural plans
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
                // PLUMBING PLANS
                // ===============================
                $permit->plumbingPlan->transform(function ($plan) {

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

        return view('MPDO.Permits.plumbing-plans', compact('currentUser', 'users'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Plumbing'
        ]);
    }

    // MPDO View Certificate of Occupancy Application Index
    public function ViewCertificateAppIndex()
    {
        $currentUser = Auth::user();
        return view('MPDO.Permits.certificate', compact('currentUser'), [
            'ActiveTabMenu' => 'Reviews',
            'SubActiveTab' => 'Certificate'
        ]);
    }

    // MPDO View Staff Index
    public function ViewStaffIndex()
    {
        $currentUser = Auth::user();

        return view('MPDO.Staff.add-staff', compact('currentUser'), [
            'ActiveTabMenu' => 'Staff',
            'SubActiveTab' => 'View Staff'
        ]);
    }

    // MPDO View Add Staff Index
    public function ViewAddStaffIndex()
    {
        $currentUser = Auth::user();

        return view('MPDO.Staff.view-staff', compact('currentUser'), [
            'ActiveTabMenu' => 'Staff',
            'SubActiveTab' => 'Add Staff'
        ]);
    }

    // MPDO Store New Staff or Employees
    public function StoreStaffIndex(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required',
            'role' => 'required',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 1
        ]);

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Already save the new staff member.',
        ]);

        return back()->with('success', 'Staff added successfully!');
    }

    // MPDO View Logs History Index
    public function ViewLogsIndex()
    {
        $currentUser = Auth::user();

        $logs = LogsHistory::whereHas('user', function ($query) {
            $query->whereIn('role', ['mpdo', 'mpdo_staff']);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('MPDO.Logs.view-logs', compact('currentUser', 'logs'), [
            'ActiveTabMenu' => 'Logs',
            'SubActiveTab' => 'View Logs'
        ]);
    }

    //MPDO Update the permit Status
    public function UnderReviewUpdateStatus(Request $request, $id)
    {
        $currentUser = Auth::user();
        $permit = PermitApplication::findOrFail($id);

        // Prevent updating if the permit is already approved
        if ($permit->status === 'under_review') {
            return redirect()->back()->with('error', 'This permit has already been approved and cannot be modified.');
        }

        // Update only if status is not already 'under_review'
        if ($permit->status !== 'under_review') {
            $permit->status = 'under_review';

            // Set reviewed_by only if current user is MPDO
            if ($currentUser->role === 'mpdo') {
                $permit->reviewed_by = $currentUser->id;
            }

            $permit->save();
        }

        return redirect()->back()->with('success', 'Permit status updated successfully.');
    }

    // MPDO Approve the permit Status
    public function ApprovedUpdateStatus(Request $request, $id)
    {
        $currentUser = Auth::user();
        $permit = PermitApplication::findOrFail($id);

        if ($permit->status !== 'approved') {
            $permit->update([
                'status' => 'approved',
                'reviewed_by' => $currentUser->role === 'mdpo' ? $currentUser->id : $permit->reviewed_by
            ]);
        }

        return redirect()->back()->with('success', 'Permit status updated successfully.');
    }

    // MPDO Update the Architectural Plans Status
    public function UnderReviewArchitecturalUpdateStatus(Request $request, $id)
    {
        $currentUser = Auth::user();

        // Find the architectural plan
        $permit = ArchitecturalPlan::findOrFail($id);

        if ($permit->status !== 'under_review') {
            $permit->update([
                'status' => 'under_review',
                'reviewed_by' => $currentUser->role === 'mpdo' ? $currentUser->id : $permit->reviewed_by
            ]);
        }

        return back()->with('success', 'Permit marked under review successfully.');
    }


    // MPDO Approve the Architectural Plans Status
    public function ApprovedArchitecturalUpdateStatus(Request $request, $id)
    {
        $currentUser = Auth::user();

        // Find the architectural plan using the foreign key permit_application_id
        $permit = ArchitecturalPlan::with([
            'permitApplication:id,user_id,reviewd_by,status'
        ])
            ->whereHas('permitApplication', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->first();

        if (!$permit) {
            return back()->with('error', 'No architectural plan found for this permit application.');
        }

        // Prevent updating if already approved
        if ($permit->status === 'approved') {
            return back()->with('error', 'This architectural plan has already been approved and cannot be modified.');
        }

        // Update status to 'approved'
        $permit->status = 'approved';

        // Set reviewed_by only if current user is MPDO
        if ($currentUser->role === 'mpdo') {
            $permit->reviewed_by = $currentUser->id;
        }

        $permit->save();

        return back()->with('success', 'Architectural plan status updated successfully.');
    }

    // View Maintenance in MPDO
    public function ViewMaintenanceIndex(){
        $currentUser = Auth::user();
        return view('MPDO.Maintenance.maintenance', compact('currentUser'));
    }
}
