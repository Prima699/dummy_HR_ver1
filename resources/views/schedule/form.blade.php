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
			@if($master->method=="PUT")
				@method('PUT')
			@endif
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
					<input type="hidden" name="employee" value="{{ ($employee!=NULL)? $employee->pegawai_id : '' }}" />
				</div>
				<div class="col-md-6">
					<label class="label" for="type">Presence Type</label>
					<select class="form-control" disabled>
						<option>{{ ($employee!=NULL)? $employee->presensi_type_name : '' }}</option>
					</select>
					<input type="hidden" name="presence" value="{{ ($employee!=NULL)? $employee->presensi_type_id : '' }}" />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<caption>
						<button type="button" class="btn btn-primary btn-round btn-sm text-white pull-left btn-adds" onclick="adds()">
							<span class="fa fa-plus"></span>
							Add
						</button>
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
						<tbody hidden>
							<tr id="copy" hidden>
								<td>
									<select class="form-control" name="variant[]" required disabled>
									</select>
									<input type="hidden" class="form-control variant" name="variant[]" required disabled />
								</td>
								<td>
									<input type="text" class="form-control dp startDate" />
								</td>
								<td class="endDate fxd"></td>
								<td class="workDay fxd"></td>
								<td class="offDay fxd"></td>
								<td>
									<input type="hidden" name="workStart[]" disabled required />
									<input type="hidden" name="workEnd[]" disabled required />
									<input type="hidden" name="offStart[]" disabled required />
									<input type="hidden" name="offEnd[]" disabled required />
									<button type="button" class="btn btn-sm btn-danger" onclick="deletes(this)">
										<span class="fas fa-trash"></span>
									</button>
								</td>
							</tr>
						</tbody>
						<tbody id="paste">
						@foreach()
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<br/>
			<div class="row">
				<div class="col-md-3">
					<button type="submit" class="btn btn-info btn-sm" id="btn-submit" disabled>
						<span class="fa fa-save"></span>
						Save
					</button>
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