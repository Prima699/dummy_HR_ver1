@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'category',
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
			<form method="post" action="{{ $master->action }}">
			@csrf
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="name">Name</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" name="name" id="name" value="{{ (isset($data))?$data->calendar_desc:'' }}" required maxlength="45" />
				</div>
			</div>
			<br/>
			@if($master->method=="PUT")
				@method('PUT')			
				<div class="row">
					<div class="col-md-1">
						<label class="label" for="date">Date</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control dp" name="date" id="date" value="{{ (isset($data))? DateTimes::dmy($data->calendar_date) :'' }}" required />
					</div>
				</div>
				<br/>
			@else
				<div class="row">
					<div class="col-md-1">
						<label class="label" for="from">From</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control dp" name="from" id="from" required />
					</div>
				</div>
				<br/>			
				<div class="row">
					<div class="col-md-1">
						<label class="label" for="to">To</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control dp" name="to" id="to" required />
					</div>
				</div>
				<br/>
			@endif
			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.calendar.index') }}" class="btn btn-link btn-sm">
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css"/>
@endpush 

@push('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
	<script src="{{ asset('public/js/calendar/form.js') }}"></script>
@endpush