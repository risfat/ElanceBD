
<?php $__env->startSection('content'); ?>
    <?php $user_id = !empty(Auth::user()) ? Auth::user()->id : '';  ?>
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="wt-haslayout wt-reset-pass" id="pass-reset">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <?php if(Session::has('error')): ?>
                        <div class="flash_msg float-right">
                            <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
                        </div>
                    <?php endif; ?>
                    <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                        <?php echo $__env->make('back-end.settings.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="wt-tabscontent tab-content">
                            <div class="wt-passwordholder" id="wt-password">
                                <div class="wt-changepassword">
                                    <div class="wt-tabscontenttitle">
                                        <h2><?php echo e(trans('lang.change_pass')); ?></h2>
                                    </div>
                                    <?php echo Form::open(['url' => url('profile/settings/request-password'), 'class' =>'wt-formtheme wt-userform']); ?>

                                        <fieldset>
                                            <div class="form-group form-group-half">
                                                <?php echo Form::password('old_password', ['class' => 'form-control'.($errors->has('old_password') ? ' is-invalid' : ''),
                                                    'placeholder' => trans('lang.ph_oldpass')]); ?>

                                                <?php if($errors->has('old_password')): ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($errors->first('old_password')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group form-group-half">
                                                <?php echo Form::password('confirm_password', ['class' => 'form-control','placeholder' => trans('lang.ph_confirm_pass')]); ?>

                                            </div>
                                            <?php echo Form::hidden('user_id', $user_id); ?>

                                        </fieldset>
                                        <div class="wt-updatall">
                                            <?php echo Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']); ?>

                                        </div>
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