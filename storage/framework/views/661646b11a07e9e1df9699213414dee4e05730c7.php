<?php 
    $curr_user_id = !empty(Auth::user()) ? Auth::user()->id : '';
    $role_type = App\User::getUserRoleType($curr_user_id);
?>
<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <?php if(!empty($role_type) && $role_type->name <> 'admin' ): ?>
            <li class="nav-item">
                <a class="<?php echo e(\Request::route()->getName()==='manageAccount'? 'active': ''); ?>" href="<?php echo e(route('manageAccount')); ?>"><?php echo e(trans('lang.manage_account')); ?></a>
            </li>
            <li class="nav-item">
                <a class="<?php echo e(\Request::route()->getName()==='emailNotificationSettings'? 'active': ''); ?>" href="<?php echo e(route('emailNotificationSettings')); ?>"><?php echo e(trans('lang.email_notify')); ?></a>
            </li>
            <li class="nav-item">
                <a class="<?php echo e(\Request::route()->getName()==='deleteAccount'? 'active': ''); ?>" href="<?php echo e(route('deleteAccount')); ?>"><?php echo e(trans('lang.delete_account')); ?></a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="<?php echo e(\Request::route()->getName()==='resetPassword'? 'active': ''); ?>" href="<?php echo e(route('resetPassword')); ?>"><?php echo e(trans('lang.reset_pass')); ?></a>
        </li>
    </ul>
</div>