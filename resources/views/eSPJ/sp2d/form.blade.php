@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'sp2d',
    'activeNav' => '',
])
 
@section('content')
<div id="data"
	data-stid="{{ -1 }}"
	data-stname="{{ -1 }}"
	data-uid="{{ Auths::user('user.user_id') }}"
	data-at="{{ Auths::user('access_token') }}"
	></div>
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
			<form method="post" action="{{ $master->action }}">
			@csrf
			@if($master->method=="PUT")
				@method('PUT')
			@endif
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="st">Surat Tugas</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="st" required />
					<input type="hidden" class="form-control" name="st" id="stid" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="nomor">Nomor SP2D</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" id="nomor" name="nomor" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kegiatan">Kegiatan</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="kegiatan" name="kegiatan" readonly />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kategori">Kategori</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="kategori" readonly />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="tanggal">Tanggal</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control dp" id="tanggal" name="tanggal" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<label class="label" for="pegawai">Pegawai</label>
					<table class="table table-bordered" id="pegawai">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>NIK</th>
								<th>Telepon</th>
								<th>Foto</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<label class="label" for="tujuan">Tujuan</label>
					<table class="table table-bordered" id="tujuan">
						<thead>
							<tr>
								<th>No</th>
								<th>Alamat</th>
								<th>Dari</th>
								<th>Sampai</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="anggaran">Anggaran</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="anggaran" name="anggaran" class="form-control " value="" data-a-sign="Rp. " required>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="berangkat">Tanggal Berangkat</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" id="berangkat" name="berangkat" readonly />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kembali">Tanggal Kembali</label>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" id="kembali" name="kembali" readonly />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="ntpn">NTPN</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="ntpn" name="ntpn" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="mak">MAK</label>
				</div>
				<div class="col-md-5">
					<input type="text" class="form-control" id="mak" name="mak" required />
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
					<button type="submit" class="btn btn-info btn-sm" id="save">
						<span class="fa fa-save"></span>
						Save
					</button>
					<a href="{{ route('admin.sp2d.index') }}" class="btn btn-link btn-sm">
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
  
<div id="stModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Surat Tugas</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-modal-sp2d-alert"></div>
				<table class="table table-bordered" id="datatable">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th>Kegiatan</th>
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
		table tbody td:nth-child(1) {
			width : 10%;
		}
		table tbody td:nth-child(3) {
			width : 10%;
		}
		table tbody td:nth-child(2) {
			text-align : left;
		}
	</style>
@endpush 

@push('js')
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
	<script src="{{ asset('public/js/eSPJ/sp2d/form.js') }}"></script>
@endpush