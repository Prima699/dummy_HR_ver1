@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'data display',
    'activePage' => 'pegawai',
    'activeNav' => '',
])
 
@section('content')
{{-- <table class="table table-striped">
<tr>

<th> Id</th>
<th> Name</th>
</tr>

@foreach($data as $list)


<tr>
<td>{{ $list['pegawai_id'] }}</td>
<td>{{ $list['pegawai_name']}}</td>
<td>{{ $list['pegawai_address']}}</td>
<td>{{ $list['pegawai_telp']}}</td>  
                                 
</tr>
@endforeach 

</table> --}}

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
		table tbody td:nth-child(2) {
			text-align : left;
		}
	</style>
@endpush 

@push('js')
	<script>
		function dataTableAPI(){
			var r = "{{ route('admin.pegawai.data') }}";
			return r;
		}
	</script>
	<script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('public/js/pegawai/index.js') }}"></script>
@endpush