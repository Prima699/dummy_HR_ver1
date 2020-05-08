@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'spj',
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
				<div class="col-md-5">: {{ $sp2d->kegiatan }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-2">
					<label class="label" for="nomor">Nomor SPJ</label>
				</div>
				<div class="col-md-3">: {{ $spj->code }}</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md">
            <table class="table table-bordered" id="pengeluaran">
                <thead>
                    <th width="5%">No.</th>
                    <th>Keterangan</th>
                    <th width="10%">Bukti</th>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($pengeluaran as $key => $value)
                    @if(isset($value[0]))
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td colspan="2" class="font-weight-bold text-left">{{ $value[0]->jenis }}</td>
                        </tr>
                        <?php $ii = 1; ?>
                        @foreach($value as $k => $v)
                            <tr>
                                <td></td>
                                <td class="text-left">{{ $ii++ . ". " . $v->keterangan }}</td>
                                <td>
                                    <a href="{{ asset('public/upload/espj/'.$v->bukti) }}" target="_blank">Buka</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
      <br/>
			<div class="row">
				<div class="col-md-3">
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
@endsection

@push('css')
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('public/assets/DataTables/datatables.min.css') }}"/>
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
@endpush
