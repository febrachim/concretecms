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
            <h1 class="m-0 text-dark">{!! config('article.name') !!}</h1>
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
    <div class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-body">
              <table id="myTable" class="table table-bordered table-striped">
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
                  @foreach($articles as $article)
                  <tr>
                    <th colspan="8"></th>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script>
      jQuery(document).ready(function($){
        $.noConflict();
        var table = $('#myTable').DataTable({
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
