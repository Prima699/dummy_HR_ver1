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
			<div class="container-presence-alert"></div>
			<div class="row menu">
				<div class="col-md-2 offset-md-3">
					<button class="form-control btn btn-primary btn-md" onclick="status('daily')">
						Daily
					</button>
				</div>
				<div class="col-md-2">
					<button class="form-control btn btn-primary btn-md" onclick="status('agenda')">
						Agenda
					</button>
				</div>
				<div class="col-md-2">
					<button class="form-control btn btn-primary btn-md" onclick="status('project')">
						Project
					</button>
				</div>
			</div>
			<div class="row takeAphoto" hidden>
				<div class="camera offset-md-2 col-md-8">
					<video id="video">Video stream not available.</video>
					<button id="startbutton" class="btn btn-primary btn-sm">Take photo</button> 
				</div>
				<canvas id="canvas" hidden></canvas>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <div id="captured" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Presence</h4>
      </div>
      <div class="modal-body">
		<img id="photo" alt="The screen capture will appear in this box."> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Re-take</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
@endpush 

@push('js')
	<script src="{{ asset('public/js/presence/index.js') }}"></script>
@endpush