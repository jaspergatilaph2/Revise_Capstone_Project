@extends('layouts.app-dashboard')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="" class="app-brand-link">
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

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-bars-progress"></i>
                            <div data-i18n="Layouts">
                                @php
                                    $notifications = Auth::user()->permitApplications;

                                    $pendingCount = $notifications->where('status', 'pending')->count();
                                    $reviewCount = $notifications->where('status', 'under_review')->count();
                                    $approvedCount = $notifications->where('status', 'approved')->count();

                                    $totalNotifications = $pendingCount + $reviewCount + $approvedCount;
                                @endphp
                                Notification
                                @if($totalNotifications > 0)
                                    ({{ $totalNotifications }})
                                @endif
                            </div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('apply.permit.pending') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Progress
                                        @if($totalNotifications > 0)
                                            ({{ $totalNotifications }})
                                        @endif
                                    </div>
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
                    <li class="menu-item {{ $ActiveTabMenu == 'Architectural-Permit' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-download"></i>
                            <div data-i18n="Layouts">Downloads</div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item {{ $SubActiveMenu == 'Permits' ? 'active' : '' }}">
                                <a href="" class="menu-link">
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
                                <a href="" class="menu-link">
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
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-ban"></i>
                            <div data-i18n="Layouts">Rejection</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('permit.rejections.view-rejected') }}" class="menu-link">
                                    <div data-i18n="Without navbar">Rejected</div>
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

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-gear"></i>
                            <div data-i18n="Account Settings">Options</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('user.options.view-dark-mode') }}" class="menu-link">
                                    <div data-i18n="Account">Settings</div>
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
                                        <a class="dropdown-item" href="{{ route('applicants.accounts.view') }}">
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
                                                            $role = strtolower(Auth::user()->role); // use $user instead of auth()->user()

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

                                                            // Status label
                                                            $statusLabel = strtolower(Auth::user()->status ?? 'inactive');
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
                                                            class="px-2 py-1 rounded text-white {{ Auth::user()->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ ucfirst(Auth::user()->status) }}
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
                                        <a class="dropdown-item" href="{{ route('applicants.accounts.view') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('user.options.view-dark-mode')}}">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Options</span>
                                        </a>
                                    </li>
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
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container">
                            <!-- Welcome Section -->
                            <h3 class="mb-4 fw-bold text-primary text-center text-md-start">
                                Follow the instructions to download the forms you need.
                            </h3>
                            <p class="text-muted text-center text-md-start">
                                Here’s an overview of your application activity, <span class="text-dark">Download the
                                    necessary forms to get started with your application process.</span>
                            </p>

                            <!-- Stats Section -->
                            <div class="row g-3">
                                <!-- Notifications -->
                                <div id="print-area" class="mt-4">
                                    <!-- HEADER -->
                                    <div id="print-area" class="mt-4">
                                        <div class="a4-page">
                                            <img src="{{ asset('images/Architectural_Permit.jpg') }}"
                                                alt="Civil / Structural Permit - Page 1" class="a4-image">
                                        </div>

                                        <!-- PAGE BREAK -->
                                        <div class="page-break"></div>

                                        <!-- PAGE 2 -->
                                        <div class="a4-page">
                                            <img src="{{ asset('images/Architectural_Permit_Page_2.jpg') }}"
                                                alt="Civil / Structural Permit - Page 2" class="a4-image">
                                        </div>
                                        <!-- END OF BOX 9 -->

                                        <!-- ACTION BUTTONS -->
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center gap-3 no-print mt-4">

                                            <a href="{{ route('applicants.downloads.index') }}"
                                                class="btn btn-secondary w-100 w-md-auto">
                                                Back
                                            </a>

                                            <button type="button" class="btn btn-primary w-100 w-md-auto"
                                                data-bs-toggle="modal" data-bs-target="#downloadModal">
                                                Download / Save as PDF
                                            </button>

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="downloadModal" tabindex="-1"
                                            aria-labelledby="downloadModalLabel" aria-hidden="true">
                                            <div
                                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="downloadModalLabel">Reminder Before
                                                            Download</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body fs-6">
                                                        Please make sure that you only fill out the checkmarks or dots in
                                                        the form after downloading the PDF.
                                                        Any other inputs will appear as blank in the form. In addition, the
                                                        Notary Public section should be left blank
                                                        for notarization purposes, we handle the notarization. Thank you!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary btn-sm" id="proceedBtn"
                                                            onclick="ArchitecturaldownloadPDF()" data-bs-dismiss="modal"
                                                            disabled>
                                                            Proceed to Download (5)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- ACTION BUTTONS -->






                                    <!-- Modal -->



                                </div>
                            </div>

                        </div>

                        <!-- Quick Actions -->


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
                <!-- / Footer -->

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