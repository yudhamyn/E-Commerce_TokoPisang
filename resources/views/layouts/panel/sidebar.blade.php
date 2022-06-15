<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background:linear-gradient(to right,#e8b133,#e8b133);">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('') }}">
        <div class="sidebar-brand-text mx-3"> {{ env('APP_NAME') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    <div id="sidebar--menu">
        @if (auth()->user()->level->primary == 1)
            <li class="nav-item {{ request()->segment(2) == 'dashboard'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/admin/dashboard">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ request()->segment(2) == 'products'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/admin/products">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span></a>
            </li>
            <li class="nav-item {{ request()->segment(2) == 'transactions'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/admin/transactions">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Transaksi</span></a>
            </li>
            <li class="nav-item {{ request()->segment(2) == 'chats'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/admin/chats">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Chat</span></a>
            </li>
            <li class="nav-item {{ request()->segment(2) == 'user-management'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/admin/user-management">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manajemen User</span></a>
            </li>
        @else
            <li class="nav-item {{ request()->segment(2) == 'transactions'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/user/transactions">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Transaksi</span></a>
            </li>
            <li class="nav-item {{ request()->segment(2) == 'chats'? 'active' : '' }}">
                <a class="nav-link" href="{{ url('') }}/user/chats">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Chat</span></a>
            </li>
        @endif
    </div>

</ul>