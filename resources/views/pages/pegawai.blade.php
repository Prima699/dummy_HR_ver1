@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'data display',
    'activePage' => 'pegawai',
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
              <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('user.create') }}">{{ __('Add user') }}</a>
            <h4 class="card-title">{{ ('Pegawai') }}</h4>
            <div class="col-12 mt-2">
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
                  <th>Name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th class="disabled-sorting" width="20%">Action</th>
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
  
  <!-- Modal -->
<div id="faceTrain" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modal Header</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				@csrf
				<div class="container-category-image-alert"></div>
				<table id="faceTrainDT" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Image</th>
							<th width="5%">Face Detect</th>
							<th width="5%">Tag Save</th>
							<th width="5%">Face Train</th>
							<th class="disabled-sorting" width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
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
		table tbody td:nth-child(2) {
			text-align : left;
		}
	</style>
@endpush 

@push('js')
	<script>
		function API(str,id=null){
			var r = "";
			if(str=="data"){
				r = "{{ route('admin.pegawai.data') }}";
			}else if(str=="image"){
			}else if(str=="detect"){
			}
			return r;
		}
	</script>
	<script src="{{ asset('public/js/faceTrain/FCClientJS.js') }}"></script>
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/pegawai/index.js') }}"></script>
	<script src="{{ asset('public/js/pegawai/faceTrain.js') }}"></script>
@endpush