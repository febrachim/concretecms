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
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div>

            <br/>
            @foreach($articles as $article)
            <pre>
              {{ $article->categories }}
            </pre>
            @endforeach

            <!-- /.card-header -->
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
                    <th colspan="8"><h3 align="center">Please Wait...</h3></th>
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
              data: 'author_id',
              name: 'author_id'
            },
            {
              data: 'categories',
              name: 'categories'
            },
            {
              data: 'status',
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
