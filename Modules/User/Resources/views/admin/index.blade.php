@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
@stop

@section('jsfile')
<!-- Scripts -->
@stop

@section('content')
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
          <h5>Are you sure want delete this user?</h5>
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

	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{!! config('user.name.index') !!}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">{!! config('user.name.index') !!}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="userTable" class="table table-bordered table table-hover dataTable dtr-inline">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Actions</th>
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
    <script>
      jQuery(document).ready(function($){
        $.noConflict();

        var table = $('#userTable').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax:{
            url: "{{ route('admin.user.index') }}"
          },
          columns: [
            {
              data: 'name',
              name: 'name'
            },
            {
              data: 'email',
              name: 'email',
            },
            {
              data: function (row) {
                       let roleNames= [];
                         $(row.roles).each(function (i, e) {
                           roleNames.push(e.name);
                           });
                         return roleNames.join(", ")
                       },
              name: 'roles',
              orderable: false
            },
            {
              data: 'created_at',
              name: 'created_at'
            },
            {
              data: 'action',
              name: 'action',
              orderable: false
            },
          ]
        });

        var user_id;
        var current_user_id = {{ $current_user_id }};

        $(document).on('click', '.deleteUser ', function() {
          user_id = $(this).attr('id');
          $('#confirmModal').modal('show');
        })

        $('#ok_button').click(function() {

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            url: '/backoffice/user/delete/'+user_id,
            data:{
                'user_id': user_id,
                'current_user_id': current_user_id,
                '_token': '{{ csrf_token() }}',
            },
            beforeSend: function() {
              if(user_id == current_user_id) {
                alert('cannot delete your own account!');
                return false;
              }
              $('#ok_button').text('Deleting...');
              $('#ok_button').addClass('disabled');
            },
            success: function(data) {
              setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#ok_button').removeClass('disabled');
                $('#ok_button').text('Delete');
                table.ajax.reload();
              }, 500);
            }
          })
        })
      });

      $('div.alert').not('.alert-danger').delay(2500).fadeOut(500);
    </script>
@stop
