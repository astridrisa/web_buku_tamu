<nav class="navbar navbar-expand-lg navbar-dark bg-dark default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="{{ url('/') }}">
  <img src="{{ asset('img/logopjt.png') }}" alt="logo" style="height:70px; width:auto;" />
</a>
<a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
  <img src="{{ asset('img/logopjt.png') }}" alt="logo-mini" style="height:50px; width:auto;" />
</a>

    </div>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text text-white">
          Selamat Datang, <span class="fw-bold">{{ Auth::user()->name }}!</span>
        </h1>
        <h3 class="welcome-sub-text text-white">Sistem Informasi Buku Tamu</h3>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto">
      {{-- Dropdown kategori --}}
      {{-- <li class="nav-item dropdown d-none d-lg-block">
        <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#"
          data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
          aria-labelledby="messageDropdown">
          <a class="dropdown-item py-3">
            <p class="mb-0 font-weight-medium float-left">Select category</p>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Bootstrap Bundle</p>
              <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Angular Bundle</p>
              <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">VUE Bundle</p>
              <p class="fw-light small-text mb-0">Bundle of 6 Premium Vue Admin Dashboard</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">React Bundle</p>
              <p class="fw-light small-text mb-0">Bundle of 8 Premium React Admin Dashboard</p>
            </div>
          </a>
        </div>
      </li> --}}

      {{-- Datepicker --}}
      {{-- <li class="nav-item d-none d-lg-block">
        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
          <span class="input-group-addon input-group-prepend border-right">
            <span class="icon-calendar input-group-text calendar-icon"></span>
          </span>
          <input type="text" class="form-control">
        </div>
      </li> --}}

      {{-- Search --}}
      {{-- <li class="nav-item">
        <form class="search-form" action="#">
          <i class="icon-search"></i>
          <input type="search" class="form-control" placeholder="Search Here" title="Search here">
        </form>
      </li> --}}

      {{-- Notifikasi --}}
     <li class="nav-item dropdown">
        <a class="nav-link position-relative" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="mdi mdi-bell-outline fs-3"></i>
          <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger" id="notif-badge" style="display: none;">
            0
            <span class="visually-hidden">unread messages</span>
          </span>
        </a>

        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" 
             aria-labelledby="notificationDropdown" 
             style="width: 380px; max-height: 450px; overflow-y: auto;">
          
          <div class="dropdown-header d-flex justify-content-between align-items-center py-3 border-bottom sticky-top bg-white">
            <h6 class="mb-0 font-weight-medium">Notifikasi</h6>
            <button class="btn btn-sm btn-link text-primary p-0" id="mark-all-read">
              <small>Tandai semua dibaca</small>
            </button>
          </div>

          <div id="notification-list">
            <div class="text-center py-4">
              <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </li>

      {{-- Email --}}
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="icon-mail icon-lg"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
          aria-labelledby="countDropdown">
          <a class="dropdown-item py-3">
            <p class="mb-0 font-weight-medium float-left">You have 7 unread mails</p>
            <span class="badge badge-pill badge-primary float-right">View all</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="mdi mdi-account-circle text-primary" style="font-size: 64px;"></i>
              {{-- <img src="{{ asset('assets/images/faces/face10.jpg') }}" alt="image" class="img-sm profile-pic"> --}}
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner</p>
              <p class="fw-light small-text mb-0">The meeting is cancelled</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="mdi mdi-account-circle text-primary" style="font-size: 64px;"></i>
              {{-- <img src="{{ asset('assets/images/faces/face12.jpg') }}" alt="image" class="img-sm profile-pic"> --}}
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey</p>
              <p class="fw-light small-text mb-0">The meeting is cancelled</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="mdi mdi-account-circle text-primary" style="font-size: 64px;"></i>
              {{-- <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="image" class="img-sm profile-pic"> --}}
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins</p>
              <p class="fw-light small-text mb-0">The meeting is cancelled</p>
            </div>
          </a>
        </div>
      </li>

      {{-- User dropdown --}}
     <li class="nav-item dropdown d-none d-lg-block user-dropdown">
      <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        {{-- <i class="mdi mdi-account-circle text-white" style="font-size: 45px;"></i> --}}
        <img class="img-xs rounded-circle" src="{{ Auth::user()?->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/images/user.jpg') }}" alt="Profile image">
      </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
        <div class="dropdown-header text-center">
          {{-- <i class="mdi mdi-account-circle text-primary" style="font-size: 64px;"></i> --}}
          <img class="img-xs rounded-circle" src="{{ Auth::user()?->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/images/user.jpg') }}" alt="Profile image">
          <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
          <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
        </div>
        <a class="dropdown-item" href="{{ route('profile.index') }}">
          <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>
          My Profile
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">
            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Sign Out
          </button>
        </form>
      </div>
    </li>
    </ul>

    {{-- Toggle offcanvas menu (mobile) --}}
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    setInterval(loadNotifications, 30000); // Refresh setiap 30 detik

    document.getElementById('mark-all-read')?.addEventListener('click', function(e) {
        e.preventDefault();
        markAllAsRead();
    });
});

