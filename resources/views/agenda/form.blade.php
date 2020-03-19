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
					<select class="form-control" name="category" id="category" data-value="{{ (isset($data))? $data->category_agenda_id :-1 }}" required disabled>
					</select>
				</div>
				<div class="col-md-6">
					<label class="label" for="province">Province</label>
					<select class="form-control" name="province" id="province" data-value="{{ (isset($data))? $data->ID_t_md_province :-1 }}" required disabled>
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
					<select class="form-control" name="city" id="city" data-value="{{ (isset($data))? $data->ID_t_md_city :-1 }}" required disabled>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<label class="label" for="description">Description</label>
					<textarea class="form-control" name="description" id="description" required>{{ (isset($data))? $data->agenda_desc :'' }}</textarea>
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
									<input type="text" class="form-control dp" name="date[]" value="{{ $d->agenda_detail_date }}" required />
									<input type="hidden" class="form-control" name="agenda_detail_id[]" value="{{ $d->agenda_detail_id }}" required />
								</td>
								<td>
									<input type="text" class="form-control" name="address[]" value="{{ $d->agenda_detail_address }}" required />
									<input type="hidden" name="lng[]" value="{{ $d->agenda_detail_long }}" />
									<input type="hidden" name="lat[]" value="{{ $d->agenda_detail_lat }}" />
								</td>
								<td>
									<input type="text" class="form-control tp" name="start[]" value="{{ $d->agenda_detail_time_start }}" required />
								</td>
								<td>
									<input type="text" class="form-control tp" name="end[]" value="{{ $d->agenda_detail_time_end }}" required />
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
									<input type="text" class="form-control dp" name="date[]" required />
								</td>
								<td>
									<input type="text" class="form-control" name="address[]" required />
									<input type="hidden" name="lng[]" />
									<input type="hidden" name="lat[]" />
								</td>
								<td>
									<input type="text" class="form-control tp" name="start[]" required />
								</td>
								<td>
									<input type="text" class="form-control tp" name="end[]" required />
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
									<select class="form-control employee" name="employee[]" id="employee" data-value="{{ $d->pegawai_id }}" required disabled>
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

  <!-- The Modal -->
  <div class="modal" id="gmap">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Choose location</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<div class="container-agenda-map-error"></div>
			
			<div id="gmap-data"></div>
			<input id="searchInput" class="controls form-control" type="text" placeholder="Enter a location">

			<div id="map"></div>

			<div id="resultLocation"></div>
        </div>
        
      </div>
    </div>
  </div>

@endsection

@push('css')
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css"/>
	<style>
		#map {
			height: 400px;  /* The height is 400 pixels */
			width: 100%;  /* The width is the width of the web page */
		}
		#searchInput {
			top: 10px !important;
			height: 40px;
			width: 200px;
			background-color: #fff;
			box-shadow: none;
			outline: 0 !important;
			color: #2c2c2c;
			border-radius: 0px !important;
		}
		.pac-container.pac-logo {
			z-index : 2000;
		}
		.autocomplete-gmap {
			z-index : 2000;
		}
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
	<script src="{{ asset('public/js/agenda/form.js') }}"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAmSaB0Gax6HYj_3aBLrym0ek4Rr8cX0zM&callback=initGoogleMap"></script>
@endpush