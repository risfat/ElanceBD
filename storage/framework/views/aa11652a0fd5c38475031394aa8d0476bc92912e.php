
<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-manage-account wt-dbsectionspace la-setting-holder" id="settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'home-settings-form', '@submit.prevent'=>'submitHomeSettings']); ?>

                    <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                        <div class="wt-dashboardtabs">
                            <ul class="wt-tabstitle nav navbar-nav">
                                <li class="nav-item">
                                    <a class="active" data-toggle="tab" href="#wt-banner"><?php echo e(trans('lang.banner_settings')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="" data-toggle="tab" href="#wt-sections"><?php echo e(trans('lang.sections')); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="wt-tabscontent tab-content">
                            <div class="wt-securityhold tab-pane active la-banner-settings" id="wt-banner">
                                <?php echo $__env->make('back-end.admin.home-page-settings.banner-settings.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                            <div class="wt-securityhold tab-pane la-section-settings" id="wt-sections">
                                <?php echo $__env->make('back-end.admin.home-page-settings.sections.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>
                        <div class="wt-updatall">
                            <?php echo Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']); ?>

                        </div>
                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>