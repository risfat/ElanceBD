
<?php $__env->startSection('content'); ?>
    <div class="freelancer-profile wt-dbsectionspace la-admin-details" id="user_profile">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="wt-dashboardbox wt-dashboardtabsholder">
                    <div class="wt-dashboardtabs">
                        <ul class="wt-tabstitle nav navbar-nav">
                            <li class="nav-item">
                                <a class="<?php echo e(\Request::route()->getName()==='adminProfile'? 'active': ''); ?>" href="<?php echo e(route('adminProfile')); ?>"><?php echo e(trans('lang.admin_detail')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="wt-tabscontent tab-content">
                        <?php if(Session::has('message')): ?>
                            <div class="flash_msg">
                                <flash_messages :message_class="'success'" :time='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
                            </div>
                        <?php endif; ?> 
                        <?php if($errors->any()): ?>
                            <ul class="wt-jobalerts">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flash_msg">
                                        <flash_messages :message_class="'danger'" :time='10' :message="'<?php echo e($error); ?>'" v-cloak></flash_messages>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                        <div class="wt-personalskillshold tab-pane active show">
                            <?php echo Form::open(['url' => '', 'class' =>'wt-userform', 'id' => 'admin_data', '@submit.prevent' => 'submitAdminProfile']); ?>

                                <div class="wt-yourdetails wt-tabsinfo">
                                    <div class="wt-tabscontenttitle">
                                        <h2><?php echo e(trans('lang.your_details')); ?></h2>
                                    </div>
                                    <div class="lara-detail-form">
                                        <fieldset>
                                            <div class="form-group form-group-half">
                                                <?php echo Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')]); ?>

                                            </div>
                                            <div class="form-group form-group-half">
                                                <?php echo Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')]); ?>

                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="wt-profilephoto wt-tabsinfo">
                                    <?php echo $__env->make('back-end.admin.profile-settings.personal-detail.profile_photo', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                                <div class="wt-bannerphoto wt-tabsinfo">
                                    <?php echo $__env->make('back-end.admin.profile-settings.personal-detail.profile_banner', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                                <div class="wt-updatall la-updateall-holder">
                                    <i class="ti-announcement"></i>
                                    <span><?php echo e(trans('lang.save_changes_note')); ?></span> <?php echo Form::submit(trans('lang.btn_save_update'),
                                    ['class' => 'wt-btn', 'id'=>'submit-profile']); ?>

                                </div>
                            <?php echo form::close();; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>