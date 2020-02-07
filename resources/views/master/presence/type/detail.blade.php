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
			@csrf
			@method('PUT')
			<div id="data" style="display:none;"
				data-id="{{ $data->presensi_type_id }}"
				data-create="{{ route('admin.presence.variant.store') }}?type={{ $data->presensi_type_id }}"
				data-edit="{{ route('admin.presence.variant.update',$data->presensi_type_id) }}"
			></div>
			<div class="row">
				<div class="col-md-2">
					<label class="label">Name</label>
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
				<div class="col-md-12">
					<div class="container-variant-alert"></div>
					<caption>
					@if($data->type==0)
						<a class="btn btn-primary btn-round btn-sm text-white pull-left" onclick="createVariant()">
							<span class="fa fa-plus"></span>
							Add Variant
						</a>
					@endif
					</caption>
					<table class="table table-bordered" id="datatable">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Shift</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
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
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
<div id="variant-modal" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post">
			<div class="modal-body">			
				<div class="row">
					<div class="col-md-12">
						<label class="label" for="type">Presensi Type</label>
						<select class="form-control" name="type" id="type">
							<option value="{{ $data->presensi_type_id }}" selected>{{ $data->presensi_type_name }}</option>
						</select>
						<input type="hidden" id="shiftID" name="presensi_type_shift_id" />
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<label class="label" for="name">Variant Name</label>
						<input type="text" class="form-control" name="name" id="name" required />
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-6">
						<label class="label" for="startDay">Start Day</label>
						<select class="form-control" name="startDay" id="startDay" required>
						@foreach(Constants::days3() as $k => $v)
							<option value="{{ $k }}">{{ $v }}</option>
						@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<label class="label" for="endDay">End Day</label>
						<select class="form-control" name="endDay" id="endDay" required>
						@foreach(Constants::days3() as $k => $v)
							<option value="{{ $k }}">{{ $v }}</option>
						@endforeach
						</select>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-6">
						<label class="label" for="startWork">Start Work</label>
						<input type="text" name="startWork" id="startWork" class="form-control tp" required />
					</div>
					<div class="col-md-6">
						<label class="label" for="endWork">End Work</label>
						<input type="text" name="endWork" id="endWork" class="form-control tp" required />
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-6">
						<label class="label" for="startBreak">Start Break</label>
						<input type="text" name="startBreak" id="startBreak" class="form-control tp" required />
					</div>
					<div class="col-md-6">
						<label class="label" for="endBreak">End Break</label>
						<input type="text" name="endBreak" id="endBreak" class="form-control tp" required />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('css')
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<link rel="stylesheet" href="http://t00rk.github.io/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"/>
	<style>
		.indent-10 {
			text-indent : 20px;
			display : inline-block;
		}
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="http://t00rk.github.io/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
	<script src="{{ asset('public/js/presence/type/detail.js') }}"></script>
@endpush