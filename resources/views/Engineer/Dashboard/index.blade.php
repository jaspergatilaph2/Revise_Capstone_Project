@extends('layouts.app')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('engineer.dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                        </span>
                        <img src="{{asset('images/Logo.png')}}" alt="" style="width: 50px;">
                        <span class="app-brand-text demo menu-text fw-bolder ms-2"
                            style="text-transform:uppercase">BPMS</span>
                    </a>

                    <!-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                                  <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
                                </a> -->
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active">
                        <a href="{{ route('engineer.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-file"></i>
                            <div data-i18n="Layouts">Permit Applications</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('candidate.applicants.view') }}" class="menu-link">
                                    <div data-i18n="Without menu">View applicant details</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('candidate.applicants.view-documents') }}" class="menu-link">
                                    <div data-i18n="Without menu">View uploaded plans/documents</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('candidate.applicants.view-approval') }}" class="menu-link">
                                    <div data-i18n="Without menu">View approval documents</div>
                                </a>
                            </li>
                            <!-- <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without menu">Under Review applications</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without menu">Approved applications</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without menu">Rejected applications</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without menu">Revenue from permit fees</div>
                                                    </a>
                                                </li> -->
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-code-compare"></i>
                            <div data-i18n="Layouts">Plan Review</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('review.proposal.review-architectural-plan') }}" class="menu-link">
                                    <div data-i18n="Without menu">Review architectural plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('review.proposal.review-structural-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Review structural plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('review.proposal.review-electrical-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Review electrical plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('review.proposal.review-plumbing-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Review plumbing plans</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-binoculars"></i>
                            <div data-i18n="Layouts">Inspections</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('engineer.inspections.view-calendar') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Scheduled inspections</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('engineer.inspections.view-checklist') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Inspection checklist</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('engineer.inspections.view-finding') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Add inspection findings</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('engineer.inspections.view') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Upload site photos</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('engineer.inspections.view-mark-failed') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Mark as Passed / Failed</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-file-zipper"></i>
                            <div data-i18n="Layouts">Archive</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('candidate.applicants.view-archive') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Deleted Permits & Plans</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <i class="menu-icon fa-solid fa-file-invoice-dollar"></i>
                                                <div data-i18n="Account Settings">Payment Management</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Account">Application fees</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Notifications">Renewal fees</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Notifications">Pending Payments</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Notifications">Completed Payments</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li> -->



                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Accounts Settings / User Management</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-user"></i>
                            <div data-i18n="Account Settings">Account Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('revamp.accounts.view') }}" class="menu-link">
                                    <div data-i18n="Account">Account</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('revamp.accounts.view-update') }}" class="menu-link">
                                    <div data-i18n="Notifications">Update Account</div>
                                </a>
                            </li>
                            <!-- <li class="menu-item">
                                      <a href="" class="menu-link">
                                        <div data-i18n="Notifications">Settings</div>
                                      </a>
                                    </li> -->

                        </ul>
                    </li>


                    <!-- <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <i class="menu-icon fa-solid fa-list-check"></i>
                                                <div data-i18n="Account Settings">User Management</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Account">Staff/Inspector</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Notifications">Applicant</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li> -->

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Miscellaneous</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Misc">Misc</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('logs.history.view') }}" class="menu-link">
                                    <div data-i18n="Under Maintenance">Logs</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">

                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('sneat/img/avatars/1.png') }}"
                                            alt class="w-px-120 h-px-120 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('sneat/img/avatars/1.png') }}"
                                                            alt class="w-px-120 h-px-120 rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                                                    <small class="text-muted">
                                                        @php
                                                            $role = strtolower($currentUser->role); // use $user instead of auth()->user()

                                                            if ($role === 'engineer') {
                                                                $roleLabel = 'Engineer';
                                                            } elseif ($role === 'admin') {
                                                                $roleLabel = 'Admin';
                                                            } elseif ($role === 'mpdo') {
                                                                $roleLabel = 'MPDO';
                                                            } elseif ($role === 'treasurer') {
                                                                $roleLabel = 'Treasurer';
                                                            } else {
                                                                $roleLabel = 'User';
                                                            }

                                                            // Status label
                                                            $statusLabel = strtolower($user->status ?? 'inactive');
                                                            if ($statusLabel === 'active') {
                                                                $statusLabel = 'Active';
                                                            } elseif ($statusLabel === 'inactive') {
                                                                $statusLabel = 'Inactive';
                                                            } else {
                                                                $statusLabel = ucfirst($statusLabel);
                                                            }
                                                        @endphp

                                                        {{ $roleLabel }} ||
                                                        <span
                                                            class="px-2 py-1 rounded text-white {{ $currentUser->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ ucfirst($currentUser->status) }}
                                                        </span>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('revamp.accounts.view') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('recents.activities.view') }}">
                                            <i class="fa-solid fa-chart-line me-2"></i>
                                            <span class="align-middle">Recent Activities</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                          <a class="dropdown-item" href="">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                          </a>
                                        </li> -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logs.history.view') }}">
                                            <i class="menu-icon tf-icons bx bx-file"></i>
                                            <span class="align-middle">Logs</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle" style="color:#ff6347;">Log Out</span>
                                        </a>
                                        <form action="{{route('logout')}}" method="post" id="logout-form">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container">
                            <!-- Page Title -->
                            <div class="mb-4 text-center text-md-start">
                                <h3 class="mb-4 fw-bold text-primary text-center text-md-start">
                                    <i class="fa-solid fa-building-columns me-2"></i>
                                    Engineering Department
                                    Welcome, {{ auth()->user()->name ?? 'Engineer' }}!
                                </h3>
                                <p class="text-muted mb-0">Overview of system performance and key building permit stats.</p>
                            </div>

                            <!-- Summary Cards -->
                            <div class="row g-4">
                                <!-- Total Applications -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Total User or Applicants</h6>
                                            <h3 class="fw-bolder text-primary mb-1">{{ $UserCounts }}</h3>
                                            <p class="text-muted small mb-0">All users</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Applications Permit and Plans by User -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-file-circle-plus fa-2x text-primary mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Total Applications</h6>
                                            <h3 class="fw-bolder text-primary mb-1">{{ $totalApplications }}</h3>
                                            <small class="text-muted">
                                                Permit: {{ $totalPermitApplications }} |
                                                Arch: {{ $totalArchitecturalPlans }} |
                                                Struct: {{ $totalStructuralPlans }} |
                                                Elec: {{ $totalElectricalPlans }} |
                                                Plumb: {{ $totalPlumbingPlans }}
                                            </small>
                                            <p class="text-muted small mb-0">All applications submitted</p>
                                        </div>
                                    </div>
                                </div>


                                <!-- Pending Approvals -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-hourglass-half fa-2x text-warning mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Pending Approvals</h6>
                                            <h3 class="fw-bolder text-warning mb-1" id="pendingApprovals">
                                                {{ $PendingApplications }}
                                            </h3>
                                            <small class="text-muted small mb-0">
                                                Permit: {{ $PendingApplications }} |
                                                Arch: {{ $pendingArchitecturalPlans }} |
                                                Struct: {{ $pendingStructuralPlans }} |
                                                Elec: {{ $pendingElectricalPlans }} |
                                                Plumb: {{ $pendingPlumbingPlans }}
                                            </small>
                                            <p class="text-muted small mb-0">Awaiting review</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Under Review -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-magnifying-glass fa-2x text-warning mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Under Review</h6>
                                            <h3 class="fw-bolder text-warning mb-1" id="pendingApprovals">
                                                {{ $UnderReviewApplications }}
                                            </h3>
                                            <small class="text-muted small mb-0">
                                                Permit: {{ $UnderReviewApplications }} |
                                                Arch: {{ $underReviewArchitecturalPlans }} |
                                                Struct: {{ $underReviewStructuralPlans }} |
                                                Elec: {{ $underReviewElectricalPlans }} |
                                                Plumb: {{ $underReviewPlumbingPlans }}
                                            </small>
                                            <p class="text-muted small mb-0">Awaiting review</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approved Permits -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Approved Permits</h6>
                                            <h3 class="fw-bolder text-success mb-1" id="approvedPermits">
                                                {{ $ApprovedApplication }}
                                            </h3>
                                            <small class="text-muted small mb-0">
                                                Permit: {{ $ApprovedApplication }} |
                                                Arch: {{ $approvedArchitecturalPlans }} |
                                                Struct: {{ $approvedStructuralPlans }} |
                                                Elec: {{ $approvedElectricalPlans }} |
                                                Plumb: {{ $approvedPlumbingPlans }}
                                            </small>
                                            <p class="text-muted small mb-0">Successfully issued permits</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rejected Permits -->
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div
                                        class="card shadow-sm border-0 h-100 animate__animated animate__bounceIn hover-card">
                                        <div class="card-body text-center">
                                            <i class="fa-solid fa-circle-xmark fa-2x text-danger mb-2"></i>
                                            <h6 class="fw-bold text-uppercase small">Rejected Permits</h6>
                                            <h3 class="fw-bolder text-danger mb-1" id="rejectedPermits">
                                                {{ $RejectedApplication }}
                                            </h3>
                                            <small class="text-muted small mb-0">
                                                Permit: {{ $RejectedApplication }} |
                                                Arch: {{ $rejectedArchitecturalPlans }} |
                                                Struct: {{ $rejectedStructuralPlans }} |
                                                Elec: {{ $rejectedElectricalPlans }} |
                                                Plumb: {{ $rejectedPlumbingPlans }}
                                            </small>
                                            <p class="text-muted small mb-0">Permits that were rejected</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Revenue Collected -->
                                <!-- <div class="col-12 col-sm-6 col-lg-3">
                                                        <div class="card shadow-sm border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="fa-solid fa-peso-sign fa-2x text-info mb-2"></i>
                                                                <h6 class="fw-bold text-uppercase small">Revenue Collected</h6>
                                                                <h3 class="fw-bolder text-info mb-1" id="totalRevenue">₱120,500</h3>
                                                                <p class="text-muted small mb-0">Total fees collected</p>
                                                            </div>
                                                        </div>
                                                    </div> -->
                            </div>

                            <!-- Quick Stats Section -->
                            <div class="row mt-4 g-4">
                                <!-- System Activity -->
                                <div class="col-12 col-lg-8">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-3">
                                                <i class="fa-solid fa-chart-line me-2 text-info"></i> System Activity
                                            </h5>
                                            <p class="text-muted small mb-3">Overview of weekly permit activities.</p>

                                            <!-- Hidden JSON data for Chart.js -->
                                            <span id="activityChartLabels" class="d-none">
                                                {{ json_encode(array_column($weeklyApplications, 'date')) }}
                                            </span>

                                            <span id="activityChartData" class="d-none">
                                                {{ json_encode(array_column($weeklyApplications, 'count')) }}
                                            </span>

                                            <div style="max-width: 400px; margin: 0 auto;">
                                                <canvas id="activityChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Activities -->
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body">

                                            <h5 class="fw-bold mb-3 d-flex align-items-center">
                                                <i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i>
                                                Recent Activities
                                            </h5>

                                            <!-- Scrollable container -->
                                            <ul class="list-group list-group-flush small"
                                                style="max-height: 300px; overflow-y: auto;">

                                                @forelse($recentUsers as $user)
                                                    <li class="list-group-item">

                                                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                                                            <div class="me-2">

                                                                @if($user->permitApplications->count() > 0)

                                                                    <i class="fa-solid fa-file-signature text-success me-2"></i>
                                                                    <strong>{{ $user->name }}</strong> submitted the following
                                                                    application(s):

                                                                    <ul class="mb-0 small ps-4 mt-2">

                                                                        @foreach($user->permitApplications as $permit)
                                                                            <li class="mb-2">

                                                                                <strong>{{ $permit->project_name ?? 'Unnamed Project' }}</strong>
                                                                                - <span
                                                                                    class="text-capitalize">{{ $permit->status }}</span>

                                                                                {{-- Architectural Plans --}}
                                                                                @if($permit->architecturalPlans->count() > 0)
                                                                                    <div class="small text-muted ps-3 mt-1">
                                                                                        <i
                                                                                            class="fa-solid fa-drafting-compass text-info me-1"></i>
                                                                                        Architectural Plan(s):
                                                                                        <ul class="mb-1 ps-3">
                                                                                            @foreach($permit->architecturalPlans as $plan)
                                                                                                <li>{{ $plan->plan_name }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                @endif

                                                                                {{-- Structural Plans --}}
                                                                                @if($permit->structuralPlans->count() > 0)
                                                                                    <div class="small text-muted ps-3 mt-1">
                                                                                        <i
                                                                                            class="fa-solid fa-building text-warning me-1"></i>
                                                                                        Structural Plan(s):
                                                                                        <ul class="mb-1 ps-3">
                                                                                            @foreach($permit->structuralPlans as $plan)
                                                                                                <li>{{ $plan->plan_name }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                @endif

                                                                                {{-- Electrical Plans --}}
                                                                                @if($permit->electricalPlans->count() > 0)
                                                                                    <div class="small text-muted ps-3 mt-1">
                                                                                        <i class="fa-solid fa-bolt text-danger me-1"></i>
                                                                                        Electrical Plan(s):
                                                                                        <ul class="mb-1 ps-3">
                                                                                            @foreach($permit->electricalPlans as $plan)
                                                                                                <li>{{ $plan->plan_name }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                @endif

                                                                                <!-- Plumbing Plans -->
                                                                                @if($permit->plumbingPlan->count() > 0)
                                                                                    <div class="small text-muted ps-3 mt-1">
                                                                                        <i class="fa-solid fa-water text-danger me-1"></i>
                                                                                        Electrical Plan(s):
                                                                                        <ul class="mb-1 ps-3">
                                                                                            @foreach($permit->plumbingPlan as $plan)
                                                                                                <li>{{ $plan->plan_name }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                @endif

                                                                            </li>
                                                                        @endforeach

                                                                    </ul>

                                                                @else
                                                                    <i class="fa-solid fa-user-plus text-primary me-2"></i>
                                                                    <strong>{{ $user->name }}</strong> registered and not yet
                                                                    applied
                                                                @endif

                                                            </div>

                                                            <div class="text-muted small mt-1 mt-md-0">
                                                                {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                                            </div>
                                                        </div>

                                                    </li>
                                                @empty
                                                    <li class="list-group-item text-muted text-center">
                                                        No recent activities
                                                    </li>
                                                @endforelse
                                                <li class="list-group-item text-center">
                                                    <a href="{{ route('recents.activities.view') }}"
                                                        class="text-primary small fw-bold text-decoration-none">
                                                        View All
                                                    </a>
                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- User Management Table -->
                            <!-- <div class="row mt-4">
                                                    <div class="col-12">
                                                        <div class="card shadow-sm border-0">
                                                            <div class="card-body">
                                                                <h5 class="fw-bold mb-3">
                                                                    <i class="fa-solid fa-users-gear me-2 text-primary"></i> User Management
                                                                </h5>
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-hover mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Role</th>
                                                                                <th>Status</th>
                                                                                <th>Last Seen</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>
                                                                                <td>John Doe</td>
                                                                                <td>User</td>
                                                                                <td>
                                                                                    <span class="px-3 py-2 rounded-pill shadow-sm fw-semibold small text-white bg-success" style="letter-spacing: 0.5px;">
                                                                                        Active
                                                                                    </span>


                                                                                </td>
                                                                                <td>Yesterday</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="4" class="text-center text-muted">No users found</td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mt-4">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column text-center text-md-start">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>,
                                <span class="fw-bold text-primary">Building Permit Management System</span>
                            </div>
                            <div>
                                <a href="#" class="footer-link me-3">Documentation</a>
                                <a href="#" class="footer-link me-3">Support</a>
                                <a href="#" class="footer-link">Contact</a>
                            </div>
                        </div>
                    </footer>
                </div>


                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
@endsection