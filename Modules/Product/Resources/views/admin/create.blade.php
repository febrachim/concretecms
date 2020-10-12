@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->    
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('jsfile')
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{!! config('product.name.create') !!}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{!! config('product.name.create') !!}</li>
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
                        @if (isset($product))
                        {{ Form::model($product, [
                            'route' => ['admin.product.update',$product->id],
                            'method' => 'patch'
                        ]) }}
                        @else
                        {{ Form::open([
                            'route' => 'admin.product.store',
                            'method' => 'POST'
                        ]) }}
                        @endif
                            
                            {!! csrf_field() !!}
                            
                            <b-form-group id="fieldset-name" label="Product Name" label-for="input-name">
                                <b-form-input type="text" name="name" id="input-name" placeholder="" v-model="form.name" ref="name"></b-form-input>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </b-form-group>
                            
                            <b-form-group id="fieldset-slug" label="Slug" label-for="input-slug">
                                <b-form-input type="text" name="slug" id="input-slug" placeholder="" v-model="form.slug" ref="slug" autocomplete="off"></b-form-input>
                                <span class="text-danger">{{ $errors->first('slug') }}</span>
                            </b-form-group>
                            
                            <b-form-group id="fieldset-categories" label="Categories" label-for="input-categories">
                                <multiselect
                                v-model="form.categories"
                                :options="categories_options"
                                tag-placeholder="Add this category"
                                placeholder="Search category"
                                label="text"
                                track-by="value"
                                :multiple="true"
                                id="input-categories"></multiselect>
                                <span class="text-danger">{{ $errors->first('categories') }}</span>
                                <select name="categories[]" style="display:none;" multiple>
                                    <option v-for="category in form.categories" :value="category.value" selected="selected"></option>
                               </select>
                            </b-form-group>

                            <b-form-group
                            id="fieldset-packaging"
                            label="Packaging"
                            label-for="input-packaging"
                            description="e.g. Box, 5 strips @ 6 chewable">
                                <b-form-input type="text" name="packaging" id="input-packaging" placeholder="" v-model="form.packaging" ref="packaging"></b-form-input>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </b-form-group>
              
                            <b-form-group id="fieldset-overview" label="Overview" label-for="input-overview">
                              <b-form-textarea
                              id="input-overview"
                              v-model="form.overview"
                              placeholder=""
                              rows="4"
                              max-rows="6"
                              name="overview"
                              ></b-form-textarea>
                              <span class="text-danger">{{ $errors->first('overview') }}</span>
                            </b-form-group>

                            <b-form-group id="fieldset-composition" label="Composition" label-for="input-composition">
                                <vue-editor v-model="form.composition" :editor-toolbar="customToolbar" class="mb-0" />
                            </b-form-group>
                            <b-form-group class="mt-0">
                                <input name="composition" type="hidden" :value="form.composition" id="form-composition" class="mt-0">
                            </b-form-group> 

                            <b-form-group id="fieldset-instruction" label="Instruction" label-for="input-instruction">
                                <vue-editor v-model="form.instruction" :editor-toolbar="customToolbar" class="mb-0" />
                            </b-form-group>
                            <b-form-group class="mt-0">
                                <input name="instruction" type="hidden" :value="form.instruction" id="form-instruction" class="mt-0">
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
                categories: null,
                packaging: '',
                composition: '',
                overview: '',
                instruction: '',
            },
            api_token: '{{ Auth::user()->api_token }}',
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }]
            ],
            categories_options: {!! json_encode($checkbox_categories,TRUE) !!}
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