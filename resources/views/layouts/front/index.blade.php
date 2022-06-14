
<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title',$title?? env('APP_NAME'))</title>
	<link rel="icon" type="image/png" href="{{ asset('static/') }}/images/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="{{ asset('static') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/font-awesome.css">
	<link rel="stylesheet" href="{{ asset('static') }}/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/niceselect.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/flex-slider.min.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/owl-carousel.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/slicknav.min.css">
	<link rel="stylesheet" href="{{ asset('static') }}/css/reset.css">
	<link rel="stylesheet" href="{{ asset('static') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('static') }}/css/responsive.css">
    @yield('css')
	@include('layouts.variable')
</head>
<body class="js">
	
    @include('layouts.front.navbar')
        
    @yield('body')
    
	<!-- <section class="shop-services section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
				</div>
			</div>
		</div>
	</section> -->

    @include('layouts.front.footer')
    
    <script src="{{ asset('static') }}/js/jquery.min.js"></script>
    <script src="{{ asset('static') }}/js/jquery-migrate-3.0.0.js"></script>
	<script src="{{ asset('static') }}/js/jquery-ui.min.js"></script>
	<script src="{{ asset('static') }}/js/popper.min.js"></script>
	<script src="{{ asset('static') }}/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{ asset('static') }}/js/slicknav.min.js"></script>
	<script src="{{ asset('static') }}/js/owl-carousel.js"></script>
	<script src="{{ asset('static') }}/js/magnific-popup.js"></script>
	<script src="{{ asset('static') }}/js/facnybox.min.js"></script>
	<script src="{{ asset('static') }}/js/waypoints.min.js"></script>
	<script src="{{ asset('static') }}/js/finalcountdown.min.js"></script>
	<script src="{{ asset('static') }}/js/nicesellect.js"></script>
	<script src="{{ asset('static') }}/js/ytplayer.min.js"></script>
	<script src="{{ asset('static') }}/js/flex-slider.js"></script>
	<script src="{{ asset('static') }}/js/scrollup.js"></script>
	<script src="{{ asset('static') }}/js/onepage-nav.min.js"></script>
	<script src="{{ asset('static') }}/js/easing.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	{{-- <script src="{{ asset('static') }}/js/active.js"></script> --}}
    <script src="{{ asset('store') }}/jq-cookie.min.js"></script>
    <script src="{{ asset('store') }}/main.js"></script>
	<script src="{{ asset('server') }}/front/userSigned.js"></script>
	@if($user = auth()->user())
		@if ($user->level_id == 2)
		<script>
			userCart()
		</script>	
		@endif
	@endif
    @yield('js')
</body>
</html>