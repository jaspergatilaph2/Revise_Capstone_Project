<?php

namespace App\Http\Controllers\Mpdo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LogsHistory;

class MpdoController extends Controller
{
    // Mpdo Index Dashboard
    public function MpdoIndex()
    {
        $currentUser = Auth::user();
        return view('MPDO.Dashboard.index', compact('currentUser'));
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

    public function UpdateAccountsIndex()
    {
        $currentUser = Auth::user();

        return view('MPDO.Accounts.update', compact('currentUser'), [
            'ActiveTabMenu' => 'Update',
            'SubActiveTab' => 'Accounts'
        ]);
    }

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
}
