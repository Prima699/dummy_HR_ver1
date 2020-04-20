@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'spj',
    'activeNav' => '',
])

@section('content')
<div id="data"
	data-sp2did="{{ -1 }}"
	data-sp2dname="{{ -1 }}"
	data-uid="{{ Auths::user('user.user_id') }}"
    data-at="{{ Auths::user('access_token') }}" hidden>

    <select name="pengeluaranJenis[]" class="form-control">
    @foreach($jenis as $j)
        <option value="{{ $j->id }}">{{ $j->name }}</option>
    @endforeach
    </select>

    <input type="file" name="pengeluaranFile[]" class="form-control" />

    <textarea name="pengeluaranDesc[]" class="form-control"></textarea>

    <button type="button" class="btn btn-sm btn-danger btn-icon btn-icon-mini" onclick="deletePengeluaran(this)">
        <span class="fa fa-trash">
    </button>

</div>
<div class="panel-header">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $master->title }}</h4>
            <div class="col-12 mt-2 container-sp2d-alert">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
			<form method="post" action="{{ $master->action }}" enctype="multipart/form-data">
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="sp2d">SP2D</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="sp2d" required />
					<input type="hidden" class="form-control" name="sp2d" id="sp2did" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="nomor">Nomor SPJ</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" id="nomor" name="nomor" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md">
                    <button type="button" class="btn btn-info btn-sm" id="addPengeluaran">
						<span class="fa fa-plus"></span>
						Add Pengeluaran
					</button>
                    <table class="table table-bordered" id="pengeluaran">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Jenis</th>
                            <th width="20%">Bukti</th>
                            <th>Keterangan</th>
                            <th width="10%">Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
				</div>
            </div>
            <br/>
			<div class="row">
				<div class="col-md-3">
					<button type="submit" class="btn btn-info btn-sm" id="save">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.spj.index') }}" class="btn btn-link btn-sm">
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

<div id="sp2dModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SP2D</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-modal-sp2d-alert"></div>
				<table class="table table-bordered" id="datatable">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th width="30%">No. SP2D</th>
							<th width="50%">Kegiatan</th>
							<th width="10%">Action</th>
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css"/>
	<style>
		table {
			width : 100% !important;
			text-align : center;
		}
		table#datatable tbody td:nth-child(2) {
			text-align : left;
		}
	</style>
@endpush

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
	<script src="{{ asset('public/js/eSPJ/spj/form.js') }}"></script>
@endpush
