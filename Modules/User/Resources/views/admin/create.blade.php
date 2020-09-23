@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
	<style>
		.user-checkbox .custom-checkbox label  {
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
            <h1 class="m-0 text-dark">{!! config('user.name.create') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">{!! config('user.name.create') !!}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-body">
                @include('backoffice::inc.messages')

                {{ Form::open([
                  'route' => 'admin.user.store',
                  'method' => 'POST',
                  'files' => true
                  ]) }}

                  {!! csrf_field() !!}

                  <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => '']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => '']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('role', 'Role') }}
                    <input type="hidden" name="roles" :value="rolesSelected">
                    <b-form-select v-model="rolesSelected" class="mb-3">
                      <b-form-select-option :value="null" disabled>-- Please select a role to assign --</b-form-select-option>
                      @foreach($roles as $role)
                        <b-form-select-option :value="{{ $role->id }}">{{ $role->name }}</b-form-select-option>  
                      @endforeach
                    </b-form-select>
                  </div>

                  <div class="form-group">
                    <b-form-file
                      v-model="avatar"
                      :state="Boolean(avatar)"
                      placeholder="Choose a file or drop it here..."
                      drop-placeholder="Drop file here..."
                      accept="image/jpeg, image/png"
                      name="avatar"
                    ></b-form-file>
                  </div>

                  <div class="form-group user-checkbox">
                    {{ Form::label('password', 'Password') }}
                    <input type="password" name="password" id="password" class="form-control mb-2" v-if="!auto_password">
                  	<b-form-checkbox
                  	:checked="true"
                  	v-model="auto_password ">
                  		Auto generate password
                  	</b-form-checkbox>
                  </div>

                  <div class="form-group">
                  </div>

                  {{ Form::submit('Create User', ['class' => 'btn btn-primary']) }}

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
        	auto_password: true,
          rolesSelected: 4,
          avatar: null,
        }
      });
  </script>
@endsection
