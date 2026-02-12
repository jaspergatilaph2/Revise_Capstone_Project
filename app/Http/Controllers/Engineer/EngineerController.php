<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PermitApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EngineerController extends Controller
{
    // Engineer Index Dashboard
    public function EngineerIndex()
    {
        $currentUser = Auth::user();

        // Counting
        $totalApplications = PermitApplication::count();
        $PendingApplications = PermitApplication::where('status', 'pending')->count();
        $UnderReviewApplications = PermitApplication::where('status', 'under_review')->count();
        $ApprovedApplication = PermitApplication::where('status', 'approved')->count();

        // Activity Chart
        $weeklyApplications = [];
        // Loop last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $count = PermitApplication::whereDate('created_at', $date)->count();
            $weeklyApplications[] = [
                'date' => Carbon::parse($date)->format('D'), // Mon, Tue, etc.
                'count' => $count,
            ];
        }

        // Recent Activity
        $recentUsers = User::with('permitApplications')
            ->where('role', 'user') // only users with role = user
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

        // LogsHistory::create([
        //     'user_id' => Auth::id(),
        //     'description' => 'Updated account profile information.',
        // ]);

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
        $users = User::with('permitApplications')
            ->where('role', 'user')
            ->latest()
            ->get();

        return view('Engineer.Activities.index', compact('users', 'currentUser'));
    }
}
