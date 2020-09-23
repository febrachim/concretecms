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
				<h1 class="m-0 text-dark">{!! config('media.name') !!}</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Media</li>
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
				<form action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data">
					@csrf

					

					<div class="form-row align-items-center">
						<div class="col-6">
							<b-form-group label="Upload New Media" label-for="upload-media" label-cols="auto" label-size="sm">
								<b-form-file
								v-model="file1"
								placeholder="Choose a file or drop it here..."
								drop-placeholder="Drop file here..."
								accept="image/jpeg, image/png"
								id="upload-media"
								size="sm"
								name="media"
								></b-form-file>
							</b-form-group>
						</div>
						<div class="col-auto">
							<b-form-group>
								<b-button type="submit" variant="primary" size="sm">Upload</b-button>
							</b-form-group>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<div class="mailbox-controls">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									All Collections
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">Article Desktop Banner</a>
									<a class="dropdown-item" href="#">Article Mobile Banner</a>
								</div>
							</div>
							<!-- /.btn-group -->

							<div class="float-right">
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" placeholder="Search Media">
									<div class="input-group-append">
										<div class="btn btn-default">
											<i class="fas fa-search"></i>
										</div>
									</div>
								</div>
							</div>
							<!-- /.float-right -->
						</div>
					</div>
					<div class="card-body">
						<div class="row text-center text-lg-left">
							@for ($i = 0; $i < 12; $i++)
							<div class="col-lg-3 col-md-4 col-6">
								<a href="#" class="d-block mb-4 h-100">
									<img class="img-fluid img-thumbnail" src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">
								</a>
							</div>
							@endfor
						</div>
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
<!-- /.Main content -->
@stop

@section('scripts')
<script>
	const app = new Vue({
		el: '#app',
		data: {
			url: '{{ url('/') }}',
			file1: null,
			file2: null,
			title: 'ssss',
			slug: '',
			api_token: '{{ Auth::user()->api_token }}',
		},
		methods: {
			updateSlug: function(val) {
			  this.slug = val;
			}
		}
	});
</script>
@stop
