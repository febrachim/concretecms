
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Concrete CMS | Backoffice</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backoffice.css') }}">


    <!-- REQUIRED SCRIPTS -->
    <script src="/js/app.js"></script>
    <script src="{{ asset('js/backoffice.js') }}"></script>

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
      @include('backoffice::inc.navbar')
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      @include('backoffice::inc.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="app">
        @yield('content')
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      @include('backoffice::inc.footer')
      
    </div>
    <!-- ./wrapper -->

    @yield('scripts')
  </body>
</html>
