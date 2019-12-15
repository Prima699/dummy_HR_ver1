@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'data display',
    'activePage' => 'perusahaan',
    'activeNav' => '',
])
 
@section('content')
{{-- <table class="table table-striped">
<tr>

<th> Id</th>
<th> Name</th>
<th> Type</th>
<th> Logo</th> 
</tr>

@foreach($data as $list)


<tr>
<td>{{ $list['perusahaan_id'] }}</td>
<td>{{ $list['perusahaan_name']}}</td>  
<td>{{ $list['bussiness_type_id']}}</td>   
<td>{{ $list['perusahaan_logo']}}</td>                                    
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
              <button type="button" class="btn btn-primary btn-round text-white pull-right" data-toggle="modal" data-target="#myModal">
                  Add Data
              </button>
            <h4 class="card-title">{{ __('Perusahaan') }}</h4>
            <div class="col-12 mt-2">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Logo</th>
                  <th>Business type</th>
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

  <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Add Data Golongan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
                <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('admin.perusahaan.created') }}">{{ ('Add Data') }}</a>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    function dataTableAPI(){
      var r = "{{ route('admin.perusahaan.data') }}";
      return r;
    }
  </script>
  <script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
  <script src="{{ asset('public/js/perusahaan/index.js') }}"></script>
@endpush