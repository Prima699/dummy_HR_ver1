@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'data display',
    'activePage' => 'perusahaan_cabang',
    'activeNav' => '',
])
 
@section('content')
{{-- <table class="table table-striped">
<tr>

<th> Id Cabang</th>
<th> Id Perusahaan</th>
<th> Alamat</th>
<th> Kota</th>
<th> Provinsi</th>
<th> Country</th>
<th> Kota Cabang</th>
<th> Latitude</th>
<th> Longitude</th>
<th> Status</th>

</tr>

@foreach($data as $list)


<tr>

<td>{{ $list['perusahaan_cabang_id'] }}</td>
<td>{{ $list['perusahaan_id']}}</td> 
<td>{{ $list['departemen_name']}}</td>  
<td>{{ $list['ID_t_md_city']}}</td>  
<td>{{ $list['ID_t_md_province']}}</td>
<td>{{ $list['ID_t_md_country']}}</td>  
<td>{{ $list['pc_lat']}}</td>        
<td>{{ $list['pc_long']}}</td>        
<td>{{ $list['pc_status']}}</td>        


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
              <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('user.create') }}">{{ __('Add Departemen') }}</a>
            <h4 class="card-title">{{ __('Departemen') }}</h4>
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
                  <th> Id Cabang</th>
                  <th> Id Perusahaan</th>
                  <th> Alamat</th>
                  <th> Kota</th>
                  <th> Provinsi</th>
                  <th> Country</th>
                  <th> Latitude</th>
                  <th> Longitude</th>
                  <th> Status</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th> Id Cabang</th>
                  <th> Id Perusahaan</th>
                  <th> Alamat</th>
                  <th> Kota</th>
                  <th> Provinsi</th>
                  <th> Country</th>
                  <th> Latitude</th>
                  <th> Longitude</th>
                  <th> Status</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($data as $list)
                  <tr>
                    <td>{{ $list['perusahaan_cabang_id'] }}</td>
                    <td>{{ $list['perusahaan_id']}}</td> 
                    <td>{{ $list['pc_address']}}</td>  
                    <td>{{ $list['ID_t_md_city']}}</td>  
                    <td>{{ $list['ID_t_md_province']}}</td>
                    <td>{{ $list['ID_t_md_country']}}</td>  
                    <td>{{ $list['pc_lat']}}</td>        
                    <td>{{ $list['pc_long']}}</td>        
                    <td>{{ $list['pc_status']}}</td>   
                    {{-- edit belom bisa kang --}}
                     {{--  <td class="text-right">
                      @if($user->id!=auth()->user()->id)
                        <a type="button" href="{{route("user.edit",$user)}}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                          <i class="now-ui-icons ui-2_settings-90"></i>
                        </a>
                      <form action="{{ route('user.destroy', $user) }}" method="post" style="display:inline-block;" class ="delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm delete-button" data-original-title="" title="" onclick="confirm('{{ __('Are you sure you want to delete this user?') }}') ? this.parentElement.submit() : ''">
                          <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                      </form>
                    @else
                      <a type="button" href="{{ route('profile.edit') }}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                        <i class="now-ui-icons ui-2_settings-90"></i>
                      </a>
                    @endif
                    </td> --}}
                    {{-- akhir edit belom bisa --}}
                  </tr>
                @endforeach
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