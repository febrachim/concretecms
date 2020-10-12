@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
@stop

@section('jsfile')
<!-- Scripts -->
@stop

@section('content')
{{-- Flash Messages --}}
<div class="flash-message container-fluid"></div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel ">
          <i class="fas fa-exclamation-triangle text-warning"></i> Delete Confirmation
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Are you sure want delete this category?</h5>
        <span class="text-danger">
          <small>
            Warning: This action cannot be undone
          </small>
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

@if (Session::has('success'))
<div class="container-fluid">
  <div>
    <b-alert
      fade
      :show="dismissSecs"
      dismissible
      variant="success"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      {{ Session::get('success') }}
    </b-alert>
  </div>
</div>
@endif
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{!! config('category.name.index') !!}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">{!! config('category.name.index') !!}</li>
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
        {{ Form::open([
          'route' => 'admin.category.store',
          'method' => 'POST'
          ]) }}
          
          {!! csrf_field() !!}
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">New Category</h3>
              
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body pt-2 pb-0">
              <b-form-group id="fieldset-name" label-class="font-weight-normal" label="Name" label-for="input-name">
                <b-form-input type="text" size="sm" name="name" id="input-name" placeholder="" v-model="form.name" ref="name" autocomplete="off"></b-form-input>
                <span class="text-danger">{{ $errors->first('name') }}</span>
              </b-form-group>
              
              <b-form-group id="fieldset-slug" label-class="font-weight-normal" label="Slug" label-for="input-slug">
                <b-form-input type="text" size="sm" name="slug" id="input-slug" placeholder="" v-model="form.slug" ref="slug" autocomplete="off"></b-form-input>
                <span class="text-danger">{{ $errors->first('slug') }}</span>
              </b-form-group>
              
              <b-form-group>
                <b-button block type="submit" id="btn-submit" variant="primary">Create</b-button>
              </b-form-group>
            </div>
            <!-- /.card-body -->
          </div>
        {{ Form::close() }}
        <!-- /.card -->
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-body">
            <table id="categoryTable" class="table table-bordered table table-hover dataTable dtr-inline">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Count</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th colspan="8">
                    <h3 align="center">
                      Please wait...
                    </h3>
                  </th>
                </tr>
              </tbody>
            </table>
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
<script type="application/javascript">
  const vue = new Vue({
    el: '#app',
    data: {
        form: {
            name: '',
            slug: '',
        },
        api_token: '{{ Auth::user()->api_token }}',
        dismissSecs: 2,
        dismissCountDown: 0
    },
    methods: {
        countDownChanged(dismissCountDown) {
          this.dismissCountDown = dismissCountDown
        }
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

  jQuery(document).ready(function($){
    $.noConflict();
    
    var table = $('#categoryTable').DataTable({
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax:{
        url: "{{ route('admin.category.index') }}"
      },
      columns: [
      {
        data: 'name',
        name: 'name'
      },
      {
        data: 'slug',
        name: 'slug',
      },
      {
        data: 'count',
        name: 'count',
        orderable: false
      },
      {
        data: 'action',
        name: 'action',
        orderable: false
      },
      ]
    });
    
    var category_id;
    
    $(document).on('click', '.deleteCategory ', function() {
      category_id = $(this).attr('id');
      $('#confirmModal').modal('show');
    });
    
    $('#ok_button').click(function() {
      
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        url: '/backoffice/category/delete/'+category_id,
        data:{
          'category_id': category_id,
          '_token': '{{ csrf_token() }}',
        },
        beforeSend: function() {
          $('#ok_button').text('Deleting...');
          $('#ok_button').addClass('disabled');
          $('#ok_button').attr("disabled", true);
        },
        success: function(data) {
          $('div.flash-message').html(data);
          setTimeout(function(){
            $('#confirmModal').modal('hide');
            $('#ok_button').removeClass('disabled');
            $('#ok_button').attr("disabled", false);
            $('#ok_button').text('Delete');
            table.ajax.reload();
          }, 300);
          setTimeout(function(){
            $(".alert").fadeTo(1500, 0).slideUp(500, function() {
              $(this).remove();
            });
          }, 2000);
        }
      })
    });
  });
</script>
@stop
