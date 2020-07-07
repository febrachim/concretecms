
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Concrete CMS | Backoffice</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/backoffice.css') }}">


  <!-- REQUIRED SCRIPTS -->
  <script src="/js/app.js"></script>
  <script src="{{ mix('js/backoffice.js') }}"></script>

  <!-- Datatables required scripts -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>

  @yield('cssfile')
  @yield('jsfile')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>{{ __(' Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('img/logo-concrete.png') }}" alt="Concrete Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Concrete CMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.dashboard' ) ?  'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ strpos(\Request::route()->getName(), 'admin.article.') === 0 ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ strpos(\Request::route()->getName(), 'admin.article.') === 0 ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Articles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.article.index') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.article.index' ) ?  'active' : '' }}">
                  <i class="fas fa-caret-right nav-icon fa-xs"></i>
                  <p>All Articles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.article.create') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.article.create' ) ?  'active' : '' }}">
                  <i class="fas fa-caret-right nav-icon fa-xs"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon fa-xs"></i>
                  <p>Categories</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    {{-- <div class="float-right d-none d-sm-inline">
      Kekanan Kekanan
    </div> --}}
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 Concrete Jakarta.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
</body>
</html>
