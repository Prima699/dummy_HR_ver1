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
					<label class="label" for="pegawai_NIK">National Identity Number (NIN)</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_NIK" id="pegawai_NIK" value="{{ (isset($data))?$data->pegawai_NIK:'' }}" required />
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
					<label class="label" for="pegawai_photo">Photo</label>
				</div>
				<div class="col-3">
					<input type="file" class="form-control" name="pegawai_photo" id="pegawai_photo" required />
					@if( isset($data) && $data->pegawai_face!=NULL && $data->pegawai_face!="" )
						<a href="{{ $data->pegawai_face }}" target="_blank">Current Photo</a>
					@endif
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_address">Address</label>
				</div>
				<div class="col-3">
					<textarea class="form-control" name="pegawai_address" id="pegawai_address" required>{!! (isset($data))?$data->pegawai_address:'' !!}</textarea>
				</div>
			</div>
			<br/>
			<hr>
			<div class="container-employee-second-alert"></div>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="country">Country</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="ID_t_md_country" id="country" data-value="{{ (isset($data))?$data->ID_t_md_country:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="city">City</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="ID_t_md_city" id="city" data-value="{{ (isset($data))?$data->ID_t_md_city:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="province">Province</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="ID_t_md_province" id="province" data-value="{{ (isset($data))?$data->ID_t_md_province:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<hr>
			<div class="container-employee-third-alert"></div>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="departement">Departement</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="departemen_id" id="departement" data-value="{{ (isset($data))?$data->departemen_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="jabatan">Jabatan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="jabatan_id" id="jabatan" data-value="{{ (isset($data))?$data->jabatan_id:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="golongan">Golongan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="golongan_id" id="golongan" data-value="{{ (isset($data))?$data->golongan_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="presence">Presence</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="presensi_type_id" id="presence" data-value="{{ (isset($data))?$data->presensi_type_id:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="office">Office</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="perusahaan_cabang_id" id="office" data-value="{{ (isset($data))?$data->perusahaan_cabang_id:'-1' }}">
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="type">Contract</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="pegawai_type" id="type" data-value="{{ (isset($data))?$data->pegawai_type:'-1' }}">
					</select>
				</div>
			</div>
			<br/>
			<hr>
			<div class="container-employee-fourth-alert"></div>
			<div class="row">
				<div class="col-12">
					<caption>
						<button type="button" class="btn btn-sm btn-info" title="Add more photo" onclick="addPhoto()" style="margin-top:5px;">
							<span class="fas fa-plus"></span>
							<span>Add more photo</span>
						</button>
					</caption>
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Photo</th>
								<th width="5%">Action</th>
							</tr>
							<tr class="copy" hidden>
								<th></th>
								<th>
									<input type="file" class="form-control" name="image[]" disabled />
								</th>
								<th>
									<button type="button" class="btn btn-sm btn-danger" title="delete" onclick="deletePhoto(this)" style="margin-top:5px;">
										<span class="fas fa-minus"></span>
									</button>
								</th>
							</tr>
						</thead>
						<tbody class="div-photo-container text-center">
							@if(isset($data) && $data->image!=null)
							@php $i = 1; @endphp
							@foreach($data->image as $d)
							<tr>
								<th>{{ $i++ }}</th>
								<th>
									<a href="{{ Constants::assetApi() . '/' . $d->path }}" target="_blank">
										<img src="{{ Constants::assetApi() . '/' . $d->path }}" title="{{$d->image_name}}" width="200px" />
									</a>
									<input type="hidden" name="eks_image[]" value="{{ $d->image_train_id }}" />
								</th>
								<th>
									<button type="button" class="btn btn-sm btn-danger" title="delete" onclick="deletePhoto(this)" style="margin-top:5px;">
										<span class="fas fa-minus"></span>
									</button>
								</th>
							</tr>
							@endforeach
							@else
								<tr>
									<th></th>
									<th>
										<input type="file" class="form-control" name="image[]" />
									</th>
									<th>
										<button type="button" class="btn btn-sm btn-danger" title="delete" onclick="deletePhoto(this)" style="margin-top:5px;">
											<span class="fas fa-minus"></span>
										</button>
									</th>
								</tr>
							@endif
						</tbody>
					</table>
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