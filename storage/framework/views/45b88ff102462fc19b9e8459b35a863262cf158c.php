<?php $__env->startSection('content'); ?>
    <?php session()->put(['job_id' => e($job->id)]); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left" id="jobs">
                <?php if(Session::has('error')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time ='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
                    </div>
                    <?php 
                        session()->forget('error'); 
                        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
                    ?>
                <?php endif; ?>
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2><?php echo e(trans('lang.hire_freelancer')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-jobdetailscontent la-papaldetailscontent">
                            <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                <?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
                                    <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                <?php endif; ?>
                                <div class="wt-userlistingcontent">
                                    <div class="wt-contenthead">
                                        <?php if(!empty($employer_name) || !empty($job->title) ): ?>
                                            <div class="wt-title">
                                                <?php if(!empty($employer_name)): ?>
                                                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                                                        <?php if($verified_user === 1): ?>
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <?php echo e($employer_name); ?>

                                                    </a>
                                                <?php endif; ?>
                                                <?php if(!empty($job->title)): ?>
                                                    <h2><?php echo e($job->title); ?></h2>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(!empty($job->price) || 
                                            !empty($job->location->title)): ?>
                                            <ul class="wt-userlisting-breadcrumb">
                                                <?php if(!empty($job->price)): ?>
                                                    <li><span><i class="far fa-money-bill-alt"></i> $<?php echo e($job->price); ?></span></li>
                                                <?php endif; ?>
                                                <?php if(!empty($job->location->title)): ?>
                                                    <li>
                                                        <span>
                                                            <img src="<?php echo e(asset(Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.location_img')); ?>"> <?php echo e($job->location->title); ?>

                                                        </span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="wt-rightarea">
                                        <div class="wt-hireduserstatus">
                                            <span><?php echo e($freelancer_name); ?></span>
                                            <ul class="wt-hireduserimgs">
                                                <li><figure><img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded"></figure></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>	
                            </div>
                            <div class="wt-btnarea"><a class="wt-btn" href="<?php echo e(url('bkash/ec-checkout')); ?>"><span><?php echo e(trans('Bkash')); ?></span></a></div>
                        </div>
                        <?php
                            session()->put(['product_id' => e($proposal->id)]);  
                            session()->put(['product_title' => e($job->title)]); 
                            session()->put(['product_price' => e($job->price)]); 
                            session()->put(['type' => 'project']); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>