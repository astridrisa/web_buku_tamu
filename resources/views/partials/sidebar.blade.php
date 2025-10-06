<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!-- Dashboard - Semua role bisa akses -->
    <li class="nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    @if(auth()->check())
      @php
        $userRole = auth()->user()->role_id;
        $currentRoute = request()->route()->getName();
      @endphp

      {{-- ADMIN MENU (role_id = 1) --}}
      @if($userRole == 1)
        <li class="nav-item nav-category">Admin Menu</li>
        
        <!-- User Management -->
        <li class="nav-item {{ str_starts_with($currentRoute, 'admin.users') ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#user-management" 
             aria-expanded="{{ str_starts_with($currentRoute, 'admin.users') ? 'true' : 'false' }}" 
             aria-controls="user-management">
            <i class="menu-icon mdi mdi-account-multiple"></i>
            <span class="menu-title">User Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse {{ str_starts_with($currentRoute, 'admin.users') ? 'show' : '' }}" id="user-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'admin.users.list' ? 'active' : '' }}" 
                   href="{{ route('admin.users.list') }}">
                  <i class="mdi mdi-account-group"></i>
                  Daftar User
                </a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'admin.users.create' ? 'active' : '' }}" 
                   href="{{ route('admin.users.create') }}">
                  <i class="mdi mdi-account-plus"></i>
                  Tambah User
                </a>
              </li> --}}
            </ul>
          </div>
        </li>

        <!-- Tamu Management -->
        {{-- <li class="nav-item {{ str_starts_with($currentRoute, 'admin.tamu') ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#tamu-management" 
             aria-expanded="{{ str_starts_with($currentRoute, 'admin.tamu') ? 'true' : 'false' }}" 
             aria-controls="tamu-management">
            <i class="menu-icon mdi mdi-account-supervisor"></i>
            <span class="menu-title">Tamu Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse {{ str_starts_with($currentRoute, 'admin.tamu') ? 'show' : '' }}" id="tamu-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'admin.tamu.index' ? 'active' : '' }}" 
                   href="{{ route('admin.tamu.index') }}">
                  <i class="mdi mdi-view-list"></i>
                  Daftar Tamu
                </a>
              </li>
            </ul>
          </div>
        </li> --}}
      @endif

      {{-- PEGAWAI MENU (role_id = 2) --}}
      @if($userRole == 2)
        <li class="nav-item nav-category">Staff Menu</li>
        
        <!-- Pegawai Dashboard -->
        {{-- <li class="nav-item {{ $currentRoute == 'pegawai.dashboard' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('pegawai.dashboard') }}">
            <i class="mdi mdi-view-dashboard menu-icon"></i>
            <span class="menu-title">Staff Dashboard</span>
          </a>
        </li> --}}

        <!-- Approval Tamu -->
        <li class="nav-item {{ $currentRoute == 'pegawai.approval' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('pegawai.approval') }}">
            <i class="mdi mdi-check-circle menu-icon"></i>
            <span class="menu-title">Approval Tamu</span>
            @php
              $pendingCount = \App\Models\TamuModel::where('status', 'checkin')->count();
            @endphp
            @if($pendingCount > 0)
              <span class="badge badge-danger ms-auto">{{ $pendingCount }}</span>
            @endif
          </a>
        </li>
      @endif

      {{-- SECURITY MENU (role_id = 3) --}}
      @if($userRole == 3)
        <li class="nav-item nav-category">Security Menu</li>
        <!-- Security Management -->
        <li class="nav-item {{ str_starts_with($currentRoute, 'security.') && !in_array($currentRoute, ['security.index']) ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#security-management" 
             aria-expanded="{{ str_starts_with($currentRoute, 'security.') && !in_array($currentRoute, ['security.index']) ? 'true' : 'false' }}" 
             aria-controls="security-management">
            <i class="menu-icon mdi mdi-shield-check"></i>
            <span class="menu-title">Security Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse {{ str_starts_with($currentRoute, 'security.') && !in_array($currentRoute, ['security.index']) ? 'show' : '' }}" id="security-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'security.list' ? 'active' : '' }}" 
                   href="{{ route('security.list') }}">
                  <i class="mdi mdi-view-list"></i>
                  Daftar Tamu
                </a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link {{ $currentRoute == 'security.create' ? 'active' : '' }}" 
                   href="{{ route('security.create') }}">
                  <i class="mdi mdi-plus-circle"></i>
                  Tambah Tamu
                </a>
              </li> --}}
            </ul>
          </div>
        </li>

        <!-- Check In/Out Actions -->
        {{-- <li class="nav-item nav-category">Actions</li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#checkinModal">
            <i class="mdi mdi-login menu-icon text-success"></i>
            <span class="menu-title">Check In Tamu</span>
          </a>
        </li> --}}
      @endif

      {{-- MENU UMUM UNTUK SEMUA USER YANG LOGIN --}}
      <li class="nav-item nav-category">General</li>
      
      <!-- Profile/Settings -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('profile.index') }}" >
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Profile</span>
        </a>
      </li>

      <!-- Logout -->
      <li class="nav-item">
        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); confirmLogout();">
          <i class="mdi mdi-logout menu-icon"></i>
          <span class="menu-title">Logout</span>
        </a>
      </li>

    @endif
  </ul>
</nav>

{{-- Hidden forms and scripts --}}
@if(auth()->check())
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>

<script>
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endif