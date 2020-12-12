
<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-email-notification-settings wt-dbsectionspace" id="profile_settings">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                    <?php echo $__env->make('back-end.settings.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="wt-tabscontent tab-content">
                        <div class="wt-emailnotiholder" id="wt-emailnoti">
                            <div class="wt-emailnoti">
                                <div class="wt-tabscontenttitle">
                                    <h2><?php echo e(trans('lang.manage_email_notifications')); ?></h2>
                                </div>
                                <div class="wt-settingscontent">
                                    <div class="wt-description">
                                        <p><?php echo e(trans('lang.email_notifications_note')); ?></p>
                                    </div>
                                    <?php echo Form::open(['url' => url('profile/settings/save-email-settings'), 'class' =>'wt-formtheme wt-userform', 'id'=>'notifications']); ?>

                                        <fieldset>
                                            <div class="form-group form-disabeld">
                                                <input type="email" name="user_email" class="form-control" placeholder="<?php echo e($user_email); ?>" disabled="">
                                            </div>
                                        </fieldset>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>