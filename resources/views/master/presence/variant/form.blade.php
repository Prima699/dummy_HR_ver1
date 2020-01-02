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
					<select class="form-control" name="type" id="type" required>
						@foreach($types as $k => $v)
							@if((isset($data) && $data->presensi_type_id==$v->presensi_type_id))
								<option value="{{$v->presensi_type_id}}" selected>{{$v->presensi_type_name}}</option>
							@else
								<option value="{{$v->presensi_type_id}}">{{$v->presensi_type_name}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startDay">Start Day</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="startDay" id="startDay" required>
						@foreach($days as $k => $v)
							@if((isset($data) && $data->start_day==$k))
								<option value="{{$k}}" selected>{{$v}}</option>
							@else
								<option value="{{$k}}">{{$v}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endDay">End Day</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="endDay" id="endDay" required>
						@foreach($days as $k => $v)
							@if((isset($data) && $data->end_day==$k))
								<option value="{{$k}}" selected>{{$v}}</option>
							@else
								<option value="{{$k}}">{{$v}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startWork">Start Work</label>
				</div>
				<div class="col-md-3">
					<input type="time" name="startWork" id="startWork" class="form-control" value="{{ (isset($data))? $data->start_work :'' }}" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endWork">End Work</label>
				</div>
				<div class="col-md-3">
					<input type="time" name="endWork" id="endWork" class="form-control" value="{{ (isset($data))? $data->end_work :'' }}" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="startBreak">Start Break</label>
				</div>
				<div class="col-md-3">
					<input type="time" name="startBreak" id="startBreak" class="form-control" value="{{ (isset($data))? $data->start_break :'' }}" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="endBreak">End Break</label>
				</div>
				<div class="col-md-3">
					<input type="time" name="endBreak" id="endBreak" class="form-control" value="{{ (isset($data))? $data->end_break :'' }}" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="fa fa-save"></span>
						Save
					</button>
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
	</style>
@endpush 

@push('js')
@endpush