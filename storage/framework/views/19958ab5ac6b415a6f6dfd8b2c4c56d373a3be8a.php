<?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'email-setting-form', '@submit.prevent'=>'submitEmailSettings']); ?>

    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2><?php echo e(trans('lang.from_email_name')); ?></h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::text('email_data[0][from_email]', e($from_email), array('class' => 'form-control')); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2><?php echo e(trans('lang.from_email_id')); ?></h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::text('email_data[0][from_email_id]', e($from_email_id), array('class' => 'form-control')); ?>

                </div>
            </div>
        </div>
    </div>
        <?php echo $__env->make('back-end.admin.settings.email.logo', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('back-end.admin.settings.email.banner', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('back-end.admin.settings.email.signature', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="wt-updatall la-updateall-holder">
        <?php echo Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']); ?>

    </div>  
<?php echo Form::close(); ?>