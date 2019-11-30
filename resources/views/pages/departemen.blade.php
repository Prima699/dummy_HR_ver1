@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'data display',
    'activePage' => 'datadisplay',
    'activeNav' => '',
])
 
@section('content')
<table class="table table-striped">
<tr>

<th> Id</th>
<th> Name</th>
</tr>

@foreach($data as $list)


<tr>
<td>{{ $list['departemen_id'] }}</td>
<td>{{ $list['departemen_name']}}</td>                                    
</tr>
@endforeach 

</table>
  
@endsection