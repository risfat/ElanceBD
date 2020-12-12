<<<<<<< HEAD





















<!-- <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'comission-form', '@submit.prevent'=>'submitCommisionSettings']); ?>
=======
<?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'comission-form', '@submit.prevent'=>'submitCommisionSettings']); ?>
>>>>>>> 475afb7193f6fb2b1f1a9533f478a883ad05b781

    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2><?php echo e(trans('lang.payout_settings')); ?></h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-description">
                <p><?php echo e(trans('lang.set_comm_project')); ?></p>
            </div>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::number('payment[0][commision]', $commision, array('class' => 'form-control', 'placeholder' => '0')); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2><?php echo e(trans('lang.min_payout')); ?></h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-description">
                <p><?php echo e(trans('lang.set_min_payout')); ?></p>
            </div>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::number('payment[0][min_payout]', e($min_payout), ['class' => 'form-control', 'placeholder' => trans('lang.ph_min_payout')]); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2><?php echo e(trans('lang.select_payment_method')); ?></h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <select name="payment[0][payment_method]" class="form-control">
                        <option value="" selected><?php echo e(trans('lang.select_payment_method')); ?></option>
                        <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment_method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($payment_method['value']); ?>" <?php if($payment_gateway == $payment_method['value']): ?> selected <?php endif; ?> ><?php echo e($payment_method['title']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-updatall la-updateall-holder">
        <?php echo Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']); ?>

    </div>
<<<<<<< HEAD
<?php echo Form::close(); ?> -->
=======
<?php echo Form::close(); ?>

>>>>>>> 475afb7193f6fb2b1f1a9533f478a883ad05b781
