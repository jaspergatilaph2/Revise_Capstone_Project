@extends('layouts.app')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('applicants.dashboard') }}" class="app-brand-link">
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
                    <li class="menu-item">
                        <a href="{{ route('applicants.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>


                    <li class="menu-item {{ $ActiveTabMenu === 'Pending' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-bars-progress"></i>
                            <div data-i18n="Layouts">Notification</div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item {{ $SubActiveTab === 'Permit' ? 'active' : '' }}">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Progress</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Certificate</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Layouts -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-download"></i>
                            <div data-i18n="Layouts">Downloads</div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('applicants.downloads.index') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Permits</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-ticket"></i>
                            <div data-i18n="Layouts">Apply for Permit</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('apply.permit.index') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Apply Now</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('apply.permit.view-architectural') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Architectural Plan Upload</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('apply.permit.view-structural-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Structural Plan Upload</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('apply.permit.view-electrical-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Electrical Plan Upload</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('apply.permit.view-plumbing-plan') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Plumbing Plan Upload</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Issues</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="menu-item">
                                                                                                                                                                                                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                                                                                                                                                                                <i class="menu-icon fa-solid fa-receipt"></i>
                                                                                                                                                                                                                <div data-i18n="Layouts">Payments</div>
                                                                                                                                                                                                              </a>

                                                                                                                                                                                                              <ul class="menu-sub">
                                                                                                                                                                                                                <li class="menu-item">
                                                                                                                                                                                                                  <a href="" class="menu-link">
                                                                                                                                                                                                                    <div data-i18n="Without navbar">Pending Payments</div>
                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                <li class="menu-item">
                                                                                                                                                                                                                  <a href="" class="menu-link">
                                                                                                                                                                                                                    <div data-i18n="Without navbar">Paid</div>
                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                <li class="menu-item">
                                                                                                                                                                                                                  <a href="" class="menu-link">
                                                                                                                                                                                                                    <div data-i18n="Without navbar">Overdue</div>
                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                </li>
                                                                                                                                                                                                              </ul>
                                                                                                                                                                                                            </li> -->

                    <!-- <li class="menu-item">
                                                                                                                                                                                                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                                                                                                                                                                                <i class="menu-icon fa-solid fa-comment"></i>
                                                                                                                                                                                                                <div data-i18n="Layouts">Notification / Messages</div>
                                                                                                                                                                                                              </a>

                                                                                                                                                                                                              <ul class="menu-sub">
                                                                                                                                                                                                                <li class="menu-item">
                                                                                                                                                                                                                  <a href="" class="menu-link">
                                                                                                                                                                                                                    <div data-i18n="Without navbar">Notifications</div>
                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                <li class="menu-item">
                                                                                                                                                                                                                  <a href="" class="menu-link">
                                                                                                                                                                                                                    <div data-i18n="Without navbar">History Notification</div>
                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                </li>
                                                                                                                                                                                                              </ul>
                                                                                                                                                                                                            </li> -->

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Accounts</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-user"></i>
                            <div data-i18n="Account Settings">Account Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('applicants.accounts.view') }}" class="menu-link">
                                    <div data-i18n="Account">Account</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('applicants.accounts.update-accounts') }}" class="menu-link">
                                    <div data-i18n="Notifications">Update Account</div>
                                </a>
                            </li>
                        </ul>
                    </li>

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
                                <a href="{{ route('record.history.log-history') }}" class="menu-link">
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
                                                    <small class="text-muted"> @php
                                                        $role = strtolower(auth()->user()->role);
                                                        if ($role === 'bfp') {
                                                            $roleLabel = 'BFP';
                                                        } elseif ($role === 'admin') {
                                                            $roleLabel = 'Admin';
                                                        } elseif ($role === 'mpdo') {
                                                            $roleLabel = 'MPDO';
                                                        } elseif ($role === 'treasurer') {
                                                            $roleLabel = 'Treasurer';
                                                        } else {
                                                            $roleLabel = 'User';
                                                        }
                                                    @endphp
                                                        {{ $roleLabel }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                                                                                                                                                                                                              <a class="dropdown-item" href="">
                                                                                                                                                                                                                                <i class="bx bx-cog me-2"></i>
                                                                                                                                                                                                                                <span class="align-middle">Settings</span>
                                                                                                                                                                                                                              </a>
                                                                                                                                                                                                                            </li> -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('record.history.log-history') }}">
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
                    <div class="content-wrapper">
                        <div class="container-xxl container-p-y">
                            <div class="row g-4">

                                <!-- ================= STEPS INDICATOR ================= -->
                                <div class="col-12 col-md-3">
                                    @php
                                        $latestPermit = $user->permitApplications->sortByDesc('created_at')->first();
                                        $status = $latestPermit ? strtolower($latestPermit->status) : null;
                                    @endphp

                                    <div class="d-flex d-md-block justify-content-between align-items-center text-center">

                                        <!-- STEP 1: Consent -->
                                        <div class="position-relative mb-0 mb-md-4">
                                            <div class="rounded-circle 
                                        {{ $latestPermit ? 'bg-success text-white' : 'bg-secondary text-white' }} 
                                        mx-auto d-flex align-items-center justify-content-center"
                                                style="width:36px; height:36px;">
                                                1
                                            </div>
                                            <div class="small mt-1">Consent</div>
                                            <div class="d-none d-md-block position-absolute start-50 top-100 translate-middle-x"
                                                style="width:3px; height:40px; background:#d1d5db;"></div>
                                        </div>

                                        <!-- STEP 1.5: Pending -->
                                        <div class="position-relative mb-0 mb-md-4">
                                            <div class="rounded-circle 
                                        {{ $status === 'pending' ? 'bg-primary border border-primary border-3 animate-pulse text-white' : 'bg-secondary text-white' }} 
                                        mx-auto d-flex align-items-center justify-content-center"
                                                style="width:36px; height:36px;">
                                                1.5
                                            </div>
                                            <div class="small mt-1">Pending</div>
                                            <div class="d-none d-md-block position-absolute start-50 top-100 translate-middle-x"
                                                style="width:3px; height:40px; background:#d1d5db;"></div>
                                        </div>

                                        <!-- STEP 2: Review -->
                                        <div class="position-relative mb-0 mb-md-4">
                                            <div class="rounded-circle 
                                        {{ $status === 'under_review' ? 'bg-primary border border-primary border-3 animate-pulse text-white' : 'bg-secondary text-white' }} 
                                        mx-auto d-flex align-items-center justify-content-center"
                                                style="width:36px; height:36px;">
                                                2
                                            </div>
                                            <div class="small mt-1">Review</div>
                                            <div class="d-none d-md-block position-absolute start-50 top-100 translate-middle-x"
                                                style="width:3px; height:40px; background:#d1d5db;"></div>
                                        </div>

                                        <!-- STEP 3: Approve -->
                                        <div class="position-relative">
                                            <div class="rounded-circle 
                                        {{ $status === 'approved' ? 'bg-primary border border-primary border-3 animate-pulse text-white' : 'bg-secondary text-white' }} 
                                        mx-auto d-flex align-items-center justify-content-center"
                                                style="width:36px; height:36px;">
                                                3
                                            </div>
                                            <div class="small mt-1">Approve</div>
                                        </div>

                                    </div>
                                </div>

                                <!-- ================= STEP CONTENT ================= -->
                                <div class="col-12 col-md-9">
                                    <div class="row g-4">

                                        <!-- STEP 1 -->
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="fw-bold text-uppercase">Submit Consent</h5>
                                                    <p class="text-muted small">
                                                        Submit your consent to proceed with the building permit application.
                                                    </p>

                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-bordered table-sm align-middle mb-2 table-hover">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Project</th>
                                                                    <th class="d-none d-lg-table-cell">Location</th>
                                                                    <th>Status</th>
                                                                    <th>Date</th>
                                                                    <th>Architectural Plans</th>
                                                                    <th>Structural Plans</th>
                                                                    <th>Electrical Plans</th>
                                                                    <th>Plumbing Plans</th>
                                                                    <th>Files</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($permitApplications as $index => $permit)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>

                                                                        <td class="text-truncate" style="max-width:150px;">

                                                                            @if($permit->status === 'under_review')
                                                                                <span class="text-secondary small">-</span>
                                                                            @else
                                                                                {{ $permit->project_name }}
                                                                            @endif

                                                                        </td>

                                                                        <td class="d-none d-lg-table-cell text-truncate"
                                                                            style="max-width:120px;">
                                                                            @if ($permit->status === 'under_review')
                                                                                <span class="text-secondary small">-</span>
                                                                            @else
                                                                                {{ $permit->location }}
                                                                            @endif
                                                                        </td>

                                                                        <td class="d-none d-lg-table-cell text-truncate"
                                                                            style="max-width:120px;">
                                                                            @if ($permit->status === 'under_review')
                                                                                <span class="text-secondary small">-</span>
                                                                            @else
                                                                                {{ ucfirst($permit->status) }}
                                                                            @endif
                                                                        </td>

                                                                        <td class="d-none d-lg-table-cell text-truncate"
                                                                            style="max-width:120px;">
                                                                            @if ($permit->status === 'under_review')
                                                                                <span class="text-secondary small">-</span>
                                                                            @else
                                                                                {{ $permit->created_at->format('M d, Y') }}
                                                                            @endif
                                                                        </td>

                                                                        {{-- Architectural Plans --}}
                                                                        <td class="text-truncate" style="max-width:200px;">

                                                                            @if($permit->status === 'under_review')
                                                                                {{-- Empty when already under review --}}
                                                                                <span class="text-secondary small">-</span>

                                                                            @elseif(!empty($permit->plan_name))
                                                                                {{ implode(', ', $permit->plan_name) }}

                                                                            @else
                                                                                <span class="text-secondary small">No Architectural Plans</span>
                                                                            @endif

                                                                        </td>

                                                                        {{-- Structural Plans --}}
                                                                        <td class="text-truncate" style="max-width:200px;">
                                                                            @if(!empty($permit->structural_plan_names))
                                                                                {{ implode(', ', $permit->structural_plan_names) }}
                                                                            @else
                                                                                <span class="text-secondary small">No Structural
                                                                                    Plans</span>
                                                                            @endif
                                                                        </td>

                                                                        <!-- Electrical Plans -->
                                                                        <td class="text-truncate" style="max-width:200px;">
                                                                            @if(!empty($permit->plumbing_plan_names))
                                                                                {{ implode(', ', $permit->plumbing_plan_names) }}
                                                                            @else
                                                                                <span class="text-secondary small">No Plumbing Plans
                                                                                    Plans</span>
                                                                            @endif
                                                                        </td>

                                                                        <!-- Plumbing Plans -->
                                                                        <td class="text-truncate" style="max-width:200px;">
                                                                            @if(!empty($permit->electrical_plan_names))
                                                                                {{ implode(', ', $permit->electrical_plan_names) }}
                                                                            @else
                                                                                <span class="text-secondary small">No Plumbing Plans
                                                                                    Plans</span>
                                                                            @endif
                                                                        </td>

                                                                        {{-- All Files --}}
                                                                        <td>
                                                                            <div class="d-flex flex-wrap gap-1">

                                                                                {{-- Permit Documents (only show if not under
                                                                                review) --}}
                                                                                @if($permit->status !== 'under_review' && !empty($permit->document_urls))
                                                                                    @foreach($permit->document_urls as $i => $docUrl)
                                                                                        <a href="{{ $docUrl }}" target="_blank"
                                                                                            class="btn btn-sm btn-primary text-truncate"
                                                                                            style="max-width:120px;">
                                                                                            Permit {{ $i + 1 }}
                                                                                        </a>
                                                                                    @endforeach
                                                                                @else
                                                                                    <span class="text-secondary small">-</span>
                                                                                @endif

                                                                                {{-- Architectural Files (always show) --}}
                                                                                @if($permit->status !== 'under_review' && !empty($permit->plan_files))
                                                                                    @foreach($permit->plan_files as $i => $url)
                                                                                        <a href="{{ $url }}" target="_blank"
                                                                                            class="btn btn-sm btn-success text-truncate"
                                                                                            style="max-width:120px;">
                                                                                            Archit {{ $i + 1 }}
                                                                                        </a>
                                                                                    @endforeach
                                                                                @else
                                                                                    <span class="text-secondary small">-</span>
                                                                                @endif

                                                                                {{-- Structural Files (always show) --}}
                                                                                @if(!empty($permit->structural_plan_files))
                                                                                    @foreach($permit->structural_plan_files as $i => $url)
                                                                                        <a href="{{ $url }}" target="_blank"
                                                                                            class="btn btn-sm btn-warning text-truncate"
                                                                                            style="max-width:120px;">
                                                                                            Struct {{ $i + 1 }}
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif

                                                                                <!-- Electrical Files -->
                                                                                @if(!empty($permit->electrical_plan_files))
                                                                                    @foreach ($permit->electrical_plan_files as $i => $url)
                                                                                        <a href="{{ $url }}" target="_blank"
                                                                                            class="btn btn-sm btn-warning text-truncate"
                                                                                            style="max-width:120px;">
                                                                                            Electr {{ $i + 1 }}
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif

                                                                                <!-- Plumbing Files -->
                                                                                @if(!empty($permit->plumbing_plan_files))
                                                                                    @foreach ($permit->plumbing_plan_files as $i => $url)
                                                                                        <a href="{{ $url }}" target="_blank"
                                                                                            class="btn btn-sm btn-warning text-truncate"
                                                                                            style="max-width:120px;">
                                                                                            Plumb {{ $i + 1 }}
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif

                                                                                {{-- Show "No Documents" only if nothing is left
                                                                                to show --}}
                                                                                @if(
                                                                                        ($permit->status === 'under_review' || empty($permit->document_urls)) &&
                                                                                        empty($permit->plan_files) &&
                                                                                        empty($permit->structural_plan_files)
                                                                                    )
                                                                                    <span class="text-secondary small">No
                                                                                        Documents</span>
                                                                                @endif

                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="8" class="text-center text-muted">
                                                                            No permit applications found.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- STEP 2 -->
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="fw-bold">Review By The Department</h5>
                                                    <p class="text-muted small">
                                                        Department staff will check your submissions, verify documents, and
                                                        update the status accordingly.
                                                    </p>

                                                    @foreach($permitApplications as $index => $permit)
                                                        <div class="card shadow-sm mb-3">

                                                            <div class="table-responsive">
                                                                <table
                                                                    class="table table-bordered table-striped align-middle mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Project Name</th>
                                                                            <th>Description</th>
                                                                            <th>Status</th>
                                                                            <th>Reviewed By</th>
                                                                            <th>Documents</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ $index + 1 }}</td>
                                                                            <td>{{ $permit->project_name }}</td>
                                                                            <td>{{ $permit->description }}</td>
                                                                            <td>
                                                                                @if($permit->status === 'under_review')
                                                                                    <span class="text-warning fw-bold">Under
                                                                                        Review</span>
                                                                                @elseif($permit->status === 'approved')
                                                                                    <span
                                                                                        class="text-success fw-bold">Approved</span>
                                                                                @elseif($permit->status === 'rejected')
                                                                                    <span
                                                                                        class="text-danger fw-bold">Rejected</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-secondary fw-bold">Pending</span>
                                                                                @endif
                                                                            </td>

                                                                            <td>{{ $permit->reviewer?->name ?? '-' }}</td>

                                                                            <td>
                                                                                <div class="d-flex flex-wrap gap-1">

                                                                                    {{-- Permit Documents --}}
                                                                                    @if(!empty($permit->document_urls))
                                                                                        @foreach($permit->document_urls as $i => $doc)
                                                                                            <a href="{{ $doc }}" target="_blank"
                                                                                                class="btn btn-sm btn-primary">
                                                                                                Permit {{ $i + 1 }}
                                                                                            </a>
                                                                                        @endforeach
                                                                                    @endif

                                                                                    {{-- Architectural Plans --}}
                                                                                    @if(!empty($permit->plan_files))
                                                                                        @foreach($permit->plan_files as $i => $plan)
                                                                                            <a href="{{ $plan }}" target="_blank"
                                                                                                class="btn btn-sm btn-success">
                                                                                                Archite{{ $i + 1 }}
                                                                                            </a>
                                                                                        @endforeach
                                                                                    @endif

                                                                                    {{-- Structural Plans --}}
                                                                                    @if(!empty($permit->structural_plan_files))
                                                                                        @foreach($permit->structural_plan_files as $i => $plan)
                                                                                            <a href="{{ $plan }}" target="_blank"
                                                                                                class="btn btn-sm btn-warning">
                                                                                                Structural {{ $i + 1 }}
                                                                                            </a>
                                                                                        @endforeach
                                                                                    @endif

                                                                                    {{-- Electrical Plans --}}
                                                                                    @if(!empty($permit->electrical_plan_files))
                                                                                        @foreach($permit->electrical_plan_files as $i => $plan)
                                                                                            <a href="{{ $plan }}" target="_blank"
                                                                                                class="btn btn-sm btn-info">
                                                                                                Electrical {{ $i + 1 }}
                                                                                            </a>
                                                                                        @endforeach
                                                                                    @endif

                                                                                    {{-- Plumbing Plans --}}
                                                                                    @if(!empty($permit->plumbing_plan_files))
                                                                                        @foreach($permit->plumbing_plan_files as $i => $plan)
                                                                                            <a href="{{ $plan }}" target="_blank"
                                                                                                class="btn btn-sm btn-dark">
                                                                                                Plumbing {{ $i + 1 }}
                                                                                            </a>
                                                                                        @endforeach
                                                                                    @endif

                                                                                    {{-- If no files at all --}}
                                                                                    @if(
                                                                                            empty($permit->document_urls) &&
                                                                                            empty($permit->plan_files) &&
                                                                                            empty($permit->structural_plan_files) &&
                                                                                            empty($permit->electrical_plan_files) &&
                                                                                            empty($permit->plumbing_plan_files)
                                                                                        )
                                                                                        <span class="text-muted">-</span>
                                                                                    @endif

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- /.table-responsive -->

                                                        </div> <!-- /.card mb-3 -->
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <!-- STEP 3 -->
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="fw-bold">Approve By The Department</h5>
                                                    <p class="text-muted small">
                                                        This section will be available after department review.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ================= FILES MODAL ================= -->
                    <div class="modal fade" id="filesModal1" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Uploaded Files</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <h6 class="fw-semibold mb-3 text-uppercase text-muted">Form Details</h6>
                                    <div class="border rounded p-4 bg-white">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="text-muted small fw-semibold">PROJECT OWNER</div>
                                                <div>John Doe</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="text-muted small fw-semibold">ESTIMATED COST</div>
                                                <div>₱ 1,500,000.00</div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="fw-semibold mt-4">Documents</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Building Permit Form.pdf</span>
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- /Content -->

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
                    <!-- /Footer -->

                    <div class="content-backdrop fade"></div>
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