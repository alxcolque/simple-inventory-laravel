<nav class="sidebar sidebar-offcanvas no-print" id="sidebar">
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
    <a class="sidebar-brand brand-logo" href="{{ url('/') }}"><b class="text-warning">{{ config('app.name', 'Laravel') }}</b> </a>
    <a class="sidebar-brand brand-logo-mini" href="{{ url('/') }}"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
  </div>
  <ul class="nav">
    <li class="nav-item menu-items {{ request()->is('home') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('home') }}">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer"></i>
        </span>
        <span class="menu-title">Inicio</span>
      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">PRODUCTO</span>
    </li>
    @if(auth()->user()->role == 'admin')
    <!-- Categories -->
    <li class="nav-item menu-items {{ request()->is('categories') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('categories.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-format-list-bulleted"></i>
        </span>
        <span class="menu-title">Categorías</span>
      </a>
    </li>
    <!-- Products -->
    <li class="nav-item menu-items {{ request()->is('products') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('products.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-food"></i>
        </span>
        <span class="menu-title">Productos</span>
      </a>
    </li>
    @endif
    <!-- Purchases -->
    <li class="nav-item menu-items {{ request()->is('purchases') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('purchases.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-cart"></i>
        </span>
        <span class="menu-title">Compras</span>
      </a>
    </li>

    <!-- Sales -->
    <li class="nav-item menu-items {{ request()->is('sales') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('sales.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-cash-multiple"></i>
        </span>
        <span class="menu-title">Ventas</span>
      </a>
    </li>
    <li class="nav-item nav-category">
        <span class="nav-link">PERSONAL</span>
      </li>
    <!-- Users -->
    <!-- acceso a Users solo admin -->
    @if(auth()->user()->role == 'admin')
    <li class="nav-item menu-items {{ request()->is('users') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-multiple"></i>
        </span>
        <span class="menu-title">Usuarios</span>
      </a>
    </li>
    @endif
    <!-- Clients -->
    <li class="nav-item menu-items {{ request()->is('clients') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clients.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-group"></i>
        </span>
        <span class="menu-title">Clientes</span>
      </a>
    </li>
    @if(auth()->user()->role == 'admin')
    <!-- Suppliers -->
    <li class="nav-item menu-items {{ request()->is('suppliers') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('suppliers.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-truck"></i>
        </span>
        <span class="menu-title">Proveedores</span>
        </a>
    </li>
    @endif
  </ul>
</nav>
