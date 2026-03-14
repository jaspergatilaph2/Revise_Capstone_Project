@extends('layouts.app')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('mpdo.dashboard') }}" class="app-brand-link">
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
                        <a href="{{ route('mpdo.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->

                    <li class="menu-item {{ $ActiveTabMenu === 'Reviews' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-file"></i>
                            <div data-i18n="Layouts">Permit Applications</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('reviews.permits.view-permits') }}" class="menu-link">
                                    <div data-i18n="Without menu">Permit Review</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('reviews.permits.view-architectural') }}" class="menu-link">
                                    <div data-i18n="Without menu">Architectural Plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('reviews.permits.view-structural') }}" class="menu-link">
                                    <div data-i18n="Without menu">Structural Plans</div>
                                </a>
                            </li>
                            <li class="menu-item {{ $SubActiveTab === 'Electrical' ? 'active' : '' }}">
                                <a href="{{ route('reviews.permits.view-electrical') }}" class="menu-link">
                                    <div data-i18n="Without menu">Electrical Plans</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('reviews.permits.view-plumbing') }}" class="menu-link">
                                    <div data-i18n="Without menu">Plumbing Plans</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{ route('reviews.permits.view-certificate') }}" class="menu-link">
                                    <div data-i18n="Without menu">Certificate</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu">Archived Applications</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-hourglass"></i>
                            <div data-i18n="Layouts">Project Monitoring</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu"> Ongoing Projects</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Completed Projects</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Infrastructure Projects</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Private Developments</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <i class="menu-icon fa-solid fa-building"></i>
                                                <div data-i18n="Layouts">Development Projects</div>
                                            </a>

                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">All Projects</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Ongoing</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Completed</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Proposed</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li> -->

                    <!-- <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <i class="menu-icon fa-solid fa-chart-simple"></i>
                                                <div data-i18n="Layouts">Reports & Analytics</div>
                                            </a>

                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Annual investment plans (AIP)</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Budget allocation and utilization</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Infrastructure development progress</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="" class="menu-link">
                                                        <div data-i18n="Without navbar">Population and demographic analysis</div>
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
                                <a href="{{ route('details.accounts.view') }}" class="menu-link">
                                    <div data-i18n="Account">Account</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('details.accounts.update') }}" class="menu-link">
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
                                <a href="" class="menu-link">
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
                                                        <img src="{{Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('sneat/img/avatars/1.png') }}"
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
                                        <a class="dropdown-item" href="">
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
                <div class="content-wrapper d-flex flex-column min-vh-100">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> Review Electrical Plan
                                /</span>Show Uploaded Documents
                        </h4>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i
                                                class="menu-icon fa-solid fa-folder"></i> Electrical Plan Documents
                                            Details</a>
                                    </li>
                                </ul>

                                <div class="card mb-4">
                                    <h5 class="card-header">Applicants Documents Viewer</h5>
                                    <hr class="my-0" />

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Project Name</th>
                                                        <th>Plan Name(s)</th>
                                                        <th>Documents</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($users as $user)
                                                        @foreach($user->permitApplications as $permit)
                                                            <tr>

                                                                <!-- User Name -->
                                                                <td>{{ $user->name }}</td>

                                                                <!-- Project Name -->
                                                                <td>{{ $permit->project_name }}</td>

                                                                <!-- Plan Names -->
                                                                <td>
                                                                    @if($permit->electricalPlans && $permit->electricalPlans->count() > 0)
                                                                        <ul class="list-unstyled mb-0">
                                                                            @foreach($permit->electricalPlans as $plan)
                                                                                <li>{{ $plan->plan_name }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <span class="text-secondary">No Electrical Plan</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Documents -->
                                                                <td>
                                                                    @if($permit->electricalPlans && $permit->electricalPlans->count() > 0)
                                                                        <div class="d-flex flex-column">

                                                                            @foreach($permit->electricalPlans as $plan)

                                                                                @if(!empty($plan->file_urls))
                                                                                    @foreach($plan->file_urls as $index => $url)

                                                                                        <a href="{{ $url }}" target="_blank"
                                                                                            class="btn btn-sm btn-primary mb-1">
                                                                                            View File ({{ $index + 1 }})
                                                                                        </a>

                                                                                    @endforeach
                                                                                @else
                                                                                    <span class="text-secondary">No File</span>
                                                                                @endif

                                                                            @endforeach

                                                                        </div>
                                                                    @else
                                                                        <span class="text-secondary">No Electrical Plan</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Actions -->
                                                                <td>
                                                                    <div class="d-flex justify-content-center gap-2">

                                                                        <!-- Under Review -->
                                                                        <button class="btn btn-sm btn-warning" disabled>
                                                                            <i class="fa-solid fa-hourglass-half me-1"></i>
                                                                            Under Review
                                                                        </button>

                                                                        <!-- Approve -->
                                                                        <form action="" method="POST">
                                                                            @csrf
                                                                            <button class="btn btn-sm btn-success" disabled>
                                                                                <i class="fa-solid fa-check me-1"></i>
                                                                                Approve
                                                                            </button>
                                                                        </form>

                                                                        <!-- Delete -->
                                                                        <form action="" method="POST"
                                                                            onsubmit="return confirm('Delete this permit?')">
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button class="btn btn-sm btn-danger" disabled>
                                                                                <i class="fa-solid fa-trash me-1"></i>
                                                                                Delete
                                                                            </button>
                                                                        </form>

                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mt-auto">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-3 flex-md-row flex-column text-center text-md-start">

                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
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