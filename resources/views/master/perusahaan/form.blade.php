@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => Breadcrumbs::render($master->breadcrumb),
    'activePage' => 'perusahaan',
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
            <div class="col-12 mt-2">
              @include('alerts.success')
              @include('alerts.errors')
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
      <form method="post" action="{{ $master->action }}">
      @csrf
      @if($master->method=="PUT")
        @method('PUT')
      @endif
      <div class="row">
        <div class="col-md-1">
          <label class="label" for="name">Name</label>
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="name" id="name" value="{{ (isset($data))?$data->perusahaan_name:'' }}" required />
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-3 offset-md-1">
          <button type="submit" class="btn btn-info btn-sm">
            <span class="fa fa-save"></span>
            Save
          </button>
          <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-link btn-sm">
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
  <style>
  </style>
@endpush 

@push('js')
@endpush