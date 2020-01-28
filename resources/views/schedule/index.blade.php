@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render('schedule'),
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
              <a href="{{ route('admin.schedule.create') }}" class="btn btn-primary btn-round btn-sm text-white pull-right">
				  <span class="fa fa-plus"></span>
                  Create
              </a>
            <h4 class="card-title">{{ __('Schedule') }}</h4>
            <div class="col-12 mt-2 container-schedule-alert">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <table id="datatable" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Employee</th>
                  <th>Shift</th>
                  <th class="disabled-sorting" width="15%">Action</th>
                </tr>
              </thead>
			  <tbody>
			  </tbody>
            </table>
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
		.tab-pane.container {
			padding : 15px 0px 0px 0px;
		}
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/schedule/index.js') }}"></script>
@endpush