@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
@endsection

@section('jsfile')
<!-- Scripts -->
@endsection

@section('content')
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{!! config('article.name.create') !!}</h1>
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
        @include('backoffice::inc.messages')
      </div>

      <div class="container-fluid">

          <create-article-component :options="options" :url="url" :token="api_token"></create-article-component>

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
  <script>
    const app = new Vue({
        el: '#app',
        data: {
          title: '',
          categories: '',
          slug: '',
          api_token: '{{ Auth::user()->api_token }}',
          selected: [],
          options: {!! json_encode($checkbox_categories,TRUE) !!},
          url: '{{ url('/') }}',
          blank: ''
        }
      });
  </script>
@endsection