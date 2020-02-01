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
					: <p class="indent-10">{{ $data->presensi_type_name }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="work">Work Day</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->work_day }}</p> day
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="off">Off Day</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->off_day }}</p> day
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="day">Work Hour Day</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->work_hour_day }}</p> hour per day
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="week">Work Hour Week</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->work_hour_week }}</p> hour per week
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="type">Type</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">
					@if($data->type==0) {{"Flexible"}}
					@elseif($data->type==1) {{"Fixed"}}
					@endif</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="location">Presence Location</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">
					@if($data->locaType==0) {{"Flexible"}}
					@elseif($data->locaType==1) {{"Fixed"}}
					@endif</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
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
		.indent-10 {
			text-indent : 20px;
			display : inline-block;
		}
	</style>
@endpush 

@push('js')
@endpush