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
					<label class="label" for="type">Presensi Type</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $types->presensi_type_name }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startDay">Start Day</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $days[$data->start_day] }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endDay">End Day</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $days[$data->end_day] }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startWork">Start Work</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->start_work }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endWork">End Work</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->end_work }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startBreak">Start Break</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->start_break }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endBreak">End Break</label>
				</div>
				<div class="col-md-3">
					: <p class="indent-10">{{ $data->end_break }}</p>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
					<a href="{{ route('admin.presence.variant.index') }}" class="btn btn-link btn-sm">
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