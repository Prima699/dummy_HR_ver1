@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'presenceType',
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
					<label class="label" for="name">Name</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" name="name" id="name" value="{{ (isset($data))?$data->presensi_type_name:'' }}" required maxlength="50" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="work">Work Day</label>
				</div>
				<div class="col-md-3">
					<input type="number" class="form-control" name="work" id="work" value="{{ (isset($data))?$data->work_day:'' }}" required max="99" min="0" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="off">Off Day</label>
				</div>
				<div class="col-md-3">
					<input type="number" class="form-control" name="off" id="off" value="{{ (isset($data))?$data->off_day:'' }}" required max="99" min="0" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="day">Work Hour Day</label>
				</div>
				<div class="col-md-3">
					<input type="number" class="form-control" name="day" id="day" value="{{ (isset($data))?$data->work_hour_day:'' }}" required max="999" min="0" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="week">Work Hour Week</label>
				</div>
				<div class="col-md-3">
					<input type="number" class="form-control" name="week" id="week" value="{{ (isset($data))?$data->work_hour_week:'' }}" required max="999" min="0" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="type">Type</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="type" id="type" required>
						<?php
							$f0 = "";
							$f1 = "";
							if(isset($data) && $data->type==0){$f0 = "selected";}
							else if(isset($data) && $data->type==1){$f1 = "selected";}
						?>
						<option value="0" {{$f0}}>Flexible</option>
						<option value="1" {{$f1}}>Fixed</option>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="location">Presence Location</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="location" id="location" required>
						<?php
							$f0 = "";
							$f1 = "";
							if(isset($data) && $data->locaType==0){$f0 = "selected";}
							else if(isset($data) && $data->locaType==1){$f1 = "selected";}
						?>
						<option value="0" {{$f0}}>Flexible</option>
						<option value="1" {{$f1}}>Fixed</option>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.presence.type.index') }}" class="btn btn-link btn-sm">
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