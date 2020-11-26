<aside id="wt-sidebar" class="wt-sidebar">
    <div class="wt-proposalsr">
        <?php echo $__env->make('front-end.jobs.sidebar.wt-jobproposals-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('front-end.jobs.sidebar.wt-qrcode-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('front-end.jobs.sidebar.wt-addtofavourite-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo $__env->make('front-end.jobs.sidebar.wt-employerinfo-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('front-end.jobs.sidebar.wt-sharejob-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('front-end.jobs.sidebar.wt-reportjob-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</aside>
