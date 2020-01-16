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
					<table id="dt1" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Category</th>
								<th>Title</th>
								<th>Start</th>
								<th>End</th>
								<th>Address</th>
								<th class="disabled-sorting" width="15%">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php $i = 1; ?>
						@foreach($data as $d)
							<tr>
								<th>{{ $i++ }}</th>
								<th>{{ $d->category_agenda_name }}</th>
								<th>{{ $d->agenda_title }}</th>
								<th>{{ $d->agenda_date }}</th>
								<th>{{ $d->agenda_date_end }}</th>
								<th>{{ $d->nama_city }}</th>
								<th>{{ $d->agenda_id }}</th>
							</tr>
						@endforeach
						</tbody>
					</table>
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
	<script src="{{ asset('public/js/agenda/employee.js') }}"></script>
@endpush