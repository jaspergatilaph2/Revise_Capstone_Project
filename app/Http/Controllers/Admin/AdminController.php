<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        return view('Admin.Dashboard.index', compact('currentUser'));
    }
}
