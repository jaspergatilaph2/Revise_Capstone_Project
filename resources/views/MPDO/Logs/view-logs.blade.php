@extends('layouts.app-dashboard')

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

                    <li class="menu-item">
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
                            <li class="menu-item">
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



                    @php
                        use Illuminate\Support\Facades\Auth;

                        $staffCount = App\Models\User::where('role', 'mpdo_staff')->count();
                    @endphp

                    @if(Auth::user()->role == 'mpdo')
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">MPDO Staff</span>
                        </li>

                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon fa-solid fa-person fa-2x"></i>
                                <div>Staff Or Employee</div>
                            </a>

                            <ul class="menu-sub">

                                {{-- Show Add Staff only if no staff exists --}}
                                @php
    $staffCount = App\Models\User::where('role', 'mpdo_staff')->count();
@endphp

{{-- Only show Adding Staff if the logged-in user is main MPDO admin --}}
@if(Auth::user()->role == 'mpdo')
    <li class="menu-item">
        <a href="{{ route('staff.management.view-staff') }}" class="menu-link">
            <div>Adding Staff</div>
        </a>
    </li>
@endif

                                <li class="menu-item">
                                    <a href="{{ route('staff.management.view-add-staff') }}" class="menu-link">
                                        <div>View Staff</div>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif

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
                    <li class="menu-item {{ $ActiveTabMenu == 'Logs' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Misc">Misc</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ $SubActiveTab == 'View Logs' ? 'active' : '' }}">
                                <a href="{{ route('mpdo.logs.view-logs') }}" class="menu-link">
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
                                                            } elseif ($role === 'mpdo_staff') {
                                                                $roleLabel = 'MPDO STAFF';
                                                            }
                                                            else {
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
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Logs /</span>History</h4>
                        <ul class="nav nav-pills flex-column flex-md-row mb-4">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Logs
                                </a>
                            </li>
                        </ul>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Logs History</h5>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-nowrap bg-white rounded-3 p-3 shadow-sm">
    <h5 class="fw-bold mb-3">MPDO Logs</h5>

    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width: 5%;">#</th>
                <th>Description</th>
                <th class="text-center" style="width: 20%;">Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = ($logs->currentPage() - 1) * $logs->perPage() + 1; @endphp

            @forelse($logs as $log)
                <tr>
                    <td class="text-center">{{ $counter++ }}</td>
                    <td>
                        <i class="fa-solid fa-file-lines text-primary me-2"></i>
                        {{ $log->description }}
                    </td>
                    <td class="text-center text-muted small">
                        {{ $log->created_at->setTimezone('Asia/Manila')->format('Y-m-d h:i A') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted fst-italic">No MPDO logs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>
                            </div>
                        </div>


                    </div>


                    <!-- Footer -->
                    <footer class="content-footer footer mt-4 border-top">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-3 flex-md-row flex-column text-center text-md-start">

                            <div class="mb-2 mb-md-0">
                                © <span id="year"></span>,
                                <span class="fw-bold text-primary">Building Permit Management System</span>
                            </div>

                            <div>
                                <a href="#" class="footer-link me-3 nav-link d-inline">Documentation</a>
                                <a href="#" class="footer-link me-3 nav-link d-inline">Support</a>
                                <a href="#" class="footer-link nav-link d-inline">Contact</a>
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