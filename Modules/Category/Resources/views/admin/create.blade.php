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
                <h1 class="m-0 text-dark">{!! config('category.name.create') !!}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{!! config('category.name.create') !!}</li>
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
                        @if (isset($category))
                        {{ Form::model($category, [
                            'route' => ['admin.category.update',$category->id],
                            'method' => 'patch'
                        ]) }}
                        @else
                        {{ Form::open([
                            'route' => 'admin.category.store',
                            'method' => 'POST'
                        ]) }}
                        @endif
                            
                            {!! csrf_field() !!}
                            
                            <b-form-group id="fieldset-name" label="Category Name" label-for="input-name">
                                <b-form-input type="text" name="name" id="input-name" placeholder="" v-model="form.name" ref="name" autocomplete="off"></b-form-input>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </b-form-group>
                            
                            <b-form-group id="fieldset-slug" label="Slug" label-for="input-slug">
                                <b-form-input type="text" name="slug" id="input-slug" placeholder="" v-model="form.slug" ref="slug" autocomplete="off"></b-form-input>
                                <span class="text-danger">{{ $errors->first('slug') }}</span>
                            </b-form-group>
                            
                            <b-form-group>
                                <b-button type="submit" id="btn-submit" variant="primary">Submit</b-button>
                            </b-form-group>
                        {{ Form::close() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>
    <!-- /.content -->
    @endsection
    
    @section('scripts')
    <script>
        const vue = new Vue({
            el: '#app',
            data: {
                form: {
                    name: '{!! isset($category) ? $category->name : '' !!}',
                    slug: Slug('{!! isset($category) ? $category->slug : '' !!}'),
                },
                api_token: '{{ Auth::user()->api_token }}',
            },
            watch: {
                'form.name': function(val) {
                    this.form.slug = Slug(val);
                },
                'form.slug': function(val) {
                    this.form.slug = Slug(val);
                }
            }
        });
    </script>
    @endsection
    