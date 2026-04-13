<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\LogsHistory;
use App\Models\PermitApplication;
use App\Models\ArchitecturalPlan;
use App\Models\StructuralPlan;
use App\Models\ElectricalPlans;
use App\Models\PlumbingPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        $currentUser = Auth::user();

        // Get all engineers and mpdo users
        $users = User::whereIn('role', ['engineer', 'mpdo', 'mpdo_staff'])->get();

        // Get all applicants or users
        $applicants = User::where('role', 'user')->get();
        $applicantsCounts = $applicants->count();

        // Approved permits count
        $applicantscountsPermit = PermitApplication::where('status', 'approved')->count();

        // Pending permits count for each plan type
        $pemitCountPer = PermitApplication::where('status', 'pending')->count();
        $pendingCountArch = ArchitecturalPlan::where('status', 'pending')->count();
        $pendingCountStruct = StructuralPlan::where('status', 'pending')->count();
        $pendingCountElec = ElectricalPlans::where('status', 'pending')->count();
        $pendingCountPlumb = PlumbingPlan::where('status', 'pending')->count();

        // Total pending permits
        $pendingCount = $pendingCountArch + $pendingCountStruct + $pendingCountElec + $pendingCountPlumb;

        // Optional: create a collection of all pending permits
        $pendingPermitsCollection = collect([
            'architectural' => ArchitecturalPlan::where('status', 'pending')->get(),
            'structural' => StructuralPlan::where('status', 'pending')->get(),
            'electrical' => ElectricalPlans::where('status', 'pending')->get(),
            'plumbing' => PlumbingPlan::where('status', 'pending')->get(),
        ]);


        $approvedCountArch = ArchitecturalPlan::where('status', 'approved')->count();
        $approvedCountStruct = StructuralPlan::where('status', 'approved')->count();
        $approvedCountElec = ElectricalPlans::where('status', 'approved')->count();
        $approvedCountPlumb = PlumbingPlan::where('status', 'approved')->count();

        $approvedPermitsCollection = collect([
            'architectural' => ArchitecturalPlan::where('status', 'approved')->get(),
            'structural' => StructuralPlan::where('status', 'approved')->get(),
            'electrical' => ElectricalPlans::where('status', 'approved')->get(),
            'plumbing' => PlumbingPlan::where('status', 'approved')->get(),
        ]);

        // Get the last 7 days labels
        $monthlyApplications = [];

        $startOfMonth = Carbon::create(2026, 4, 2); // April 1 (fixed from April 2)
        $endOfMonth = Carbon::today();

        $current = $startOfMonth->copy();

        while ($current->lte($endOfMonth)) {
            $monthlyApplications[] = [
                'date' => $current->format('d M'),
                'permit' => PermitApplication::whereDate('created_at', $current->toDateString())->count(),
                'architectural' => ArchitecturalPlan::whereDate('created_at', $current->toDateString())->count(),
                'structural' => StructuralPlan::whereDate('created_at', $current->toDateString())->count(),
                'electrical' => ElectricalPlans::whereDate('created_at', $current->toDateString())->count(),
                'plumbing' => PlumbingPlan::whereDate('created_at', $current->toDateString())->count(),
            ];

            $current->addDay();
        }

        // Recent Activity (Users + Plans)
        $recentUsers = User::with([
            'permitApplications.architecturalPlans',
            'permitApplications.structuralPlans',
            'permitApplications.electricalPlans',
            'permitApplications.plumbingPlan',
        ])
            ->where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // dd($monthlyApplications); // dump it before returning the view

        return view('Admin.Dashboard.index', compact(
            'currentUser',
            'users',
            'applicants',
            'applicantsCounts',
            'applicantscountsPermit',
            'pendingCount',
            'pendingPermitsCollection',
            'pemitCountPer',
            'pendingCountArch',
            'pendingCountStruct',
            'pendingCountElec',
            'pendingCountPlumb',
            'approvedCountArch',
            'approvedCountStruct',
            'approvedCountElec',
            'approvedCountPlumb',
            'approvedPermitsCollection',
            'monthlyApplications',
            'recentUsers'
        ));
    }

    // Staff View Dashboard
    public function ViewStaffIndex()
    {
        $currentUser = Auth::user();
        $mpdoStaffs = User::whereIn('role', ['mpdo_staff', 'mpdo'])->get();
        $engineers = User::where('role', 'engineer')->get();

        return view('Admin.Staff.view-staff', compact('mpdoStaffs', 'engineers', 'currentUser'), [
            'ActiveTabMenu' => 'Staff',
            'SubActiveTab' => 'View'
        ]);
    }

    // View The Countdown Dashboard
    public function ViewCountdownIndex()
    {
        $currentUser = Auth::user();

        // Just fetch, DO NOT create here
        $maintenance = Maintenance::first();

        return view('Admin.MPDO.set-maintenance', compact('currentUser', 'maintenance'), [
            'ActiveTabMenu' => 'Countdown',
            'SubActiveTab' => 'Tab'
        ]);
    }

    // Update the countdown to know the mpdo department
    public function UpdateCountdownIndex(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'finish_at' => 'required|date',
            'target_tab' => 'required'
        ]);

        $maintenance = Maintenance::first() ?? new Maintenance();

        $maintenance->department = $request->department;
        $maintenance->finish_at = $request->finish_at;
        $maintenance->target_tab = $request->target_tab;
        $maintenance->save();

        return redirect()->route('countdown.maintenance.view-countdown')
            ->with('success', 'Maintenance schedule updated!');
    }

    // View The applicants List Dashboard
    public function ViewApplicantsIndex()
    {
        $currentUser = Auth::user();
        $applicants = User::where('role', 'user')->get();

        return view('Admin.Staff.view-applicants', compact('currentUser', 'applicants'), [
            'ActiveTabMenu' => 'Applicants',
            'SubActiveTab' => 'View'
        ]);
    }


    // View The Accounts of the Admin
    public function ViewAdminAccountsIndex()
    {
        $accounts = Auth::user();

        return view('Admin.Accounts.view-accounts', [
            'accounts' => $accounts,
            'ActiveTabMenu' => 'View',
            'SubActiveTab' => 'Accounts'
        ]);
    }

    // View The Update Accounts of the Admin
    public function ViewAdminUpdateAccountsIndex()
    {
        $accounts = Auth::user();

        return view('Admin.Accounts.update-accounts', [
            'accounts' => $accounts,
            'ActiveTabMenu' => 'Update',
            'SubActiveTab' => 'Accounts'
        ]);
    }

    // Update the Accounts of the Admin
    public function UpdateAdminAccountsIndex(Request $request)
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
}
