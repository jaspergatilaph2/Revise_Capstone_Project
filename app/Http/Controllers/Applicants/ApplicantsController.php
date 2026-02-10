<?php

namespace App\Http\Controllers\Applicants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermitApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicantsController extends Controller
{
    public function index()
    {
        return view('Applicants.Dashboard.index');
    }

    // Downloads Permits View
    public function DownloadsIndex()
    {
        return view('Applicants.Downloads.index', [
            'ActiveTabMenu' => 'Downloads',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    //Unified Application Form Download
    public function UnifiedApplicationFormDownload()
    {
        return view('Applicants.Downloads.unified-application-form', [
            'ActiveTabMenu' => 'Unified-Application-Form',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    // Civil Permit Download
    public function CivilPermitDownload()
    {
        return view('Applicants.Downloads.civil-permit', [
            'ActiveTabMenu' => 'Civil-Permit',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    // Architectural Permit Download
    public function ArchitecturalPermitDownload()
    {
        return view('Applicants.Downloads.architectural-permit', [
            'ActiveTabMenu' => 'Architectural-Permit',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    // Electecal Permit Download
    public function ElectricalPermitIndex()
    {
        return view('Applicants.Downloads.electrical-permit', [
            'ActiveTabMenu' => 'Electrical',
            'SubActiveMenu' => 'Permit'
        ]);
    }

    // Plumbing Permit Download
    public function PlumbingPermitIndex()
    {
        return view('Applicants.Downloads.plumbing-permit', [
            'ActiveTabMenu' => 'Plumbing',
            'SubActiveMenu' => 'Permit'
        ]);
    }

    // Apply Dashboard
    public function ApplyIndex()
    {
        return view('Applicants.Apply.index', [
            'ActiveTabMenu' => 'Apply',
            'SubActiveMenu' => 'index',
        ]);
    }


    // Apply Store
    public function ApplyPermitIndex(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radiusRange' => 'required|integer|min:20|max:1000',
            'project_cost' => 'required|numeric|min:0',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // ✅ Handle multiple file uploads
        $documentPaths = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Store each file in /storage/app/public/documents
                $path = $file->store('documents', 'public');
                $documentPaths[] = $path;
            }
        }

        // ✅ Create new permit application record
        $application = new PermitApplication();
        $application->user_id = Auth::id();
        $application->project_name = $validated['project_name'];
        $application->location = $validated['location'];
        $application->latitude = $request->latitude;
        $application->longitude = $request->longitude;
        $application->radiusRange = $validated['radiusRange'];
        $application->project_cost = $validated['project_cost'];
        $application->address = $validated['address'];
        $application->description = $validated['description'];
        $application->documents = json_encode($documentPaths); // store as JSON array
        $application->save();



        return redirect()->back()
            ->with('success', 'Application submitted successfully!');
    }

    // Pending Dashboard
    public function PendingPermitIndex()
    {
        return view('Applicants.Apply.pending-permit', [
            'ActiveTabMenu' => 'Pending',
            'SubActiveTab' => 'Permit'
        ]);
    }

    // Applicants View Accounts
    public function AccountsViewIndex()
    {
        $accounts = Auth::user();
        return view('Applicants.Accounts.view', [
            'ActiveTabMenu' => 'View',
            'SubActiveTab' => 'Accounts'
        ], compact('accounts'));
    }
}
