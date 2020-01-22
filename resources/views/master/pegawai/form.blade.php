@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'pegawai',
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
            <div class="col-12 mt-2 container-employee-alert">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
			<form method="post" action="{{ $master->action }}" enctype="multipart/form-data">
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_nik">ID</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_nik" id="pegawai_nik" value="{{ (isset($data))?$data->pegawai_NIK:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_name">Full Name</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_name" id="pegawai_name" value="{{ (isset($data))?$data->pegawai_name:'' }}" required />
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_email">Email</label>
				</div>
				<div class="col-3">
					<input type="email" class="form-control" name="pegawai_email" id="pegawai_email" value="{{ (isset($data))?$data->pegawai_email:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_telp">Phone</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_telp" id="pegawai_telp" value="{{ (isset($data))?$data->pegawai_telp:'' }}" required />
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="gender">Gender</label>
				</div>
				<div class="col-3">
					<label><input type="radio" class="form-control" name="gender" checked>Men</label>
					&nbsp;&nbsp;
					<label><input type="radio" class="form-control" name="gender">Woman</label>
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_address">Address</label>
				</div>
				<div class="col-3">
					<textarea class="form-control" name="pegawai_address" id="pegawai_address" required>{{ (isset($data))?$data->pegawai_address:'' }}</textarea>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="country">Country</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="country" id="country" data-value="{{ (isset($data))?$data->ID_t_md_country:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="city">City</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="city" id="city" data-value="{{ (isset($data))?$data->ID_t_md_city:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="province">Province</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="province" id="province" data-value="{{ (isset($data))?$data->ID_t_md_province:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="departement">Departement</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="departement" id="departement" data-value="{{ (isset($data))?$data->departemen_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="jabatan">Jabatan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="jabatan" id="jabatan" data-value="{{ (isset($data))?$data->jabatan_id:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="golongan">Golongan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="golongan" id="golongan" data-value="{{ (isset($data))?$data->golongan_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="presence">Presence</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="presence" id="presence" data-value="{{ (isset($data))?$data->presensi_type_id:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="office">Office</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="office" id="office" data-value="{{ (isset($data))?$data->perusahaan_cabang_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="type">Contract</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="type" id="type" data-value="{{ (isset($data))?$data->pegawai_type:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-2">
					<label class="label" for="image">Upload foto</label>
				</div>
				<div class="col-3">
					<button type="button" class="btn btn-sm btn-info" title="Add more photo" onclick="addPhoto()" style="margin-top:5px;">
						<span class="fas fa-plus"></span>
						<span>Add more photo</span>
					</button>
				</div>
			</div>
			<div class="div-photo-container">
			<div class="row" hidden>
				<div class="col-3 offset-2">
					<input type="file" class="form-control" name="image[]" id="image" disabled />
				</div>
				<div class="col-1">
					<button type="button" class="btn btn-sm btn-danger" title="delete" onclick="deletePhoto(this)" style="margin-top:5px;">
						<span class="fas fa-minus"></span>
					</button>
				</div>
				<br/>
			</div>
			<div class="row">
				<div class="col-3 offset-2">
					<input type="file" class="form-control" name="image[]" id="image" />
				</div>
				<div class="col-1">
					<button type="button" class="btn btn-sm btn-danger" title="delete" onclick="deletePhoto(this)" style="margin-top:5px;">
						<span class="fas fa-minus"></span>
					</button>
				</div>
				<br/>
			</div>
			</div>
			<br/>
			<br/>

			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm" id="btn-submit" disabled>
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.employee.index') }}" class="btn btn-link btn-sm">
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
	<script src="{{ asset('public/js/pegawai/form.js') }}"></script>
@endpush