@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'jabatany',
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
					<label class="label" for="name_country">Country Name</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" name="name_country" id="name_country" value="{{ (isset($data))?$data->name:'' }}" required />
				</div>
				<div class="col-md-2">
					<label class="label" for="region">Continent</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="region" id="region">
						<option value="Asia" <?= (isset($data) && strtolower($data->region)=="asia")?"selected" :""; ?>>Asia</option>
						<option value="Afrika" <?= (isset($data) && strtolower($data->region)=="afrika")?"selected" :""; ?>>Afrika</option>
						<option value="Amerika Utara" <?= (isset($data) && strtolower($data->region)=="amerika utara")?"selected" :""; ?>>Amerika Utara</option>
						<option value="Amerika Selatan" <?= (isset($data) && strtolower($data->region)=="amerika selatan")?"selected" :""; ?>>Amerika Selatan</option>
						<option value="Antartika" <?= (isset($data) && strtolower($data->region)=="antartika")?"selected" :""; ?>>Antartika</option>
						<option value="Australia" <?= (isset($data) && strtolower($data->region)=="australia")?"selected" :""; ?>>Australia</option>
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
					<a href="{{ route('admin.country.index') }}" class="btn btn-link btn-sm">
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