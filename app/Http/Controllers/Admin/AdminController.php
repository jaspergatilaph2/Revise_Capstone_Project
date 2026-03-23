<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Maintenance;

class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        $currentUser = Auth::user();

        // Get all engineers and mpdo users
        $users = User::whereIn('role', ['engineer', 'mpdo'])->get();

        return view('Admin.Dashboard.index', compact('currentUser', 'users'));
    }

    // Staff View Dashboard
    public function ViewStaffIndex()
    {
        $currentUser = Auth::user();
        return view('Admin.Staff.view-staff', compact('currentUser'));
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
}
