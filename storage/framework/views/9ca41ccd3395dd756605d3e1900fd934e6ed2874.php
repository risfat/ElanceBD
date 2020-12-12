
<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-delete-account wt-dbsectionspace" id="profile_settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <?php if(Session::has('message')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
                    </div>
                    <?php elseif(Session::has('error')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
                    </div>
                <?php endif; ?>
                <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                    <?php echo $__env->make('back-end.settings.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="wt-tabscontent tab-content">
                        <div class="wt-yourdetails wt-tabsinfo">
                            <div class="wt-tabscontenttitle">
                                <h2><?php echo e(trans('lang.delete_account')); ?></h2>
                            </div>
                            <div class="wt-formtheme wt-userform">
                                <?php echo Form::open(['url' => url('profile/settings/delete-user'), 'class' =>'wt-formtheme wt-userform delete-user-form', '@submit.prevent' => 'deleteAccount($event)', 'id' => 'delete_acc_form' ]); ?>

                                    <fieldset>
                                        <div class="form-group form-group-half">
                                            <?php echo Form::password('old_password', ['class' => 'form-control','placeholder' => trans('lang.ph_oldpass')]); ?>

                                        </div>
                                        <div class="form-group form-group-half">
                                            <?php echo Form::password('retype_password', ['class' => 'form-control','placeholder' => trans('lang.ph_retype_pass')]); ?>

                                        </div>
                                        <div class="form-group">
                                            <span class="wt-select">
                                                <?php echo Form::select('delete_reason', Helper::getDeleteAccReason(), null, array('placeholder' => trans('lang.select_reason'))); ?>

                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="delete_description" class="form-control" placeholder="<?php echo e(trans('lang.ph_desc_optional')); ?>"></textarea>
                                        </div>
                                        <div class="form-group form-group-half wt-btnarea">
                                            <?php echo Form::submit(trans('lang.btn_delete_account'), ['class' => 'wt-btn']); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>