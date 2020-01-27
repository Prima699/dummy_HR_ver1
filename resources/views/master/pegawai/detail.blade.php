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
					<p>: {{ (isset($data))?$data->pegawai_NIK:'' }}</p>
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_name">Full Name</label>
				</div>
				<div class="col-3">
					<p>: {{ (isset($data))?$data->pegawai_name:'' }}</p>
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_email">Email</label>
				</div>
				<div class="col-3">
					<p>: {{ (isset($data))?$data->pegawai_email:'' }}</p>
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_telp">Phone</label>
				</div>
				<div class="col-3">
					<p>: {{ (isset($data))?$data->pegawai_telp:'' }}</p>
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_address">Address</label>
				</div>
				<div class="col-8">
					<p>: {!! (isset($data))?$data->pegawai_address:'' !!}</p>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="country">Country</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->nama_country:'-1' }}</p>
				</div>
				<div class="col-md-2">
					<label class="label" for="city">City</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->nama_city:'-1' }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="province">Province</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->nama_province:'-1' }}</p>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="departement">Departement</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->departemen_name:'-1' }}</p>
				</div>
				<div class="col-md-2">
					<label class="label" for="jabatan">Jabatan</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->jabatan_name:'-1' }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="golongan">Golongan</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->golongan_name:'-1' }}</p>
				</div>
				<div class="col-md-2">
					<label class="label" for="presence">Presence</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->presensi_type_name:'-1' }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="office">Office</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->perusahaan_cabang_id:'-1' }}</p>
				</div>
				<div class="col-md-2">
					<label class="label" for="type">Contract</label>
				</div>
				<div class="col-md-3">
					<p>: {{ (isset($data))?$data->pegawai_type:'-1' }}</p>
				</div>
			</div>
			<br/>
			<hr>
			
			<div class="row">
				<div class="col-12">
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Photo</th>
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
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<br/>

			<div class="row">
				<div class="col-md-3 offset-md-1">
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
@endpush