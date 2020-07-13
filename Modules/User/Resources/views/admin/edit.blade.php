@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
	<style>
		.user-checkbox .custom-radio label  {
			font-weight: 400 !important;
		}
	</style>
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
            <h1 class="m-0 text-dark">{!! config('user.name.edit') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">{!! config('user.name.edit') !!}</li>
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
                  'route' => ['admin.user.update', $user->id],
                  'method' => 'POST'
                  ]) }}

                  @method('PUT')

                  {!! csrf_field() !!}

                  <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', $value = $user->name, ['class' => 'form-control', 'placeholder' => '']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', $value = $user->email, ['class' => 'form-control', 'placeholder' => '']) }}
                  </div>

                  <div class="form-group user-checkbox">
                    {{ Form::label('password', 'Password') }}

                    <b-form-radio-group v-model="password_options" name="password_options">
                      <b-form-group>
                        <b-form-radio value="keep">Do not change password</b-form-radio>
                      </b-form-group>
                      <b-form-group>
                        <b-form-radio value="auto">Auto-generate new password</b-form-radio>
                      </b-form-group>
                      <b-form-group>
                        <b-form-radio value="manual">Manually set a new password</b-form-radio>
                      </b-form-group>
                    </b-form-radio-group>

                    <input type="password" name="password" id="password" class="form-control mb-2" v-if="password_options == 'manual'" placeholder="Set password manually">
                  </div>

                  {{ Form::submit('Edit User', ['class' => 'btn btn-primary']) }}

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
          password_options: "keep"
        }
      });
  </script>
@endsection
