@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'jabatans',
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
					<label class="label" for="name_city">City Name</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" name="name_city" id="name_city" value="{{ (isset($data))?$data->name_city:'' }}" required />
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
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.province.index') }}" class="btn btn-link btn-sm">
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