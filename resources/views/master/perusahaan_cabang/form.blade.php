@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'perusahaan_cabang',
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
				<div class="col-2">
					<label class="label" for="pc_address">Alamat Perusahaan Cabang</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pc_address" id="pc_address" value="{{ (isset($data))?$data->pc_address:'' }}" required />
				</div>
			</div>
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
			<hr>
			<br/>
			<div class="row">
				<div class="col-2">
					<label class="label" for="pc_lat">Latitude</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pc_lat" id="pc_lat" value="{{ (isset($data))?$data->pc_lat:'' }}" required />
				</div>
				<div class="col-2">
					<label class="label" for="pc_long">Longitude</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="pc_long" id="pc_long" value="{{ (isset($data))?$data->pc_long:'' }}" required />
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-2">
					<label class="label" for="radius">Radius</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" name="radius" id="radius" value="{{ (isset($data))?$data->radius:'' }}" required />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm">
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
@endpush