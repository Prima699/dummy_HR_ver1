@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'User Profile',
    'activePage' => 'profile',
    'activeNav' => '',
])
 
@section('content')
<table class="table table-striped">
<tr>

<th> Name</th>
<th> Age</th>
</tr>

@foreach($data as $list)


<tr>
<td>{{ $list['departemen_id'] }}</td>
<td>{{ $list['departemen_name']}}</td>                                    
</tr>
@endforeach 

</table>
  
@endsection