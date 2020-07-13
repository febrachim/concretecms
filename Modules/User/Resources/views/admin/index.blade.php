@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
@stop

@section('jsfile')
<!-- Scripts -->
@stop

@section('content')
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{!! config('user.name.index') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th colspan="8">
                        <h3 align="center">
                          Please wait...
                        </h3>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <script>
      jQuery(document).ready(function($){
        $.noConflict();
        var table = $('#userTable').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax:{
            url: "{{ route('admin.user.index') }}"
          },
          columns: [
            {
              data: 'name',
              name: 'name'
            },
            {
              data: 'email',
              name: 'email',
            },
            {
              data: function (row) {
                       let roleNames= [];
                         $(row.roles).each(function (i, e) {
                           roleNames.push(e.name);
                           });
                         return roleNames.join(", ")
                       },
              name: 'roles',
              orderable: false
            },
            {
              data: 'created_at',
              name: 'created_at'
            },
            {
              data: 'action',
              name: 'action',
              orderable: false
            },
          ]
        });
      });
    </script>
@stop
