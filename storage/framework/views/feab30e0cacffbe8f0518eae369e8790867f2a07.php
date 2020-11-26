<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.start_as_sec')); ?></h2>
</div>
    <?php echo $__env->make('back-end.admin.home-page-settings.sections.background-image', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('back-end.admin.home-page-settings.sections.start-as', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.download_app_sec_settings')); ?></h2>
</div>
<?php echo $__env->make('back-end.admin.home-page-settings.sections.download-app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>