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
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div id="data" data-fcm-route="{{ route('admin.agenda.fcm') }}"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
							<label class="label" for="category">Category</label>
						</div>
						<div class="col-md-10">
							<p>: <span id="category">{{ $data->category_agenda_name }}</span></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="label" for="title">Title</label>
						</div>
						<div class="col-md-10">
							<p>: <span id="title">{{ $data->agenda_title }}</span></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="label" for="province">Province</label>
						</div>
						<div class="col-md-10">
							<p>: <span id="province">{{ $data->nama_province }}</span></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="label" for="city">City</label>
						</div>
						<div class="col-md-10">
							<p>: <span id="city">{{ $data->nama_city }}</span></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="label" for="description">Description</label>
						</div>
						<div class="col-md-10">
							<p>: <span id="description">{{ $data->agenda_desc }}</span></p>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<table id="dt1" class="table table-bordered text-center">
						<thead>
							<tr>
								<th width="15%">Date</th>
								<th>Address</th>
								<th width="10%">Start</th>
								<th width="10%">Finish</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
						@foreach($data->detail_agenda as $d)
							<tr>
								<td>{{ DateTimes::jfy($d->agenda_detail_date) }}</td>
								<td>{{ $d->agenda_detail_address }}</td>
								<td>{{ $d->agenda_detail_time_start }}</td>
								<td>{{ $d->agenda_detail_time_end }}</td>
								<td>
									<button class="btn btn-sm btn-success" type="button" title="Face Recognition" onclick="fcManualModal(this)" data-date="{{ DateTimes::jfy($d->agenda_detail_date) }}" data-employee="{{ json_encode($data->anggota_dewan) }}" data-detail="{{ json_encode($d) }}">
										<span class="fas fa-user-tie"></span>
									</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<br/>			
			<div class="row">
				<div class="col-md-12">
					<table id="dt2" class="table table-bordered text-center">
						<thead>
							<tr>
								<th width="10%">No</th>
								<th>Name</th>
								<th>Phone Number</th>
								<th>Email</th>
							</tr>
						</thead>
						<tbody>
						<?php $i = 1; ?>
						@foreach($data->anggota_dewan as $d)
							<tr>
								<td>{{ $i++ }}</td>
								<td>
									<a href="{{ route('admin.employee.detail',$d->pegawai_id) }}" title="Open Detail {{$d->pegawai_name}}" target="_blank">
										{{ $d->pegawai_name }}
									</a>
								</td>
								<td>{{ $d->pegawai_telp }}</td>
								<td>{{ $d->pegawai_email }}</td>
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
					<form action="{{ $master->action }}" method="post">
					@csrf
					@method('PUT')
					@if(
						$data->agenda_status==1
						AND $data->agenda_date_end > date("Y-m-d")
						AND date("Y-m-d") >= $data->agenda_date
					)
						<button type="submit" class="btn btn-primary btn-sm">
							<span class="fa fa-save"></span>
							Done
						</button>
					@endif
					<a href="{{ $back }}" class="btn btn-link btn-sm">
						<span class="fa fa-arrow-left"></span>
						Back
					</a>
					</form>
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
  
<div class="modal" id="fcManualModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Manual Face Recognition</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-agenda-fcm-alert"></div>
				<label id="fcm-date"></label>
				<br/>
				<label id="fcm-address"></label>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th>NIK</th>
							<th>Name</th>
							<th width="20%">Check In</th>
						</tr>
					</thead>
					<tbody id="fcm-employee">
						<tr id="copy" style="display:none;">
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="button" class="btn btn-sm btn-primary fcm-check" style="display:none;">
									<span class="fas fa-sign-in-alt"></span>
									Check In
								</button>
								<button type="button" class="btn btn-sm btn-danger fcm-check" style="display:none;">
									<span class="fas fa-sign-out-alt"></span>
									Check Out
								</button>
								<button type="button" class="btn btn-sm btn-success" style="display:none;">
									<span class="fas fa-check"></span>
									Done
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@push('css')
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<style>
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/agenda/detail.js') }}"></script>
@endpush