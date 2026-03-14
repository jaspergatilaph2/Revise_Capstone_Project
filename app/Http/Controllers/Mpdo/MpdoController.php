<?php

namespace App\Http\Controllers\Mpdo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\LogsHistory;
use App\Models\PermitApplication;

class MpdoController extends Controller
{
    // Mpdo Index Dashboard
    public function MpdoIndex()
    {
        $currentUser = Auth::user();

        // Total Applicants
        $totalApplicants = User::where('role', 'user')->count();

        // ===============================
        // Counts for Dashboard
        // ===============================
        $underReviewCount = User::with(
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan' // fixed plural
        )
            ->where('role', 'user')
            ->get()
            ->flatMap(fn($user) => $user->permitApplications)
            ->filter(function ($permit) {
                if ($permit->status !== 'under_review')
                    return false;

                $allReviewed = collect([
                    $permit->architecturalPlans,
                    $permit->structuralPlans,
                    $permit->electricalPlans,
                    $permit->plumbingPlans
                ])->flatten()
                    ->every(fn($plan) => $plan->status !== 'pending' && $plan->status !== 'under_review');

                return $allReviewed;
            })
            ->count();

        $approvedCount = User::with(
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan' // fixed plural
        )
            ->where('role', 'user')
            ->get()
            ->flatMap(fn($user) => $user->permitApplications)
            ->filter(function ($permit) {
                if ($permit->status === 'approved')
                    return true;

                $planTypes = [
                    $permit->architecturalPlans,
                    $permit->structuralPlans,
                    $permit->electricalPlans,
                    $permit->plumbingPlans,
                ];

                foreach ($planTypes as $plans) {
                    if (!empty($plans) && collect($plans)->contains(fn($p) => $p->status === 'approved')) {
                        return true;
                    }
                }

                return false;
            })
            ->count();

        // ===============================
        // Permits / Plans Overview Chart
        // ===============================
        $pendingCount = User::with(
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan'
        )
            ->where('role', 'user')
            ->get()
            ->flatMap(fn($user) => $user->permitApplications)
            ->filter(fn($permit) => $permit->status === 'pending')
            ->count();

        $chartLabels = ['Pending', 'Under Review', 'Approved'];
        $chartData = [$pendingCount, $underReviewCount, $approvedCount];

        // ===============================
        // Oversight for Declined Permits/Plans
        // ===============================
        $permits = User::with(
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan'
        )
            ->where('role', 'user')
            ->get()
            ->flatMap(fn($user) => $user->permitApplications);

        $totalPermits = $permits->count();
        $approvedCount = $permits->filter(function ($permit) {
            if ($permit->status === 'approved')
                return true;

            $planTypes = [
                $permit->architecturalPlans,
                $permit->structuralPlans,
                $permit->electricalPlans,
                $permit->plumbingPlans,
            ];

            foreach ($planTypes as $plans) {
                if (!empty($plans) && collect($plans)->contains(fn($p) => $p->status === 'approved')) {
                    return true;
                }
            }
            return false;
        })->count();

        $underReviewCount = $permits->filter(function ($permit) {
            if ($permit->status !== 'under_review')
                return false;

            $allReviewed = collect([
                $permit->architecturalPlans,
                $permit->structuralPlans,
                $permit->electricalPlans,
                $permit->plumbingPlans
            ])->flatten()
                ->every(fn($plan) => $plan->status !== 'pending' && $plan->status !== 'under_review');

            return $allReviewed;
        })->count();
        $declinedCount = $totalPermits - ($approvedCount + $underReviewCount);

        // Calculate percentages safely
        $approvedPercent = $totalPermits ? round(($approvedCount / $totalPermits) * 100) : 0;
        $underReviewPercent = $totalPermits ? round(($underReviewCount / $totalPermits) * 100) : 0;
        $declinedPercent = $totalPermits ? round(($declinedCount / $totalPermits) * 100) : 0;

        // ===============================
        // Monthly Oversight Permits Or Plans Chart
        // ===============================
        $monthLabels = [];
        $monthData = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = date('M', mktime(0, 0, 0, $m, 1));

            $count = $permits->filter(function ($permit) use ($m) {
                return $permit->created_at->month == $m;
            })->count();

            $monthData[] = $count;
        }

        return view('MPDO.Dashboard.index', compact(
            'currentUser',
            'totalApplicants',
            'underReviewCount',
            'approvedCount',
            'chartLabels',
            'chartData',
            'approvedCount',
            'underReviewCount',
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
            ->with(['permitApplications.architecturalPlans'])
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
    public function ViewStaffIndex(){
        $currentUser = Auth::user();

        return view('MPDO.Staff.add-staff', compact('currentUser'), [
            'ActiveTabMenu' => 'Staff',
            'SubActiveTab' => 'View Staff'
        ]);
    }
}
