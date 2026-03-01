<?php

namespace App\Http\Controllers\Applicants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermitApplication;
use App\Models\User;
use App\Models\ArchitecturalPlan;
use App\Models\ElectricalPlans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\LogsHistory;
use App\Models\PlumbingPlan;
use App\Models\StructuralPlan;
use Illuminate\Support\Facades\Storage;

class ApplicantsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('Applicants.Dashboard.index', compact('user'));
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

    // Documents Guide Download
    public function DocumentsGuideIndex()
    {
        return view('Applicants.Downloads.documents-guide', [
            'ActiveTabMenu' => 'Documents',
            'SubActiveTab' => 'Guide',
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

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'You already applied the all the requirements.',
        ]);

        return redirect()->back()
            ->with('success', 'Application submitted successfully!');
    }

    // Pending Dashboard
    public function PendingPermitIndex()
    {
        $userId = auth()->id(); // currently logged-in user ID

        // Get permits for the logged-in user only
        $permitApplications = PermitApplication::with('reviewer')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'under_review', 'approved', 'rejected'])
            ->select(
                'id',
                'user_id',
                'reviewed_by', // ✅ ADD THIS
                'project_name',
                'location',
                'address',
                'radiusRange',
                'status',
                'documents',
                'created_at',
                'description'
            )
            ->orderBy('created_at', 'desc')
            ->get();


        // Transform PermitApplication documents
        $permitApplications->transform(function ($permit) {
            $documentUrls = [];

            if ($permit->documents) {
                $docs = is_array($permit->documents)
                    ? $permit->documents
                    : json_decode($permit->documents, true);

                if (!is_array($docs)) {
                    $docs = [$permit->documents];
                }

                foreach ($docs as $doc) {
                    $doc = str_replace(['\\', '"'], '', $doc);
                    $documentUrls[] = asset('storage/' . $doc); // general permit documents
                }
            }

            $permit->document_urls = $documentUrls;

            return $permit;
        });

        // Architectural plans
        $architecturalPlans = ArchitecturalPlan::whereIn('permit_application_id', $permitApplications->pluck('id'))
            ->select('permit_application_id', 'plan_name', 'file_path')
            ->get()
            ->groupBy('permit_application_id');

        // Attach architectural plans to each permit
        $permitApplications->transform(function ($permit) use ($architecturalPlans) {
            $plans = $architecturalPlans->get($permit->id) ?? collect();

            $planNames = $plans->pluck('plan_name')->all();
            $fileUrls = [];

            foreach ($plans as $plan) {
                if (!empty($plan->file_path)) {
                    $files = is_array($plan->file_path)
                        ? $plan->file_path
                        : json_decode($plan->file_path, true);

                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    foreach ($files as $file) {
                        $cleanPath = str_replace(['\\', '"'], '', $file);
                        $fileUrls[] = asset('storage/' . $cleanPath);
                    }
                }
            }

            $permit->plan_name = $planNames;
            $permit->plan_files = $fileUrls;

            return $permit;
        });

        // Structural plans
        $structuralPlans = StructuralPlan::whereIn('permit_application_id', $permitApplications->pluck('id'))
            ->select('permit_application_id', 'plan_name', 'documents')
            ->get()
            ->groupBy('permit_application_id');

        // Attach structural plans to each permit
        $permitApplications->transform(function ($permit) use ($structuralPlans) {
            $plans = $structuralPlans->get($permit->id) ?? collect();

            $planNames = $plans->pluck('plan_name')->all();
            $fileUrls = [];

            foreach ($plans as $plan) {
                if (!empty($plan->documents)) {
                    $files = is_array($plan->documents)
                        ? $plan->documents
                        : json_decode($plan->documents, true);

                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    foreach ($files as $file) {
                        $cleanPath = str_replace(['\\', '"'], '', $file);
                        $fileUrls[] = asset('storage/' . $cleanPath);
                    }
                }
            }

            $permit->structural_plan_names = $planNames;
            $permit->structural_plan_files = $fileUrls;

            return $permit;
        });

        // Electrical Plans
        $electricalPlans = ElectricalPlans::whereIn('permit_application_id', $permitApplications->pluck('id'))
            ->select('permit_application_id', 'plan_name', 'documents')
            ->get()
            ->groupBy('permit_application_id');

        // Attach structural plans to each permit
        $permitApplications->transform(function ($permit) use ($electricalPlans) {
            $plans = $electricalPlans->get($permit->id) ?? collect();

            $planNames = $plans->pluck('plan_name')->all();
            $fileUrls = [];

            foreach ($plans as $plan) {
                if (!empty($plan->documents)) {
                    $files = is_array($plan->documents)
                        ? $plan->documents
                        : json_decode($plan->documents, true);

                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    foreach ($files as $file) {
                        $cleanPath = str_replace(['\\', '"'], '', $file);
                        $fileUrls[] = asset('storage/' . $cleanPath);
                    }
                }
            }

            $permit->electrical_plan_names = $planNames;
            $permit->electrical_plan_files = $fileUrls;

            return $permit;
        });

        // Plumbing Plans
        $plumbingPlans = PlumbingPlan::whereIn('permit_application_id', $permitApplications->pluck('id'))
            ->select('permit_application_id', 'plan_name', 'documents')
            ->get()
            ->groupBy('permit_application_id');

        // Attach structural plans to each permit
        $permitApplications->transform(function ($permit) use ($plumbingPlans) {
            $plans = $plumbingPlans->get($permit->id) ?? collect();

            $planNames = $plans->pluck('plan_name')->all();
            $fileUrls = [];

            foreach ($plans as $plan) {
                if (!empty($plan->documents)) {
                    $files = is_array($plan->documents)
                        ? $plan->documents
                        : json_decode($plan->documents, true);

                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    foreach ($files as $file) {
                        $cleanPath = str_replace(['\\', '"'], '', $file);
                        $fileUrls[] = asset('storage/' . $cleanPath);
                    }
                }
            }

            $permit->plumbing_plan_names = $planNames;
            $permit->plumbing_plan_files = $fileUrls;

            return $permit;
        });

        $user = auth()->user();

        return view('Applicants.Apply.pending-permit', [
            'ActiveTabMenu' => 'Pending',
            'SubActiveTab' => 'Permit',
            'permitApplications' => $permitApplications,
            'user' => $user,
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

    // View Update Accounts Dashboard For Applicants
    public function UpdateAccountsIndex()
    {
        $account = Auth::user();
        return view('Applicants.Accounts.update', [
            'ActiveTabMenu' => 'Update-Accounts',
            'SubActiveMenu' => 'Dashboard'
        ], compact('account'));
    }

    // Updating The Accounts Of The Users or Applicants
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

    // View The Logs History
    public function LogsIndex()
    {
        $userId = Auth::id();
        $logs = LogsHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('Applicants.History.logs-history', [
            'ActiveTabMenu' => 'Logs',
            'SubActiveTab' => 'History'
        ], compact('logs'));
    }

    // View Architectural Uploaded Dashboard
    public function ArchitecturalUploadIndex()
    {
        // You are ignoring $id anyway; maybe you want to use it later
        $permit = PermitApplication::where('user_id', Auth::id())->first();

        return view('Applicants.Apply.architectural-plan', [
            'ActiveTabMenu' => 'Architectural-Upload',
            'SubActiveTab' => 'Plan',
            'permit' => $permit, // pass $permit here
        ]);
    }


    // Store The Architectural Plan
    public function ArchitecturalStoreIndex(Request $request)
    {

        $request->validate([
            'permit_application_id' => 'required|exists:permit_applications,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('architectural_plans', 'public');
                $uploadedFiles[] = $path;
            }
        }

        $plan = ArchitecturalPlan::create([
            'permit_application_id' => $request->permit_application_id,
            'plan_name' => $request->plan_name,
            'description' => $request->description,
            'file_path' => $uploadedFiles, // store as array if column is JSON
        ]);

        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Uploaded Architectural Plan: ' . $plan->plan_name,
        ]);

        return redirect()->back()->with('success', 'Architectural Plan uploaded successfully.');
    }

    // View Structural Plan Dashboard
    public function StructuralPlanIndex()
    {
        $permit = PermitApplication::where('user_id', Auth::id())->first();
        return view('Applicants.Apply.structural-plan', [
            'ActiveTabMenu' => 'Structural-Upload',
            'SubActiveTab' => 'Plan',
            'permit' => $permit, // pass $permit here
        ]);
    }

    // Store The Structural Plan
    public function StoreStructuralPlanIndex(Request $request)
    {
        // Validate the request
        $request->validate([
            'permit_application_id' => 'required|exists:permit_applications,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $uploadedFiles = [];

        // Handle file uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Store each file in 'storage/app/public/structural_plans'
                $path = $file->store('structural_plans', 'public');
                $uploadedFiles[] = $path;
            }
        }

        // Create the StructuralPlan record
        $plan = StructuralPlan::create([
            'permit_application_id' => $request->permit_application_id,
            'plan_name' => $request->plan_name,
            'description' => $request->description,
            'documents' => $uploadedFiles, // <-- fix: column name is 'documents'
        ]);

        // Log the action
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Uploaded Structural Plan: ' . $plan->plan_name,
        ]);

        return redirect()->back()->with('success', 'Structural plan uploaded successfully.');
    }

    // View Electrical Plan
    public function ElectricalPlanIndex()
    {
        $permit = PermitApplication::where('user_id', Auth::id())->first();
        return view('Applicants.Apply.electrical-plan', [
            'ActiveTabMenu' => 'Electrical-Upload',
            'SubActiveTab' => 'Plan',
            'permit' => $permit, // pass $permit here
        ]);
    }

    // Store The Electrical Plan To The Database
    public function StoreElectricalPlanIndex(Request $request)
    {
        // Validate the request
        $request->validate([
            'permit_application_id' => 'required|exists:permit_applications,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $uploadedFiles = [];

        // Handle file uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Store each file in 'storage/app/public/structural_plans'
                $path = $file->store('electrical_plans', 'public');
                $uploadedFiles[] = $path;
            }
        }

        // Create the StructuralPlan record
        $plan = ElectricalPlans::create([
            'permit_application_id' => $request->permit_application_id,
            'plan_name' => $request->plan_name,
            'description' => $request->description,
            'documents' => $uploadedFiles, // <-- fix: column name is 'documents'
        ]);

        // Log the action
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Uploaded Electrical Plan: ' . $plan->plan_name,
        ]);

        return redirect()->back()->with('success', 'Electrical plan uploaded successfully.');
    }

    // View Plumbing Plan Dashboard
    public function PlumbingPlanIndex()
    {
        $permit = PermitApplication::where('user_id', Auth::id())->first();
        return view('Applicants.Apply.plumbing-plan', [
            'ActiveTabMenu' => 'Plumbing-Upload',
            'SubActiveTab' => 'Plan',
            'permit' => $permit, // pass $permit here
        ]);
    }

    // Store Plumbing Plan
    public function StorePlumbingPlanIndex(Request $request)
    {
        // Validate the request
        $request->validate([
            'permit_application_id' => 'required|exists:permit_applications,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $uploadedFiles = [];

        // Handle file uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Store each file in 'storage/app/public/structural_plans'
                $path = $file->store('plumbing_plans', 'public');
                $uploadedFiles[] = $path;
            }
        }

        // Create the StructuralPlan record
        $plan = PlumbingPlan::create([
            'permit_application_id' => $request->permit_application_id,
            'plan_name' => $request->plan_name,
            'description' => $request->description,
            'documents' => $uploadedFiles, // <-- fix: column name is 'documents'
        ]);

        // Log the action
        LogsHistory::create([
            'user_id' => Auth::id(),
            'description' => 'Uploaded Plumbing Plan: ' . $plan->plan_name,
        ]);

        return redirect()->back()->with('success', 'Plumbing plan uploaded successfully.');
    }
}
