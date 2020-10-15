@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
<style>
  .error {
    color:red;
    font-weight: 400 !important;
  } 
</style>
@endsection

@section('jsfile')
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
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
        {{-- @include('backoffice::inc.messages') --}}
        @if (isset($product))
        {{ Form::model($product, [
            'route' => ['admin.product.update',$product->id],
            'method' => 'patch',
            'files' => true,
            'id' => 'product-form'
        ]) }}
        @else
        {{ Form::open([
            'route' => 'admin.product.store',
            'method' => 'POST',
            'files' => true,
            'id' => 'product-form'
        ]) }}
        @endif

      
        <div class="alert alert-success d-none" id="msg_div">
            <span id="res_message"></span>
        </div>
            
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <b-form-group id="fieldset-packshots" label="Pack Shots" label-for="input-packshots">
                            <file-pond
                            name="packshots[]"
                            :files="packshot_files"
                            ref="pond"
                            label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
                            allow-multiple="true"
                            accepted-file-types="image/jpeg, image/png, video/mp4"
                            :files="form.packshots"
                            allow-multiple="true"
                            allow-reorder="true"
                            allow-file-encode="true"
                            instant-upload="false"
                            @updatefiles="onFilePondUpdateFile"
                            />
                            <span class="text-danger">{{ $errors->first('packshots') }}</span>
                        </b-form-group>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body">
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
                            v-model="categories_default"
                            :options="categories_options"
                            tag-placeholder="Add this category"
                            placeholder="Search category"
                            label="text"
                            track-by="value"
                            :multiple="true"
                            id="input-categories"
                            :close-on-select="false"
                            @input="onCategoriesUpdate"></multiselect>
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        {{ Form::close() }}
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
                packshots: [],
            },
            api_token: '{{ Auth::user()->api_token }}',
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }]
            ],
            categories_options: {!! json_encode($checkbox_categories,TRUE) !!},
            packshot_files: [],
            categories_default: null,
        },
        methods: {
            //Set Images to Array
            onFilePondUpdateFile(files){
                this.form.packshots = files.map(files => files.file);
            },
            //Set Categories Value to Array
            onCategoriesUpdate(categories){
                this.form.categories = categories.map(categories => categories.value);
            },
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
    
    // FORM VALIDATION
    if ($("#product-form").length > 0) {
      var validator = $("#product-form").validate({
        ignore: ".ignore",
        rules: {
          'packshots[]': {
            required: true
          }, 
          name: {
            required: true
          },
          slug: {
            required: true
          },
          'categories[]': {
            required: true
          },   
          packaging: {
            required: true
          },   
          overview: {
            required: true
          },   
          composition: {
            required: true
          },   
          instruction: {
            required: true
          } 
        },
        messages: {
          'packshots[]': {
            required: "Please upload at least 1 image"
          },
          name: {
            required: "Please enter name"
          },
          slug: {
            required: "Please enter slug"
          },
          'categories[]': {
            required: "Please select at least 1 category"
          },
          packaging: {
            required: "Please enter packaging"
          },
          overview: {
            required: "Please enter overview"
          },
          composition: {
            required: "Please enter composition"
          },
          instruction: {
            required: "Please enter instruction"
          },
        },
        errorElement : 'small',
        errorPlacement: function (error, element) {
          if (element.is(":checkbox")) {
            $('#categories-error').append(error);
          } else {
            error.insertAfter(element);
          }
        },
        submitHandler: function(form) {
            console.log("submitted");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#btn-submit').html('Sending..');
            $('#btn-submit').attr("disabled", true);
            var formData = new FormData();
            formData.append("name", vue.form.name);
            formData.append("slug", vue.form.slug);
            formData.append("packaging", vue.form.packaging);
            formData.append("overview", vue.form.overview);
            formData.append("composition", vue.form.composition);
            formData.append("instruction", vue.form.instruction);
            //Set all image to formData
            for (var i = 0; i < vue.form.packshots.length; i++) {
                let file = vue.form.packshots[i];
                formData.append("packshots[" + i + "]", file);
            }
            //Set all categories to formData
            for (var i = 0; i < vue.form.categories.length; i++) {
                let category = vue.form.categories[i];
                formData.append("categories[" + i + "]", category);
            }
            console.log(formData);
            $.ajax({
                url: "{{ route('admin.product.store') }}" ,
                type: "POST",
                data: formData,
                mimeType: "multipart/form-data",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function( response ) {
                $('#btn-submit').html('Submit');
                $('#btn-submit').attr("disabled", false);
                $('#res_message').show();
                $('#res_message').html(response.msg);
                $('#msg_div').removeClass('d-none');
                
                vue.form.slug = '';
                vue.form.composition = null;
                vue.form.instruction = null;
                vue.form.categories = null;
                vue.categories_default = [];
                vue.packshot_files = null;
                $('html, body').animate({ scrollTop: 0 }, 500);
                
                document.getElementById("product-form").reset();
                setTimeout(function(){
                    $('#res_message').hide();
                    $('#msg_div').hide();
                },1000);
                }
            });
        }
      })
    }
</script>
@endsection