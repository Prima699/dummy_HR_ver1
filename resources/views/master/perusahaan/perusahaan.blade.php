@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render('perusahaan'),
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
            <a href="{{ route('admin.perusahaan.created') }}" class="btn btn-primary btn-round btn-sm text-white pull-right">
              <span class="fa fa-plus"></span>
                  Create
              </a>
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
                  <th>Logo</th>
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
      var r = "{{ route('admin.perusahaan.data') }}";
      return r;
    }
  </script>
  <script src="{{ asset('public/assets/DataTables/datatables.min.js') }}"></script>
  <script src="{{ asset('public/js/perusahaan/index.js') }}"></script>
@endpush