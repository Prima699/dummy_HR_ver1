@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'category',
    'activeNav' => '',
])
 
@section('content')
<div class="panel-header">
  </div>
  <div class="content"> 
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $master->title }}</h4>
            <div class="col-12 mt-2">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
			<form method="post" action="{{ $master->action }}" id="form-save" enctype="multipart/form-data">
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="name">Name</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" name="name" id="name" value="{{ (isset($data))?$data->name:'' }}" required maxlength="45" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="email">Email</label>
				</div>
				<div class="col-md-5">
					<input type="email" class="form-control" name="email" id="email" value="{{ (isset($data))?$data->email:'' }}" required maxlength="45" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="role">Role</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" name="role" id="role" value="{{ (isset($data))?$data->role:'' }}" required maxlength="45" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="msisdn">MSISDN</label>
				</div>
				<div class="col-md-5">
					<input type="number" class="form-control" name="msisdn" id="msisdn" value="{{ (isset($data))?$data->msisdn:'' }}" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="password">Password</label>
				</div>
				<div class="col-md-5">
					<input type="password" class="form-control" name="password" id="password" value="{{ (isset($data))?$data->password:'' }}" required />
				</div>
				<div class="col-md text-danger" id="password-result"></div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="repassword">Retype Password</label>
				</div>
				<div class="col-md-5">
					<input type="password" class="form-control" name="repassword" id="repassword" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="image">Image</label>
				</div>
				<div class="col-md-5">
					<input type="file" class="form-control" name="image" id="image" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm" id="button-save">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.category.index') }}" class="btn btn-link btn-sm">
						<span class="fa fa-arrow-left"></span>
						Back
					</a>
				</div>
			</div>
			</form>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
@endsection

@push('css')
	<style>
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/js/user/form.js') }}"></script>
@endpush