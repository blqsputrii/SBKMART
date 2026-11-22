<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item me-3 d-none d-md-block">
        <i class="bi bi-person-circle"></i>
        <strong>{{ session('user_name') }}</strong>
        <span class="badge text-bg-secondary">{{ session('user_role_name') }}</span>
      </li>
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
