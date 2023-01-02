<ul class="menu">
    <li class="sidebar-title">Menu</li>

    <li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
        <a href="{{ url('admin/dashboard') }}" class="sidebar-link">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
        <a href="{{ url('admin/users') }}" class="sidebar-link">
            <i class="bi bi-person-fill"></i>
            <span>Users</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/daftar-pegawai*') ? 'active' : '' }}">
        <a href="{{ url('admin/daftar-pegawai') }}" class="sidebar-link">
            <i class="bi bi-file-earmark-person-fill"></i>
            <span>Daftar Pegawai</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/data-barang*') ? 'active' : '' }}">
        <a href="{{ url('admin/data-barang') }}" class="sidebar-link">
            <i class="bi bi-clipboard-data-fill"></i>
            <span>Data Barang</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/riwayat*') ? 'active' : '' }}">
        <a href="{{ url('admin/riwayat') }}" class="sidebar-link">
            <i class="bi bi-clock-fill"></i>
            <span>Riwayat</span>
        </a>
    </li>
</ul>
