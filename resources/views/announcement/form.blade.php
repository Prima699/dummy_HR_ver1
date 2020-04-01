@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'Announcement',
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
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="category">Category</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="category" id="category" required>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="department">Department</label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="department" id="department" required>
						<option value="0">All</option>
					</select>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-1">
					<label class="label" for="message">Message</label>
				</div>
				<div class="col-md-11">
					<textarea class="form-control" name="message" id="message"></textarea>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-1">
					<button type="submit" class="btn btn-info btn-sm" id="btn-submit">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.category.index') }}" class="btn btn-link btn-sm">
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
	<style>
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/js/announcement/form.js') }}"></script>
@endpush