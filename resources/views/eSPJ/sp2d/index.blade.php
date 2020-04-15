@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render('sp2d'),
    'activePage' => 'sp2d', 
    'activeNav' => '',
])
 
@section('content')
<div id="data" data-true="{{$atrue}}" data-false="{{$afalse}}"></div>
<div class="panel-header">  
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
              <a href="{{ route('admin.sp2d.create') }}" class="btn btn-primary btn-round btn-sm text-white pull-right">
				  <span class="fa fa-plus"></span>
                  Create
              </a>
            <h4 class="card-title">{{ __('SP2D') }}</h4>
            <div class="col-12 mt-2 container-sp2d-alert">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
			
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link {{$afalse}}" href="{{ route('admin.sp2d.index').'?a=false' }}">Belum disetujui</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{$atrue}}" href="{{ route('admin.sp2d.index').'?a=true' }}">Disetujui</a>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane container active">
					<br/>
					<table id="datatable" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>No. SP2D</th>
						  <th>Kegiatan</th>
						  <th class="disabled-sorting" width="15%">Action</th>
						</tr>
					  </thead>
					  <tbody>
					  </tbody>
					</table>
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
@endsection

@push('css')
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<style>
		table tbody td:nth-child(2) {
			text-align : left;
		}
		
		table tbody tr.odd td:nth-child(4) .btn-neutral {
			background-color : #f2f2f2 !important;
		}
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/eSPJ/sp2d/index.js') }}"></script>
@endpush