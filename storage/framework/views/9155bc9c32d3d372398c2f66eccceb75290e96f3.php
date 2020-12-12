<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='personalDetail'? 'active': ''); ?>" href="<?php echo e(route('personalDetail')); ?>"><?php echo e(trans('lang.personal_detail')); ?></a>
        </li>
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='experienceEducation'? 'active': ''); ?>" href="<?php echo e(route('experienceEducation')); ?>"><?php echo e(trans('lang.experience_education')); ?></a>
        </li>
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='projectAwards'? 'active': ''); ?>" href="<?php echo e(route('projectAwards')); ?>"><?php echo e(trans('lang.project_awards')); ?></a>
        </li>
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='paymentSettings'? 'active': ''); ?>" href="<?php echo e(route('paymentSettings')); ?>"><?php echo e(trans('lang.payment_settings')); ?></a>
        </li>
    </ul>
</div>