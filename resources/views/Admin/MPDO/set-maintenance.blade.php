@extends('layouts.app')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
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
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-file"></i>
                            <div data-i18n="Layouts">System Statistics</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu">Total applicants</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu">Total permits</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu">Recent activities</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without menu">Notifications</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-receipt"></i>
                            <div data-i18n="Layouts">Permit Applications</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">All Applications</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">New applications</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Pending Review</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">Approved & Rejected</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ $ActiveTabMenu === 'Countdown' ? 'active' : ''}}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-hammer"></i>
                            <div data-i18n="Layouts">Maintenance</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item {{ $SubActiveTab === 'Tab' ? 'active' : '' }}">
                                <a href="" class="menu-link">
                                    <div data-i18n="Without navbar">MPDO Maintencance</div>
                                </a>
                            </li>
                        </ul>
                    </li>


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
                                <a href="" class="menu-link">
                                    <div data-i18n="Account">Account</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
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


                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-list-check"></i>
                            <div data-i18n="Account Settings">User Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('staff.employees.staff-view') }}" class="menu-link">
                                    <div data-i18n="Account">Staff/Inspector</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="Notifications">Applicant</div>
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
                                        <img src="{{ $currentUser->avatar ? asset('storage/' . $currentUser->avatar) : asset('sneat/img/avatars/1.png') }}"
                                            alt class="w-px-120 h-px-120 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ $currentUser->avatar ? asset('storage/' . $currentUser->avatar) : asset('sneat/img/avatars/1.png') }}"
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
                                                        } elseif ($role === 'obo') {
                                                            $roleLabel = 'OBO';
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
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container-xxl container-p-y d-flex align-items-center justify-content-center"
                            style="min-height: 100vh;">
                            <div class="card shadow-sm mx-auto" style="max-width: 500px;">
                                <div class="card-body text-center">

                                    <!-- Page Title -->
                                    <h4 class="mb-4">
                                        <i class="fa-solid fa-tools me-2 text-primary"></i>
                                        Set Maintenance Schedule
                                    </h4>

                                    <!-- Success Message -->
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <!-- Maintenance Form -->
                                    <form action="{{ route('countdown.maintenance.update-countdown') }}" method="POST">
                                        @csrf

                                        <!-- Department Input -->
                                        <div class="mb-3 text-start">
                                            <label for="department" class="form-label fw-bold">Department</label>
                                            <input type="text" name="department" id="department" class="form-control"
                                                value="{{ $maintenance->department ?? 'MPDO' }}" required>
                                        </div>

                                        <div class="mb-3 text-start">
                                            <label for="target_tab" class="form-label fw-bold">Target MPDO Tab</label>
                                            <select name="target_tab" id="target_tab" class="form-select" required>
                                                <option value="ongoing_projects" {{ ($maintenance->target_tab ?? '') == 'ongoing_projects' ? 'selected' : '' }}>
                                                    Ongoing Projects
                                                </option>
                                                <option value="completed_projects" {{ ($maintenance->target_tab ?? '') == 'completed_projects' ? 'selected' : '' }}>
                                                    Completed Projects
                                                </option>
                                                <option value="infrastructure_projects" {{ ($maintenance->target_tab ?? '') == 'infrastructure_projects' ? 'selected' : '' }}>
                                                    Infrastructure Projects
                                                </option>
                                                <option value="private_developments" {{ ($maintenance->target_tab ?? '') == 'private_developments' ? 'selected' : '' }}>
                                                    Private Developments
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Finish Date/Time Input -->
                                        <div class="mb-3 text-start">
                                            <label for="finish_at" class="form-label fw-bold">Expected Finish Date &
                                                Time</label>
                                            <input type="datetime-local" name="finish_at" id="finish_at"
                                                class="form-control" value="{{ $maintenance && $maintenance->finish_at
        ? \Carbon\Carbon::parse($maintenance->finish_at)->format('Y-m-d\TH:i')
        : '' }}" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fa-solid fa-check me-2"></i> Save Schedule
                                        </button>
                                    </form>

                                    <!-- Optional Info -->
                                    <p class="mt-3 text-muted small">
                                        This schedule will be displayed on the MPDO dashboard maintenance page.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mt-4">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column text-center text-md-start">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>document.write(new Date().getFullYear());</script>,
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