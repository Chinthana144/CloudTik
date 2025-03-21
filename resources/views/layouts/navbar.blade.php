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
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bx bx-receipt fs-3"></i>
                    <span>Invoice</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/customers" class="sidebar-link">
                    <i class="bx bx-group fs-3"></i>
                    <span>Customers</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/packages" class="sidebar-link">
                    <i class="bx bx-layer fs-3"></i>
                    <span>Packages</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bx bx-cloud-download fs-3"></i>
                    <span>Subscriptions</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="bx bx-slider fs-3"></i>
                    <span>Control</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">User Access</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/campusers" class="sidebar-link">Camp Access</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Pages</a>
                    </li>
                </ul>
            </li>

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
                        <a href="#" class="sidebar-link">Users</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-cog"></i>
                    <span>Setting</span>
                </a>
            </li> --}}
        </ul>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <div class="main p-3">
        <div class="text-left">
            <h1>
                CloudTik Network Providers
            </h1>
        </div>

        @yield('content')
    </div>

</div>
