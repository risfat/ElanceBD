<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='personalDetail'? 'active': ''); ?>" href="<?php echo e(route('employerPersonalDetail')); ?>"><?php echo e(trans('lang.profile_detail')); ?></a>
        </li>
    </ul>
</div>