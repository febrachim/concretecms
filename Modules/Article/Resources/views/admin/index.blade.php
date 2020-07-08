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
            <h1 class="m-0 text-dark">{!! config('article.name.index') !!}</h1>
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
      <div class="row">
        <div class="col-md-2 order-md-2">
          <a href="{{ route('admin.article.create') }}" class="btn btn-primary btn-block mb-3">New Article</a>

          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0" style="display: none;">
              <ul class="nav nav-pills flex-column">
                @foreach($categories as $category)
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    {{ $category->name }}
                    <span class="badge bg-primary float-right">{{ $category->articles_count }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <a href="{{ route('admin.article.create') }}" class="btn btn-default btn-block btn-flat"><i class="fas fa-plus"></i> New Category</a>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-10">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="articleTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Categories</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Published At</th>
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
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <script>
      jQuery(document).ready(function($){
        $.noConflict();
        var table = $('#articleTable').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax:{
            url: "{{ route('admin.article.index') }}"
          },
          columns: [
            {
              data: 'title',
              name: 'title'
            },
            {
              data: 'author.name',
              name: 'author.name',
            },
            {
              data: function (row) {
                       let categoryNames= [];
                         $(row.categories).each(function (i, e) {
                           categoryNames.push(e.name);
                           });
                         return categoryNames.join(", ")
                       },
              name: 'categories',
              orderable: false
            },
            {
              data: function(e) {
                if(e.status == 1) {
                  return "published"
                } else if(e.status == 0) {
                  return "draft"
                } else {
                  return "deleted"
                }
              },
              name: 'status'
            },
            {
              data: 'created_at',
              name: 'created_at'
            },
            {
              data: 'published_at',
              name: 'published_at'
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
