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
                    <li class="menu-item">
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
                    <li class="menu-item {{ $ActiveTabMenu === 'View-Inspections' ? 'active' : '' }}">
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
                            <li class="menu-item {{ $SubActiveTab === 'Mark-Failed' ? 'active' : '' }}">
                                <a href="{{ route('engineer.inspections.view-mark-failed') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Mark as Passed / Failed</div>
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

                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <h4 class="fw-bold text-primary mb-3">
                                        <i class="fa-solid fa-circle-check me-2"></i>
                                        Inspection Result
                                    </h4>

                                    <form method="POST" action="">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspection Date</label>
                                            <input type="date" class="form-control" name="inspection_date" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspector Name</label>
                                            <input type="text" class="form-control" name="inspector_name"
                                                placeholder="Enter inspector name">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspection Area</label>
                                            <input type="text" class="form-control" name="inspection_area"
                                                placeholder="Example: Electrical Room, Roof Deck, Basement">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspection Notes</label>
                                            <textarea class="form-control" name="inspection_notes" rows="4"
                                                placeholder="Enter notes about the inspection"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspection Status</label>
                                            <select class="form-select" name="inspection_status" id="inspectionStatus">
                                                <option value="">Select Status</option>
                                                <option value="passed">Passed</option>
                                                <option value="failed">Failed</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Corrective Action (If Failed)</label>
                                            <textarea class="form-control" name="corrective_action" rows="3"
                                                placeholder="Enter required corrective action if inspection failed"></textarea>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fa-solid fa-check me-2"></i>
                                                Save Inspection Result
                                            </button>
                                        </div>

                                    </form>

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