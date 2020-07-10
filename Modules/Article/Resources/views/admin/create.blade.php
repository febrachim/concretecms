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
        <div class="row">
          <div class="col-md-3 order-md-2">
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
                    <a href="#" class="nav-link">
                      TES
                    </a>
                  </li>
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
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-body">
                @include('backoffice::inc.messages')

                {{ Form::open([
                  'route' => 'admin.article.store',
                  'method' => 'POST',
                  'files' => true
                  ]) }}

                  {!! csrf_field() !!}

                  <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    <b-form-input type="text" name="title" id="title" size="lg" placeholder="" v-model="title"></b-form-input>
                    <slug-widget url="{{ url('/') }}" subdirectory="article" :title="title" @slug-changed="updateSlug"></slug-widget>
                  </div>

                  <div class="form-group">
                    {{ Form::label('slug', 'slug') }}
                    {{ Form::text('slug', '', ['class' => 'form-control', 'placeholder' => 'slug']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('excerpt', 'Excerpt') }}
                    {{ Form::textarea('excerpt', '', ['class' => 'form-control', 'placeholder' => 'Excerpt']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('content', 'Content') }}
                    {{ Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Content']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('banner_mobile', 'Banner Image') }}
                    {{ Form::file('banner') }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('banner_mobile', 'Mobile Banner Image') }}
                    {{ Form::file('banner_mobile') }}
                  </div>

                  {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}

                {{ Form::close() }}
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
@endsection

@section('scripts')
  <script>
    const app = new Vue({
        el: '#app',
        data: {
          title: '',
          slug: ''
        },
        methods: {
          updateSlug: function(val) {
            this.slug = val;
          }
        }
      });
  </script>
@endsection