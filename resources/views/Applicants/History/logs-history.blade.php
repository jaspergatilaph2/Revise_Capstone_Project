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
                    <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform:uppercase">BPMS</span>
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
                        <div data-i18n="Layouts">Notification</div>
                    </a>

                    <ul class="menu-sub">

                        <li class="menu-item">
                            <a href="{{ route('apply.permit.pending') }}" class="menu-link">
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
                <li class="menu-item {{ $ActiveTabMenu === 'Logs' ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <div data-i18n="Misc">Misc</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ $SubActiveTab === 'History' ? 'active' : ''}}">
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

            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
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
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img
                                        src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('sneat/img/avatars/1.png') }}"
                                        alt="User Avatar"
                                        class="w-px-120 h-px-120 rounded-circle" />

                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('applicants.accounts.view') }}">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img
                                                        src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('sneat/img/avatars/1.png') }}"
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
                                    <a class="dropdown-item" href="{{ route('applicants.accounts.view') }}">
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
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = ($logs->currentPage() - 1) * $logs->perPage() + 1; @endphp
                                        @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at->setTimezone(config('app.timezone'))->format('Y-m-d h:i A') }}</td>
                                        </tr>
                                        @endforeach

                                        @if($logs->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No logs found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-m">

                                            {{-- Previous Page Link --}}
                                            @if ($logs->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                            @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $logs->previousPageUrl() }}">Previous</a>
                                            </li>
                                            @endif

                                            {{-- Page Number Links --}}
                                            @foreach ($logs->links()->elements as $element)
                                            @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                            <li class="page-item {{ $logs->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                            @endforeach
                                            @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($logs->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $logs->nextPageUrl() }}">Next</a>
                                            </li>
                                            @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                            @endif

                                        </ul>
                                    </nav>
                                </div>

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