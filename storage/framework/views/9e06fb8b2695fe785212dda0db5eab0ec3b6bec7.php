
<?php $__env->startSection('content'); ?>
    <div class="wt-dbsectionspace wt-haslayout la-ps-freelancer">
        <div class="freelancer-profile" id="user_profile">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <div class="wt-dashboardbox wt-dashboardtabsholder">
                        <?php echo $__env->make('back-end.freelancer.profile-settings.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="wt-tabscontent tab-content">
                            <?php if(Session::has('message')): ?>
                                <div class="flash_msg">
                                    <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
                                </div>
                            <?php endif; ?>
                            <?php if($errors->any()): ?>
                                <ul class="wt-jobalerts">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flash_msg">
                                            <flash_messages :message_class="'danger'" :time ='10' :message="'<?php echo e($error); ?>'" v-cloak></flash_messages>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                            <div class="wt-personalskillshold tab-pane active fade show" id="wt-skills">
                                <?php echo Form::open(['url' => '', 'class' =>'wt-userform', 'id' => 'freelancer_profile', '@submit.prevent'=>'submitFreelancerProfile']); ?>

                                    <div class="wt-yourdetails wt-tabsinfo">
                                        <?php echo $__env->make('back-end.freelancer.profile-settings.personal-detail.detail', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="wt-profilephoto wt-tabsinfo">
                                        <?php echo $__env->make('back-end.freelancer.profile-settings.personal-detail.profile_photo', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                    </div>
                                    <?php if(!empty($options) && $options['banner_option'] === 'true'): ?>
                                        <div class="wt-bannerphoto wt-tabsinfo">
                                            <?php echo $__env->make('back-end.freelancer.profile-settings.personal-detail.profile_banner', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="wt-location wt-tabsinfo">
                                        <?php echo $__env->make('back-end.freelancer.profile-settings.personal-detail.location', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="wt-skills">
                                        <?php echo $__env->make('back-end.freelancer.profile-settings.personal-detail.skill', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
                                    </div>
                                    <div class="wt-updatall">
                                        <i class="ti-announcement"></i>
                                        <span><?php echo e(trans('lang.save_changes_note')); ?></span>
                                        <?php echo Form::submit(trans('lang.btn_save_update'), ['class' => 'wt-btn', 'id'=>'submit-profile']); ?>

                                    </div>
                                <?php echo form::close();; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>