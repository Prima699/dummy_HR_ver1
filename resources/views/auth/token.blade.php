@extends('layouts.app', [
    'namePage' => 'Login page',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'login',
    'backgroundImage' => asset('public/'.'assets') . "/img/bg14.jpg",
	'page' => false
])

@section('content')
    <div class="content">
        <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">
                                <p class="text-lead text-light mt-3 mb-0">
                                    @include('alerts.migrations_check')
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto">
            <form role="form" method="POST" action="{{ route('auth.submit') }}">
                @csrf
            <div class="card card-login card-plain">
                <div class="card-header ">
                <div class="logo-container">
                    <img src="{{ asset('public/'.'assets/img/now-logo.png') }}" alt="">
                </div>
				<div class="container-token-alert"></div>
                </div>
                <div class="card-body ">
                <div class="input-group no-border form-control-lg {{ $errors->has('company') ? ' has-danger' : '' }}">
                    <span class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                    </div>
                    </span>
                    <input class="form-control {{ $errors->has('company') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Token') }}" type="text" name="company" value="" required autofocus>
                </div>
                @if ($errors->has('company'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('company') }}</strong>
                    </span>
                @endif
                </div>
                <div class="card-footer ">
                <button type = "submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Submit') }}</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
