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
								@if($button==true) <th width="10%" class="st-not">Action</th> @endif
							</tr>
						</thead>
						<tbody>
						@foreach($data->detail_agenda as $d)
							<tr>
								<td>{{ DateTimes::jfy($d->agenda_detail_date) }}</td>
								<td>{{ $d->agenda_detail_address }}</td>
								<td>{{ $d->agenda_detail_time_start }}</td>
								<td>{{ $d->agenda_detail_time_end }}</td>
								@if($button==true)
								<td class="st-not">
									<button class="btn btn-sm btn-info attendance" type="button" title="Face Recognition" onclick="fcManualModal(this)" data-date="{{ DateTimes::jfy($d->agenda_detail_date) }}" data-employee="{{ json_encode($data->anggota_dewan) }}" data-detail="{{ json_encode($d) }}">
										<span class="fas fa-user-tie"></span>
									</button>
								</td>
								@endif
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
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php $i = 1; ?>
						@foreach($data->anggota_dewan as $d)
							<tr>
								<td>{{ $i++ }}</td>
								<td>
									<a href="{{ ($d->pegawai_id)? route('admin.employee.detail', $d->pegawai_id) :'' }}" title="Open Detail {{$d->pegawai_name}}" target="_blank">
										{{ $d->pegawai_name }}
									</a>
								</td>
								<td>{{ $d->pegawai_telp }}</td>
                                <td>{{ $d->pegawai_email }}</td>
                                <td>
									<button class="btn btn-sm btn-info" type="button" title="Detail" onclick="detailCheck(this)" data-id="{{ $d->pegawai_id }}" data-name="{{ $d->pegawai_name }}">
										<span class="fas fa-file"></span>
                                    </button>
                                </td>
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
					@if($button==true)
						<button type="submit" class="btn btn-primary btn-sm st-not">
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

<div class="modal" id="detailCheck" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Check In & Check Out</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="container-agenda-dc-alert"></div>
				<label id="dc-pegawai"></label>
                <br/>
                <ul class="nav nav-tabs">
                </ul>
                <div class="tab-content">
                </div>
			</div>
		</div>
    </div>

    <li class="nav-item" id="copy-nav-item" style="display:none;">
        <a class="nav-link active show" data-toggle="tab" href="#menu1">Menu 1</a>
    </li>
    <div class="tab-pane container active" id="copy-tab-pane" style="display:none;">
        <br/>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Check In</th>
                    <th>Check Out</th>
                </tr>
                <tr id="copy-pane-tr" style="display:none;">
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="card" style="display:none;" id="copy-pane-image">
        <img class="card-img-top" src="img_avatar1.png" style="width:100%">
        <div class="card-body">
            <p class="card-text">Some example text some example text.</p>
        </div>
    </div>
</div>

@if($button==true)
<div class="modal" id="fcManualModal" role="dialog">
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
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th>No</th>
							<th>NIK</th>
							<th>Name</th>
							<th>Photo</th>
							<th>Check In</th>
							<th>Check Out</th>
						</tr>
					</thead>
					<tbody id="fcm-employee">
						<tr id="copy" style="display:none;">
							<td></td>
							<td></td>
							<td class="text-left"></td>
							<td>
								<a href="" target="_blank">
									<img src="" style="max-width:60px; max-height:100px;" />
								</a>
							</td>
							<td>
								<button type="button" class="btn btn-sm btn-primary fcm-check">
									<span class="fas fa-sign-in-alt"></span>
									Check In
								</button>
							</td>
							<td>
								<button type="button" class="btn btn-sm btn-danger fcm-check">
									<span class="fas fa-sign-out-alt"></span>
									Check Out
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endif

@endsection

@push('css')
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	@if(isset($st) && $st==true)
		<style>.st-not{display:none;}</style>
	@endif
@endpush

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/agenda/detail.js') }}"></script>
@endpush
