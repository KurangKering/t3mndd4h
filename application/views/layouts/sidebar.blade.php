<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ base_url('index.html') }}">Haji</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ base_url('index.html') }}">Hj</a>
    </div>
    <ul class="sidebar-menu">

      <li class="menu-header">Starter</li>
      
      <li><a class="nav-link" href="{{ base_url('dashboard') }}"><i class="far fa-square"></i> <span>Dashboard</span></a></li>

      @if ($user['role'] == "prov")
      <li><a class="nav-link" href="{{ base_url('data-pengguna') }}"><i class="far fa-square"></i> <span>Pengguna</span></a></li>
      @endif

      @if ($user['role'] == "prov")

      <li><a class="nav-link" href="{{ base_url('data-kota') }}"><i class="far fa-square"></i> <span>Data Kota</span></a></li>
      @endif


      <li><a class="nav-link" href="{{ base_url('data-haji') }}"><i class="far fa-square"></i> <span>Data Haji</span></a></li>

      @if ($user['role'] == "prov")

      <li><a class="nav-link" href="{{ base_url('treemap') }}"><i class="far fa-square"></i> <span>Treemap</span></a></li>
      @endif

      {{-- <li class="dropdown">
        <a href="{{ base_url('#') }}" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ base_url('layout-default.html') }}">Default Layout</a></li>
          <li><a class="nav-link" href="{{ base_url('layout-transparent.html') }}">Transparent Sidebar</a></li>
          <li><a class="nav-link" href="{{ base_url('layout-top-navigation.html') }}">Top Navigation</a></li>
        </ul>
      </li> --}}
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
        ===
      </a>
    </div>        </aside>
  </div>