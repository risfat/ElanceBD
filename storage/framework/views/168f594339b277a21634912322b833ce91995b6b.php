<?php $proposals_count = !empty($job->proposals) ? $job->proposals->count() : 0; ?>
<div class="wt-proposalsrcontent">
    <span class="wt-proposalsicon"><i class="fa fa-angle-double-down"></i><i class="fa fa-newspaper"></i></span>
    <div class="wt-title">
        <h3><?php echo e($proposals_count); ?></h3>
        <span><?php echo e(trans('lang.proposals_received')); ?><em><?php echo e(Carbon\Carbon::now()->format('M d Y')); ?></em></span>
    </div>
</div>
