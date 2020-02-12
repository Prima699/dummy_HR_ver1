@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'schedule',
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
            <div class="col-12 mt-2 container-schedule-alert">
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
			@method('PUT')
			<input type="hidden" id="dependencies"
				data-variant="{{ ($employee!=NULL)? json_encode($employee->variant) :'' }}"
				data-type="{{ ($employee!=NULL)? json_encode($employee->prestype) :'' }}"
			/>
			<div class="row">
				<div class="col-md-6">
					<label class="label" for="employee">Employee</label>
					<select class="form-control" disabled>
						<option>{{ ($employee!=NULL)? $employee->pegawai_name : '' }}</option>
					</select>
				</div>
				<div class="col-md-6">
					<label class="label" for="type">Presence Type</label>
					<select class="form-control" disabled>
						<option>{{ ($employee!=NULL)? $employee->presensi_type_name : '' }}</option>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<caption>
						@if($employee->prestype->type!=1)
							<button type="button" class="btn btn-primary btn-round btn-sm text-white pull-left btn-adds" onclick="create()">
								<span class="fa fa-plus"></span>
								Add
							</button>
						@else
							<a href="{{ route('admin.schedule.storeFixed') }}?q=fixed&i={{ ($employee!=NULL)? $employee->variant[0]->presensi_type_shift_id : '-1' }}&e={{ ($employee!=NULL)? $employee->pegawai_id : '-1' }}" class="btn btn-primary btn-round btn-sm text-white pull-left btn-adds">
								<span class="fa fa-plus"></span>
								Add
							</a>
						@endif
					</caption>
					<table id="dt1" class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Shift</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Work Day</th>
								<th>Off Day</th>
								<th width="5%">Action</th>
							</tr>
						</thead>
						<tbody id="paste">
						@if($data!=NULL)
						@foreach($data as $d)
							<tr>
								<td>
									@foreach($employee->variant as $v)
										@if($d->presensi_type_shift_id==$v->presensi_type_shift_id)
											{{ $v->shift_name }}
											@php break; @endphp
										@endif
									@endforeach
								</td>
								<td>{{ DateTimes::dmy($d->work_day_start, "Fixed") }}</td>
								<td>{{ DateTimes::dmy($d->off_day_end, "Fixed") }}</td>
								<td>
									{{ DateTimes::dmy($d->work_day_start, "Fixed") }}
									<br/>-<br/>
									{{ DateTimes::dmy($d->work_day_end, "Fixed") }}
								</td>
								<td>
									{{ DateTimes::dmy($d->off_day_start, "Fixed") }}
									<br/>-<br/>
									{{ DateTimes::dmy($d->off_day_end, "Fixed") }}
								</td>
								<td>
									@if($employee->prestype->type!=1)
									<form style="display:inline;">
										<button type="button" class="btn btn-sm btn-warning" onclick="edit(this)" data-d="{{ json_encode($d) }}">
											<span class="fas fa-edit"></span>
										</button>
									</form>
									@endif
								</td>
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
				<div class="col-md-3">
					<a href="{{ route('admin.schedule.index') }}" class="btn btn-link btn-sm">
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
  
<div id="modal" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form>
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label for="variant">Shift</label>
						<select class="form-control fxd" id="variant" name="variant" required>
						@foreach($employee->variant as $v)
							<option value="{{ $v->presensi_type_shift_id }}">{{ $v->shift_name }}</option>
						@endforeach
						</select>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<label for="workStart">Start Date</label>
						<input type="text" class="form-control dp" id="startDate" />
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<label for="">End Date</label>
						<p id="endDate"></p>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<label for="">Work Day</label>
						<p id="workDay"></p>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<label for="">Off Day</label>
						<p id="offDay"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">				
				<input type="hidden" class="fxd" name="presence" value="{{ ($employee!=NULL)? $employee->presensi_type_id : '' }}" />
				<input type="hidden" class="fxd" name="employee" value="{{ ($employee!=NULL)? $employee->pegawai_id : '' }}" />
				<input type="hidden" name="workStart" required />
				<input type="hidden" name="workEnd" required />
				<input type="hidden" name="offStart" required />
				<input type="hidden" name="offEnd" required />
				<button type="submit" class="btn btn-sm btn-primary" id="modalButtonSave">Save</button>
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('css')
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css"/>
	<style>
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
	<script src="{{ asset('public/js/schedule/form.js') }}"></script>
@endpush