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
								<th>Starting at</th>
								<th>Finished at</th>
							</tr>
						</thead>
						<tbody>
						@foreach($data->detail_agenda as $d)
							<tr>
								<td>{{ $d->agenda_detail_date }}</td>
								<td>{{ $d->agenda_detail_address }}</td>
								<td>{{ $d->agenda_detail_time_start }}</td>
								<td>{{ $d->agenda_detail_time_end }}</td>
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
								<th>No</th>
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
								<td>{{ $d->pegawai_name }}</td>
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
				<div class="col-md-2">
					<a href="{{ $back }}" class="btn btn-link btn-sm">
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
	<script src="{{ asset('public/js/agenda/detail.js') }}"></script>
@endpush