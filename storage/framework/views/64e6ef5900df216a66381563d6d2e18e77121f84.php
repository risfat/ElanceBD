<?php echo $__env->make('back-end.admin.settings.email.sender-avatar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.email_sender_name')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('email_data[0][sender_name]', e($sender_name), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.email_sender_tagline')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('email_data[0][sender_tagline]', e($sender_tagline), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.email_sender_url')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('email_data[0][sender_url]', e($sender_url), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
