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
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
        <li class="nav-item has-treeview {{ strpos(\Request::route()->getName(), 'admin.article.') === 0 || strpos(\Request::route()->getName(), 'admin.category.') === 0 ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ strpos(\Request::route()->getName(), 'admin.article.') === 0 || strpos(\Request::route()->getName(), 'admin.category.') === 0 ? 'active' : '' }}">
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
                <p>Add New Article</p>
              </a>
            </li>
            <li class="nav-item has-treeview {{ strpos(\Request::route()->getName(), 'admin.category.') === 0 ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="fas fa-caret-right nav-icon fa-xs"></i>
                <p>
                  Categories
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="{{ strpos(\Request::route()->getName(), 'admin.category.') === 0 ? 'display: block;' : 'display: none;' }}">
                <li class="nav-item">
                  <a href="{{ route('admin.category.index') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.category.index' ) ?  'active' : '' }}">
                    <i class="fas fa-angle-right"></i>
                    <p>All Categories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-angle-right"></i>
                    <p>Add New Category</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview {{ strpos(\Request::route()->getName(), 'admin.user.') === 0 ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ strpos(\Request::route()->getName(), 'admin.user.') === 0 ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.user.index' ) ?  'active' : '' }}">
                <i class="fas fa-caret-right nav-icon fa-xs"></i>
                <p>All Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.user.create') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.user.create' ) ?  'active' : '' }}">
                <i class="fas fa-caret-right nav-icon fa-xs"></i>
                <p>Add New</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.media.index') }}" class="nav-link {{ Route::currentRouteNamed( 'admin.media.index' ) ?  'active' : '' }}">
            <i class="nav-icon fas fa-images"></i>
            <p>
              Media
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>