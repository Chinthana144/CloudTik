<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="bx bx-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="/dashboard">CloudTik</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            {{-- home page access id = 1 --}}
            @can('page_access', 1)
                <li class="sidebar-item">
                    <a href="/home" class="sidebar-link">
                        <i class="bx bx-home fs-3"></i>
                        <span>Home</span>
                    </a>
                </li>
            @endcan

            {{-- invoice page access id = 2 --}}
            @can('page_access', 2)
                <li class="sidebar-item">
                    <a href="/counter" class="sidebar-link">
                        <i class="bx bx-receipt fs-3"></i>
                        <span>Invoice</span>
                    </a>
                </li>
            @endcan

            {{-- customers page access id = 3 --}}
            @can('page_access', 3)
                <li class="sidebar-item">
                    <a href="/customers" class="sidebar-link">
                        <i class="bx bx-group fs-3"></i>
                        <span>Customers</span>
                    </a>
                </li>
            @endcan

            {{-- packages page access id = 4 --}}
            @can('page_access', 4)
                <li class="sidebar-item">
                    <a href="/packages" class="sidebar-link">
                        <i class="bx bx-layer fs-3"></i>
                        <span>Packages</span>
                    </a>
                </li>
            @endcan

            {{-- subscriptions page access id = 5 --}}
            @can('page_access', 5)
                <li class="sidebar-item">
                    <a href="/view-subscription" class="sidebar-link">
                        <i class="bx bx-cloud-download fs-3"></i>
                        <span>Subscriptions</span>
                    </a>
                </li>
            @endcan

            {{-- control page access id = 5 --}}
            @can('page_access', 7)
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="bx bx-slider fs-3"></i>
                        <span>Control</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/useraccess" class="sidebar-link">User Access</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/campusers" class="sidebar-link">Camp Access</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/rolepages" class="sidebar-link">Role Pages</a>
                        </li>
                    </ul>
                </li>
            @endcan


            {{-- <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                    <i class="lni lni-layout"></i>
                    <span>Multi Level</span>
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                            data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                            Two Links
                        </a>
                        <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 1</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}

            {{-- settings page access id = 8 --}}
            @can('page_access', 8)
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#settings" aria-expanded="false" aria-controls="auth">
                        <i class="bx bx-cog fs-3"></i>
                        <span>Settings</span>
                    </a>
                    <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/camps" class="sidebar-link">Camps</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/users-list" class="sidebar-link">Users</a>
                        </li>
                    </ul>
                </li>
            @endcan

            {{-- reports page access id = 6 --}}
            @can('page_access', 6)
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="bx bx-file fs-3"></i>
                        <span>Reports</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/sales_reports" class="sidebar-link">Sales Reports</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Customer Reports</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Packages Reports</a>
                        </li>
                    </ul>
                </li>
            @endcan


            <li class="sidebar-item">
                <a href="/mikrotik" class="sidebar-link">
                    <i class="bx bx-box fs-3"></i>
                    <span>Mikrotik</span>
                </a>
            </li>
        </ul>

        {{-- logout --}}
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="sidebar-link"
                    style="background-color: inherit; border:none; color:white; margin-left:10px;">
                    <i class="bx bx-exit fs-3"></i>
                </button>
            </form>
        </div>

    </aside>

    <div class="main p-3">
        <div class="text-left">
            <h5>
                <b>CloudTik</b> User Management System
            </h5>
        </div>

        @yield('content')
    </div>
    <div id="footer">
        <p>
            © 2025 Trizent. All rights reserved.
            <br>
            Powered by Trizent Software.
        </p>
    </div>
</div>
