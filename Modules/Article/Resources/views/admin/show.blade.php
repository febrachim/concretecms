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
            <h1 class="m-0 text-dark">{!! config('article.name.show') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.article.index') }}">{!! config('article.name.index') !!}</a></li>
              <li class="breadcrumb-item active">{!! config('article.name.show') !!}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <h3 class="card-title">
                  <i class="fas fa-file-alt"></i>
                  {{ $article->title }}
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <picture>
                  <source srcset="{{ $article->banner_mobile }}" media="(max-width: 767px)"/>
                  <source srcset="{{ $article->banner_mobile }}" media="(max-device-width: 800px) and (orientation: portrait)"/>
                  <img src="{{ $article->banner }}" alt="Article Banner"/>
                </picture>
                <!-- Banner -->
                <article-banner :src="src"></article-banner>
                <ul class="todo-list my-2">
                  <li class="" style="">
                    <p>
                      {!! $article->excerpt !!}
                    </p>
                  </li>
                </ul>
                <!-- /.Banner -->
                <div class="container-fluid">
                  {!! $article->content !!}
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@stop

@section('scripts')
  <script>
    const app = new Vue({
        el: '#app',
        data: {
          src: '{{ asset($article->banner) }}'
        }
      });
  </script>
@endsection
