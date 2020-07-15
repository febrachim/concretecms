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
              <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{!! config('user.name.index') !!}</a></li>
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
          password_options: "keep",
          rolesSelected: {!! $user->roles->pluck('id')->first() ? $user->roles->pluck('id')->first() : '0' !!}
        }
      });
  </script>
@endsection
