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
{{-- {{ dd($checkbox_categories) }} --}}
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 id="title-create-article" class="m-0 text-dark">{!! config('article.name.create') !!}</h1>
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
    {{ Form::open([
      'route' => 'admin.article.store',
      'method' => 'POST',
      'files' => true,
      'id' => 'article-form'
      ]) }}
      
      <div class="alert alert-success d-none" id="msg_div">
        <span id="res_message"></span>
      </div>
      
      {!! csrf_field() !!}
      <div class="row">
        <div class="col-md-3 order-md-2">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                @for ($i = 0; $i < count($checkbox_categories); $i++)
                <div class="form-check">
                  {!! Form::checkbox('categories[]', $checkbox_categories[$i]['value'], null, ['id' => 'category-'.$i, 'class' => 'form-check-input']) !!}
                  {!! Form::label('category-'.$i, $checkbox_categories[$i]['text'], ['class' => 'font-weight-normal']) !!}
                </div>
                @endfor
                <div id="categories-error"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-body">
              
              <b-form-group id="fieldset-title" label="Title" label-for="input-title">
                <b-form-input type="text" name="title" id="input-title" size="lg" placeholder="" v-model="form.title" ref="title" autocomplete="off"></b-form-input>
                
                <slug-widget ref="slug" name="slug-edit" :url="url" subdirectory="article" :title="form.title" @slug-changed="updateSlug"></slug-widget>
                <input type="hidden" name="slug" :value="form.slug" class="ignore" id="form-slug">
              </b-form-group>
              
              <b-form-group id="fieldset-excerpt" label="Excerpt" label-for="input-excerpt">
                <b-form-textarea
                id="input-excerpt"
                v-model="form.excerpt"
                placeholder=""
                rows="4"
                max-rows="6"
                name="excerpt"
                ></b-form-textarea>
                <span class="text-danger">{{ $errors->first('excerpt') }}</span>
              </b-form-group>
              
              <b-form-group id="fieldset-content" label="Content" label-for="input-content" class="mb-0">
                <vue-editor v-model="form.content" @text-change="onEditorTextChange" @blur="onEditorBlur" />
              </b-form-group>
              
              <b-form-group class="mt-0">
                <input name="content" type="hidden" :value="form.content" id="form-content">
              </b-form-group> 
              
              <b-form-group label="Banner Image" label-for="file-banner">
                {{-- <div class="custom-file">
                  {{ Form::file('fileBanner', ['class' => 'custom-file-input', 'id' => 'fileBanner', 'accept' => 'image/jpeg, image/png']) }}
                  <label class="custom-file-label" for="fileBanner">Choose file</label>
                </div> --}}
                <b-form-file
                v-model="form.fileBanner"
                label="Banner Image"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                name="fileBanner"
                accept="image/jpeg, image/png"
                ></b-form-file>
              </b-form-group>
              
              <b-form-group label="Mobile Banner Image" label-for="file-banner">
                {{-- <div class="custom-file">
                  {{ Form::file('fileBannerMobile', ['class' => 'custom-file-input', 'id' => 'fileBannerMobile', 'accept' => 'image/jpeg, image/png']) }}
                  <label class="custom-file-label" for="fileBannerMobile">Choose file</label>
                </div> --}}
                <b-form-file
                v-model="form.fileBannerMobile"
                label="Mobile Banner Image"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                name="fileBannerMobile"
                accept="image/jpeg, image/png"
                ></b-form-file>
              </b-form-group>
              
              <b-form-group>
                <b-button type="submit" id="btn-submit" variant="primary">Submit</b-button>
              </b-form-group>
              
            </div>
          </div>
        </div>
      </div>
      
      {{ Form::close() }}
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  @endsection
  
  @section('scripts')
  <script>
    const vue = new Vue({
      el: '#app',
      data: {
        form: {
          title: '{!! isset($article) ? $article->title : '' !!}',
          slug: '{!! isset($article) ? $article->slug : '' !!}',
          categories: [],
          excerpt: '{!! isset($article) ? $article->excerpt : '' !!}',
          content: '{!! isset($article) ? $article->content : '' !!}',
          fileBanner: null,
          fileBannerMobile: null,
        },
        api_token: '{{ Auth::user()->api_token }}',
        selected: [],
        options: {!! json_encode($checkbox_categories,TRUE) !!},
        url: '{{ url('/') }}',
        blank: '',
      },
      methods: {
        updateSlug: function(val) {
          this.form.slug = val;
          $('#form-slug').valid();
        },
        onEditorBlur: function(quill) {
          $('#form-content').valid();
        },
        onEditorTextChange: function(quill) {
          // $('#form-content').valid();
        }
      },
    });
    
    $('.custom-file-input').on('change',function(){
      //get the file name
      var fileName = $(this).target.files[0].name;
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    });
    
    // FORM VALIDATION
    if ($("#article-form").length > 0) {
      var validator = $("#article-form").validate({
        ignore: ".ignore",
        rules: {
          title: {
            required: true
          },
          slug: {
            required: true
          },
          'categories[]': {
            required: true
          },   
          excerpt: {
            required: true
          },   
          content: {
            required: true
          },   
          fileBanner: {
            required: true,
            accept: "image/jpeg, image/png"
          },   
          fileBannerMobile: {
            required: true,
            accept: "image/jpeg, image/png"
          },    
        },
        messages: {
          title: {
            required: "Please enter title"
          },
          slug: {
            required: "Please enter slug"
          },
          'categories[]': {
            required: "Please select at least 1 category"
          },
          excerpt: {
            required: "Please enter excerpt"
          },
          content: {
            required: "Please enter content"
          },
          fileBanner: {
            required: "Please upload banner image",
            accept: "Only jpg / png images are accepted"
          },
          fileBannerMobile: {
            required: "Please upload mobile banner image",
            accept: "Only jpg / png images are accepted"
          },
        },
        errorElement : 'small',
        // ignore: ':hidden:not(:checkbox)',
        errorPlacement: function (error, element) {
          if (element.is(":checkbox")) {
            $('#categories-error').append(error);
          } else {
            error.insertAfter(element);
          }
        },
        submitHandler: function(form) {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $('#btn-submit').html('Sending..');
          $('#btn-submit').attr("disabled", true);
          var formData = new FormData(form);
          $.ajax({
            url: "{{ route('admin.article.store') }}" ,
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
              
              vue.$refs.slug._data.slug = '';
              vue.form.content = null;
              vue.form.fileBanner = null;
              vue.form.fileBannerMobile = null;
              $('html, body').animate({ scrollTop: 0 }, 0);
              
              document.getElementById("article-form").reset();
              setTimeout(function(){
                $('#res_message').hide();
                $('#msg_div').hide();
              },10000);
            }
          });
        }
      })
    }
  </script>
  @endsection