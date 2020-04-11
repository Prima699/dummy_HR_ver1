@extends('layouts.app', [
    'namePage' => Breadcrumbs::render('dashboard'),
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'dashboard', 
    'backgroundImage' => asset('public/'.'now') . "/img/bg14.jpg",
])

@section('content')
<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Today Attendance</h5>
				</div>
				<div class="card-body text-center">
					<span class="dashboard-value">1 / 10</span> <sub>pegawai</sub>
				</div>
			</div>
		</div>
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Cuti</h5>
				</div>
				<div class="card-body text-center">
					<span class="dashboard-value">0</span> <sub>pegawai</sub>
				</div>
			</div>
		</div>
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Izin</h5>
				</div>
				<div class="card-body text-center">
					<span class="dashboard-value">3</span> <sub>pegawai</sub>
				</div>
			</div>
		</div>
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Sakit</h5>
				</div>
				<div class="card-body text-center">
					<span class="dashboard-value">6</span> <sub>pegawai</sub>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Agenda</h5>
				</div>
				<div class="card-body text-center">
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Title</th>
								<th>Start Date</th>
								<th>Action</th>
							</tr>
						<thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Rapat Luas Kota</td>
								<td>10 January 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Rapat Luas Kota</td>
								<td>3 Maret 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Rapat Luas Kota</td>
								<td>7 Agustus 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<h5 class="card-category">Pengajuan Izin</h5>
				</div>
				<div class="card-body text-center">
					<table class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Pegawai</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						<thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Adit</td>
								<td>10 January 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Sopo</td>
								<td>3 Maret 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Jarwo</td>
								<td>7 Agustus 2020</td>
								<td>
									<button class="btn btn-sm btn-info btn-icon btn-icon-mini btn-natural" type="button">
										<span class="fa fa-file"></span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
	<style>
		span.dashboard-value {
			font-size : 60px;
			margin : 0px;
		}
		.row:nth-child(1) .card .card-body {
			padding: 0px !important;
		}
	</style>
@endpush

@push('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
	<script src="{{ asset('public/js/dashboard/dashboard.js') }}"></script>
@endpush