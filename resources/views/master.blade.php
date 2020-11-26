<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="{{{ asset('images/favicon.png') }}}" type="image/x-icon">
	<link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print" type="text/css">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
	<link href="{{ asset('css/scrollbar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/vue2-scrollbar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/fontawesome/fontawesome-all.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
	<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
	<link href="{{ asset('css/linearicons.css') }}" rel="stylesheet">
	<link href="{{ asset('css/tipso.css') }}" rel="stylesheet">
	<link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet">
	<link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
	<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('css/color.css') }}" rel="stylesheet">
	<link href="{{ asset('css/transitions.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
	<link href="{{ asset('css/emojionearea.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/basictable.css') }}" rel="stylesheet">
	@stack('stylesheets')
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!}
		var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
	</script>
	@if (Auth::user())
	<script type="text/javascript">
		var USERID = {!! json_encode(Auth::user()->id) !!}
		window.Laravel = {!! json_encode([
		'csrfToken'=> csrf_token(),
		'user'=> [
			'authenticated' => auth()->check(),
			'id' => auth()->check() ? auth()->user()->id : null,
			'name' => auth()->check() ? auth()->user()->first_name : null,
			'image' => !empty(auth()->user()->profile->avater) ? asset('uploads/users/'.auth()->user()->id .'/'.auth()->user()->profile->avater) : asset('images/user-login.png'),
			'image_name' => !empty(auth()->user()->profile->avater) ? auth()->user()->profile->avater : '',
			]
			])
		!!};
	</script>
	@endif
	<script>
		window.trans = <?php
		$lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
		$trans = [];
		foreach ($lang_files as $f) {
			$filename = pathinfo($f)['filename'];
			$trans[$filename] = trans($filename);
		}
		echo json_encode($trans);
		?>;
	</script>
</head>

<body class="wt-login">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!-- Preloader Start -->
	<div class="preloader-outer">
		<div class="preloader-holder">
			<div class="loader"></div>
		</div>
	</div>
	<!-- Wrapper Start -->
	<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
		<!-- Content Wrapper Start -->
		<div class="wt-contentwrapper">
			<!-- Header Start -->
			@yield('header')
			<!--Header End-->
			<!--Main Start-->
			@yield('main')
			<!--Main End-->
			<!--Footer Start-->
			@yield('footer')
			<!--Footer End-->
		</div>
		<!--Content Wrapper End-->
	</div>
	<!--Wrapper End-->
	<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
	<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
	<script src="{{ asset('js/vendor/jquery-library.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/chosen.jquery.js') }}"></script>
	<script src="{{ asset('js/tilt.jquery.js') }}"></script>
	<script src="{{ asset('js/scrollbar.min.js') }}"></script>
	<script src="{{ asset('js/prettyPhoto.js') }}"></script>
	<script src="{{ asset('js/jquery-ui.js') }}"></script>
	<script src="{{ asset('js/readmore.js') }}"></script>
	<script src="{{ asset('js/countTo.js') }}"></script>
	<script src="{{ asset('js/appear.js') }}"></script>
	<script src="{{ asset('js/tipso.js') }}"></script>
	<script src="{{ asset('js/gmap3.js') }}"></script>
	<script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>
	<script src="{{ asset('js/emojionearea.min.js') }}"></script>
	<script src="{{ asset('js/linkify.min.js') }}"></script>
	<script src="{{ asset('js/linkify-jquery.min.js') }}"></script>
	<script src="{{ asset('js/jquery.basictable.min.js') }}"></script>
	<script>
		jQuery('.wt-tablecategories').basictable({
			breakpoint: 767,
        });
        jQuery(window).load(function () {
            jQuery(".preloader-outer").delay(500).fadeOut();
            jQuery(".pins").delay(500).fadeOut("slow");
        });
	</script>
	@stack('scripts')
</body>

</html>
