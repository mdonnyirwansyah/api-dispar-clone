<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ config('app.name') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="{{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/') }}">
        <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-header">News</li>
    <li class="nav-item dropdown {{ request()->is('news/categories') || request()->is('news') ? 'active' : '' }}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-newspaper"></i> <span>News</span>
      </a>
      <ul class="dropdown-menu">
        <li class="{{ request()->is('news/categories') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('news.categories.index') }}">Categories</a>
        </li>
      </ul>
    </li>
    
    <li class="menu-header">Users</li>
    <li>
      <a class="nav-link" href="">
        <i class="fas fa-users"></i> <span>Users</span>
      </a>
    </li>
  </ul>
</aside>
