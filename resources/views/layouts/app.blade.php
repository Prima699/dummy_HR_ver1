<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/'.'assets') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('public/'.'assets') }}/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ asset("") }}" />
  <title>
    Digitas Information Sistem
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="{{ asset('public/'.'assets') }}/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('public/'.'assets') }}/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('public/'.'assets') }}/demo/demo.css" rel="stylesheet" />
  <link href="{{ asset('public/') }}/css/additional.css" rel="stylesheet" />
  @stack('css')
</head>

<body class="{{ $class ?? '' }}">
  <div class="wrapper">
    @if(Auths::user()!=NULL)
		@include('layouts.page_template.auth')
	@else
		@include('layouts.page_template.guest')
	@endif
  </div>
	<div id="app-notification-session-end" class="modal fade" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-body" style="padding:0px;">
					<div class="alert alert-warning" role="alert" style="margin:0px;">
						<div class="container text-center">
							<div class="alert-icon">
								<i class="now-ui-icons travel_info"> </i>
								<strong> Oh snap!</strong> your session is ended. Please <a href="{{ url('login') }}" style="text-decoration:underline;">log in</a> again to continue.
							</div>
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">
									<i class="now-ui-icons ui-1_simple-remove"></i>
								</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <!--   Core JS Files   -->
  <script>
	var digitasLink = "{{ route('index') }}";
	var digitasAssetApi = "{{ Constants::assetApi() }}";
  </script>
  <script src="{{ asset('public/'.'assets') }}/js/core/jquery.min.js"></script>
  <script src="{{ asset('public/'.'assets') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('public/'.'assets') }}/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('public/'.'assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('public/'.'assets') }}/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('public/'.'assets') }}/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{ asset('public/'.'assets') }}/demo/demo.js"></script>
  <script src="{{ asset('public/') }}/js/app/index.js"></script>
  <script src="{{ asset('public/') }}/js/app/jscolor.js"></script>
  @stack('js')
</body>

</html>