function loadNotifications() {
    // Tentukan route berdasarkan role
    let route = '';
    @if(Auth::user()->role_id == 3)
        route = '{{ route("security.notifications") }}';
    @elseif(Auth::user()->role_id == 2)
        route = '{{ route("pegawai.notifications") }}';
    @endif

    if (!route) return;

    fetch(route, {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateNotificationBadge(data.unread_count);
            renderNotifications(data.notifications);
        }
    })
    .catch(error => console.error('Error loading notifications:', error));
}

function updateNotificationBadge(count) {
    const badge = document.getElementById('notif-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline-block' : 'none';
    }
}

function renderNotifications(notifications) {
    const container = document.getElementById('notification-list');
    
    if (notifications.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="mdi mdi-bell-off-outline" style="font-size: 48px; opacity: 0.3;"></i>
                <p class="mt-3 mb-0">Tidak ada notifikasi</p>
            </div>
        `;
        return;
    }

    let html = '';
    notifications.forEach(notif => {
        const isUnread = !notif.read_at;
        const bgClass = isUnread ? 'bg-light' : '';
        const data = notif.data;
        const icon = data.icon || 'mdi-bell';
        const timeAgo = formatTimeAgo(notif.created_at);

        html += `
            <a class="dropdown-item preview-item py-3 border-bottom ${bgClass}" 
               href="${data.action_url || '#'}" 
               onclick="markAsRead('${notif.id}', event)">
                <div class="preview-thumbnail">
                    <i class="mdi ${icon} m-auto text-primary" style="font-size: 32px;"></i>
                </div>
                <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject fw-normal text-dark mb-1">
                        ${data.title || 'Notifikasi'}
                        ${isUnread ? '<span class="badge bg-primary badge-sm ms-2">Baru</span>' : ''}
                    </h6>
                    <p class="fw-light small mb-1">${data.message || ''}</p>
                    <p class="fw-light text-muted mb-0" style="font-size: 11px;">
                        <i class="mdi mdi-clock-outline"></i> ${timeAgo}
                    </p>
                </div>
            </a>
        `;
    });

    container.innerHTML = html;
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) return 'Baru saja';
    if (seconds < 3600) return Math.floor(seconds / 60) + ' menit yang lalu';
    if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam yang lalu';
    if (seconds < 604800) return Math.floor(seconds / 86400) + ' hari yang lalu';
    
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

function markAsRead(notificationId, event) {
    let route = '';
    @if(Auth::user()->role_id == 3)
        route = '{{ url("security/notifications") }}/' + notificationId + '/read';
    @elseif(Auth::user()->role_id == 2)
        route = '{{ url("pegawai/notifications") }}/' + notificationId + '/read';
    @endif

    if (!route) return;

    fetch(route, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

function markAllAsRead() {
    let route = '';
    @if(Auth::user()->role_id == 3)
        route = '{{ route("security.notifications.mark-all-read") }}';
    @elseif(Auth::user()->role_id == 2)
        route = '{{ route("pegawai.notifications.mark-all-read") }}';
    @endif

    if (!route) return;

    fetch(route, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}
</script>