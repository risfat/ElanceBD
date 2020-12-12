 
<?php $__env->startPush('stylesheets'); ?>
	<link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/dbresponsive.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main'); ?>
	<main id="wt-main" class="wt-main wt-haslayout">
		<?php if(Auth::user()): ?>
			<?php echo $__env->make('back-end.includes.dashboard-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
		<?php echo $__env->yieldContent('content'); ?>
	</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>