@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'agenda',
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
            <div class="col-12 mt-2 container-agenda-alert">
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
				<div class="col-md-6">
					<label class="label" for="category">Category</label>
					<select class="form-control" name="category" id="category" data-value="{{ (isset($data))? $data->category_agenda_id :-1 }}" required>
					</select>
				</div>
				<div class="col-md-6">
					<label class="label" for="province">Province</label>
					<select class="form-control" name="province" id="province" data-value="{{ (isset($data))? $data->ID_t_md_province :-1 }}" required>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<label class="label" for="title">Title</label>
					<input type="text" class="form-control" name="title" id="title" value="{{ (isset($data))? $data->agenda_title :'' }}" required maxlength="?" />
				</div>
				<div class="col-md-6">
					<label class="label" for="city">City</label>
					<select class="form-control" name="city" id="city" data-value="{{ (isset($data))? $data->ID_t_md_city :-1 }}" required>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<label class="label" for="description">Description</label>
					<textarea class="form-control" name="description" id="description">{{ (isset($data))? $data->agenda_desc :'' }}</textarea>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<div class="container-agenda-day-error"></div>
					<button type="button" class="btn btn-sm btn-info" onclick="adds('dt1')">
						<span class="fas fa-plus"></span>
						Add
					</button>
					<table id="dt1" class="table table-bordered text-center">
						<thead>
							<tr>
								<th width="15%">Date</th>
								<th>Address</th>
								<th>Starting at</th>
								<th>Finished at</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($data))
							@foreach($data->detail_agenda as $d)
							<tr>
								<td>
									<input type="date" class="form-control" name="date[]" value="{{ $d->agenda_detail_date }}" required />
									<input type="hidden" class="form-control" name="agenda_detail_id[]" value="{{ $d->agenda_detail_id }}" required />
								</td>
								<td>
									<textarea class="form-control" name="address[]" required>{{ $d->agenda_detail_address }}</textarea>
								</td>
								<td>
									<input type="time" class="form-control" name="start[]" value="{{ $d->agenda_detail_time_start }}" required />
								</td>
								<td>
									<input type="time" class="form-control" name="end[]" value="{{ $d->agenda_detail_time_end }}" required />
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" onclick="deletes('dt1','day',this)">
										<span class="fas fa-trash"></span>
									</button>
								</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td>
									<input type="date" class="form-control" name="date[]" required />
								</td>
								<td>
									<textarea class="form-control" name="address[]" required></textarea>
								</td>
								<td>
									<input type="time" class="form-control" name="start[]" required />
								</td>
								<td>
									<input type="time" class="form-control" name="end[]" required />
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" onclick="deletes('dt1','day',this)">
										<span class="fas fa-trash"></span>
									</button>
								</td>
							</tr>
						@endif
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="container-agenda-employee-error"></div>
					<button type="button" class="btn btn-sm btn-info" id="adddt2" onclick="adds('dt2')">
						<span class="fas fa-plus"></span>
						Add
					</button>
					<table id="dt2" class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Employee</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($data))
							@foreach($data->anggota_dewan as $d)
							<tr>
								<td>
									<select class="form-control employee" name="employee[]" id="employee" data-value="{{ $d->pegawai_id }}" required>
									</select>
									<input type="hidden" name="id_attendance[]" value="{{ $d->id_attendance }}" required />
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" onclick="deletes('dt2','employee',this)">
										<span class="fas fa-trash"></span>
									</button>
								</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td>
									<select class="form-control employee" name="employee[]" id="employee" data-value="-1" required>
									</select>
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" onclick="deletes('dt2','employee',this)">
										<span class="fas fa-trash"></span>
									</button>
								</td>
							</tr>
						@endif
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
					<a href="{{ route('admin.agenda.index') }}" class="btn btn-link btn-sm">
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
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<style>
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/agenda/form.js') }}"></script>
@endpush