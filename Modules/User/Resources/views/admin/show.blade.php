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
            <h1 class="m-0 text-dark">{!! config('user.name.show') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{!! config('user.name.index') !!}</a></li>
              <li class="breadcrumb-item active">{!! config('user.name.show') !!}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/profile.png') }}" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center mb-0">{{ $user->name }}</h3>

                @foreach($user->roles as $role)
                  <p class="text-muted text-center mt-0 mb-1">
                    <small>({{ $role->name }})</small>
                  </p>
                @endforeach

                <p class="text-muted text-center mt-0">{{ $user->email }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Articles</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Published</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Draft</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary btn-block">Edit Data</a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <h3 class="card-title">
                  <i class="fas fa-file-alt"></i>
                  Latest Articles
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                  <!-- Post -->
                  <div class="post">
                    <div class="user-block">
                      <img class="img-bordered-sm" src="https://via.placeholder.com/640/333333/808080" alt="user image">
                      <span class="username">
                        <a href="#">Article Title</a>
                      </span>
                      <span class="description">Published - [Date]</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      Lorem ipsum represents a long-held tradition for designers,
                      typographers and the like. Some people hate it and argue for
                      its demise, but others ignore the hate as they create awesome
                      tools to help create filler text for everyone from bacon lovers
                      to Charlie Sheen fans.
                    </p>
                    <p>
                      <a href="#" class="">Read more</a>
                    </p>
                  </div>
                  <!-- /.post -->
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
