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
				<div class="col-md-5">: {{ $detail->agenda_title }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="nomor">Nomor SP2D</label>
				</div>
				<div class="col-md-3">: {{ $sp2d->code }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kegiatan">Kegiatan</label>
				</div>
				<div class="col-md-5">: {{ $detail->agenda_desc }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kategori">Kategori</label>
				</div>
				<div class="col-md-5">: {{ $detail->category_agenda_name }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="tanggal">Tanggal</label>
				</div>
				<div class="col-md-3">: {{ DateTimes::ymdhis($sp2d->tanggal) }}</div>
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
						<?php $i = 1; ?>
						@foreach($detail->anggota_dewan as $a)
							<tr>
								<th>{{ $i++ }}</th>
								<th>{{ $a->pegawai_name }}</th>
								<th>{{ $a->pegawai_NIK }}</th>
								<th>{{ $a->pegawai_telp }}</th>
								<th><img src="{{ Constants::assetApi() . $a->image[0]->path }}" style="max-width:120px; max-height:200px;" /></th>
							</tr>
						@endforeach
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
						<?php $i = 1; ?>
						@foreach($detail->detail_agenda as $a)
							<tr>
								<th>{{ $i++ }}</th>
								<th>{{ $a->agenda_detail_address }}</th>
								<th>{{ DateTimes::jfy($a->agenda_detail_date) }}<br/>{{ DateTimes::custom($a->agenda_detail_time_start,'H:i') }}</th>
								<th>{{ DateTimes::jfy($a->agenda_detail_date) }}<br/>{{ DateTimes::custom($a->agenda_detail_time_end,'H:i') }}</th>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="anggaran">Anggaran</label>
				</div>
				<div class="col-md-3">: <span id="anggaran" data-a-sign="Rp. ">{{ $sp2d->anggaran }}</span></div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="berangkat">Tanggal Berangkat</label>
				</div>
				<div class="col-md-3">: {{ DateTimes::jfy($detail->agenda_date) }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="kembali">Tanggal Kembali</label>
				</div>
				<div class="col-md-3">: {{ DateTimes::jfy($detail->agenda_date_end) }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="ntpn">NTPN</label>
				</div>
				<div class="col-md-5">: {{ $sp2d->ntpn }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="mak">MAK</label>
				</div>
				<div class="col-md-5">: {{ $sp2d->mak }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-3 offset-md-2">
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
@endsection

@push('css')
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
	<script>
		const anElement = new AutoNumeric('#anggaran');
	</script>
@endpush