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
            <div class="col-12 mt-2">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
			<form method="post" action="{{ $master->action }}">
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_name">Nama Pegawai</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_name" id="pegawai_name" value="{{ (isset($data))?$data->pegawai_name:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_address">Alamat Pegawai</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_address" id="pegawai_address" value="{{ (isset($data))?$data->pegawai_address:'' }}" required />
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_nik">NIK</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_nik" id="pegawai_nik" value="{{ (isset($data))?$data->pegawai_nik:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="pegawai_telp">Contact</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_telp" id="pegawai_telp" value="{{ (isset($data))?$data->pegawai_telp:'' }}" required />
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-2">
					<label class="label" for="pegawai_email">Email</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pegawai_email" id="pegawai_email" value="{{ (isset($data))?$data->pegawai_email:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="kelamin">Jenis Kelamin</label>
				</div>
				<div class="col-3">
					<label><input type="radio" class="form-control" name="kelamin">Laki-Laki</label>
					&nbsp;&nbsp;
					<label><input type="radio" class="form-control" name="kelamin">Perempuan</label>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="country">Negara</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="country" id="country">
						@foreach ($negara as $negaras)
							<option value="{{ $negaras->ID_t_md_country }}">{{ $negaras->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="province">Provinsi</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="propinsi" id="propinsi">
						@foreach ($propinsi as $propinsis)
							<option value="{{ $propinsis->ID_t_md_province }}">{{ $propinsis->name_province }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="city">Kota</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="city" id="city">
						@foreach ($kota as $kotas)
							<option value="{{ $kotas->ID_t_md_city }}" >{{ $kotas->name_city }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<hr>

			<div class="row">
				<div class="col-md-2">
					<label class="label" for="departemen">Departemen</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="departemen" id="departemen">
						@foreach ($departemen as $departemens)
							<option value="{{ $departemens->departemen_id }}">{{ $departemens->departemen_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="jabatan">Jabatan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="jabatan" id="jabatan">
						@foreach ($jabatan_ as $jabatan_s)
							<option value="{{ $jabatan_s->jabatan_id }}">{{ $jabatan_s->jabatan_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="golongan">Golongan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="golongan" id="golongan">
						@foreach ($golongan_ as $golongan_s)
							<option value="{{ $golongan_s->golongan_id }}">{{ $golongan_s->golongan_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-2">
					<label class="label" for="presensi">Persensi</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="presensi" id="presensi">
						@foreach ($presensi_ as $presensi_s)
							<option value="{{ $presensi_s->presensi_type_id }}" >{{ $presensi_s->presensi_type_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="perusahaan">Perusahaan</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="perusahaan" id="perusahaan">
						@foreach ($perusahaan_ as $perusahaan_s)
							<option value="{{ $perusahaan_s->perusahaan_id }}">{{ $perusahaan_s->perusahaan_name }}</option>
						@endforeach
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
					<input type="file" class="form-control" name="image" id="image" required />
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.pegawai.index') }}" class="btn btn-link btn-sm">
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