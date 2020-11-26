 
<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-manage-account wt-dbsectionspace la-admin-setting" id="settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 float-left">
                <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                    <div class="wt-dashboardtabs">
                        <ul class="wt-tabstitle nav navbar-nav">
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='settings/#wt-general'? 'active': ''); ?>" data-toggle="tab" href="#wt-general"><?php echo e(trans('lang.general_settings')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='settings/#wt-email'? 'active': ''); ?>" data-toggle="tab" href="#wt-email"><?php echo e(trans('lang.email_settings')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='settings/#wt-payment'? 'active': ''); ?>" data-toggle="tab" href="#wt-payment"><?php echo e(trans('lang.payment_settings')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='settings/#wt-footer'? 'active': ''); ?>" data-toggle="tab" href="#wt-footer"><?php echo e(trans('lang.footer_settings')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='settings/#wt-demo'? 'active': ''); ?>" data-toggle="tab" href="#wt-demo"><?php echo e(trans('lang.demo_content')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="wt-tabscontent tab-content">
                        <div class="wt-securityhold tab-pane active la-general-setting" id="wt-general">
                            <?php echo $__env->make('back-end.admin.settings.general.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="wt-securityhold tab-pane la-email-setting" id="wt-email">
                            <?php echo $__env->make('back-end.admin.settings.email.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="wt-securityhold tab-pane la-payment-setting" id="wt-payment">
                            <?php echo $__env->make('back-end.admin.settings.payment.commision-settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php echo $__env->make('back-end.admin.settings.payment.paypal-settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="wt-securityhold tab-pane la-footer-setting" id="wt-footer">
                            <?php echo $__env->make('back-end.admin.settings.footer.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="wt-securityhold tab-pane la-footer-setting" id="wt-demo">
                            <?php echo $__env->make('back-end.admin.settings.demo-content.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>