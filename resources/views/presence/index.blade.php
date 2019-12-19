@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Presence',
    'activePage' => 'presence',
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
            <h4 class="card-title">{{ __('Presence') }}</h4>
          </div>
          <div class="card-body">
			  <div class="camera offset-md-2 col-md-8">
				<video id="video">Video stream not available.</video>
				<button id="startbutton" class="btn btn-primary btn-sm">Take photo</button> 
			  </div>
			  <canvas id="canvas">
			  </canvas>
			  <div class="output">
				<img id="photo" alt="The screen capture will appear in this box."> 
			  </div>
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
@endpush 

@push('js')
	<script src="{{ asset('public/js/presence/index.js') }}"></script>
@endpush