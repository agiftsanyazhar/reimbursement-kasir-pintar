<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Data</li>

        <li class="sidebar-item {{ request()->is('dashboard/reimbursment*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.reimbursment.index') }}" class="sidebar-link">
                <i class="bi bi-cash-coin"></i>
                <span>Reimbursment</span>
            </a>
        </li>

        @can('is.direktur')
            <li class="sidebar-item {{ request()->is('dashboard/user*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.user.index') }}" class="sidebar-link">
                    <i class="bi bi-person-fill"></i>
                    <span>User</span>
                </a>
            </li>
        @endcan

    </ul>
</div>