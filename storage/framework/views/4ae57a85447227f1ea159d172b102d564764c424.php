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
	<title><?php echo e(config('app.name')); ?></title>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="image/x-icon">
	<link href="<?php echo e(asset('css/print.css')); ?>" rel="stylesheet" media="print" type="text/css">
	<link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/normalize.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/scrollbar.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/vue2-scrollbar.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/fontawesome/fontawesome-all.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/font-awesome.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/themify-icons.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/owl.carousel.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/jquery-ui.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/linearicons.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/tipso.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/prettyPhoto.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/chosen.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/main.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/responsive.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/color.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/transitions.css')); ?>" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
	<link href="<?php echo e(asset('css/emojionearea.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/basictable.css')); ?>" rel="stylesheet">
	<?php echo $__env->yieldPushContent('stylesheets'); ?>
	<script type="text/javascript">
		var APP_URL = <?php echo json_encode(url('/')); ?>

		var Map_key = <?php echo json_encode(Helper::getGoogleMapApiKey()); ?>

	</script>
	<?php if(Auth::user()): ?>
	<script type="text/javascript">
		var USERID = <?php echo json_encode(Auth::user()->id); ?>

		window.Laravel = <?php echo json_encode([
		'csrfToken'=> csrf_token(),
		'user'=> [
			'authenticated' => auth()->check(),
			'id' => auth()->check() ? auth()->user()->id : null,
			'name' => auth()->check() ? auth()->user()->first_name : null,
			'image' => !empty(auth()->user()->profile->avater) ? asset('uploads/users/'.auth()->user()->id .'/'.auth()->user()->profile->avater) : asset('images/user-login.png'),
			'image_name' => !empty(auth()->user()->profile->avater) ? auth()->user()->profile->avater : '',
			]
			]); ?>;
	</script>
	<?php endif; ?>
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
			<?php echo $__env->yieldContent('header'); ?>
			<!--Header End-->
			<!--Main Start-->
			<?php echo $__env->yieldContent('main'); ?>
			<!--Main End-->
			<!--Footer Start-->
			<?php echo $__env->yieldContent('footer'); ?>
			<!--Footer End-->
		</div>
		<!--Content Wrapper End-->
	</div>
	<!--Wrapper End-->
	<script src="<?php echo e(asset('js/jquery-3.3.1.js')); ?>"></script>
	<script src="<?php echo e(asset('js/tinymce/tinymce.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/vendor/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/app.js')); ?>"></script>
	<script src="<?php echo e(asset('js/main.js')); ?>"></script>
	<script src="<?php echo e(asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/vendor/jquery-library.js')); ?>"></script>
	<script src="<?php echo e(asset('js/owl.carousel.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/chosen.jquery.js')); ?>"></script>
	<script src="<?php echo e(asset('js/tilt.jquery.js')); ?>"></script>
	<script src="<?php echo e(asset('js/scrollbar.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/prettyPhoto.js')); ?>"></script>
	<script src="<?php echo e(asset('js/jquery-ui.js')); ?>"></script>
	<script src="<?php echo e(asset('js/readmore.js')); ?>"></script>
	<script src="<?php echo e(asset('js/countTo.js')); ?>"></script>
	<script src="<?php echo e(asset('js/appear.js')); ?>"></script>
	<script src="<?php echo e(asset('js/tipso.js')); ?>"></script>
	<script src="<?php echo e(asset('js/gmap3.js')); ?>"></script>
	<script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>
	<script src="<?php echo e(asset('js/emojionearea.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/linkify.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/linkify-jquery.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/jquery.basictable.min.js')); ?>"></script>
	<script>
		jQuery('.wt-tablecategories').basictable({
			breakpoint: 767,
        });
        jQuery(window).load(function () {
            jQuery(".preloader-outer").delay(500).fadeOut();
            jQuery(".pins").delay(500).fadeOut("slow");
        });
	</script>
	<?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
