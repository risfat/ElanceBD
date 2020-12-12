
<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9" id="proposals">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2><?php echo e(trans('lang.all_proposals')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-completejobholder">
                            <?php if(!empty($proposals) && $proposals->count() > 0): ?>
                                <div class="wt-managejobcontent">
                                    <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $freelancer_proposal = \App\Proposal::find($proposal->id);
                                            $duration = Helper::getJobDurationList($proposal->job->duration);
                                            $status_btn = $proposal->status == 'cancelled' ? trans('lang.view_reason') : trans('lang.view_detail');
                                            $detail_link = $proposal->status == 'hired' ? url('freelancer/job/'.$proposal->job->slug) : 'javascript:void(0);';
                                            $user_name = Helper::getUserName($proposal->job->employer->id);
                                        ?>
                                        <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                            <?php if(!empty($proposal->job->is_featured) && $proposal->job->is_featured === 'true'): ?>
                                                <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                            <?php endif; ?>
                                            <div class="wt-userlistingcontent wt-userlistingcontentvtwo">
                                                <div class="wt-contenthead">
                                                    <?php if(!empty($user_name) || !empty($proposal->job->title) ): ?>
                                                        <div class="wt-title">
                                                            <?php if(!empty($user_name)): ?>
                                                            <a href="<?php echo e(url('profile/'.$proposal->job->employer->slug)); ?>">
                                                                <?php if($proposal->job->employer->user_verified === 1): ?>
                                                                    <i class="fa fa-check-circle"></i>
                                                                <?php endif; ?>
                                                                &nbsp;<?php echo e($user_name); ?></a>
                                                            <?php endif; ?>
                                                            <?php if(!empty($proposal->job->title)): ?>
                                                                <h2><?php echo e($proposal->job->title); ?></h2>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if(!empty($proposal->job->price) ||
                                                        !empty($location['title'])  ||
                                                        !empty($proposal->job->project_type) ||
                                                        !empty($proposal->job->duration)
                                                        ): ?>
                                                        <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                            <?php if(!empty($proposal->job->price)): ?>
                                                                <li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> <?php echo e($proposal->job->price); ?></span></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($proposal->job->location->title)): ?>
                                                                <li><span><img src="<?php echo e(asset(Helper::getLocationFlag($proposal->job->location->flag))); ?>" alt="<?php echo e(trans('lang.locations')); ?>"> <?php echo e($proposal->job->location->title); ?></span></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($proposal->job->project_type)): ?>
                                                                <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> <?php echo e(trans('lang.type')); ?> <?php echo e($proposal->job->project_type); ?></a></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($proposal->job->duration)): ?>
                                                                <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> <?php echo e(trans('lang.duration')); ?> <?php echo e($duration); ?></span></li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="wt-rightarea la-pending-jobs">
                                                    <div class="wt-hireduserstatus">
                                                        <h4><?php echo e($proposal->status); ?></h4>
                                                        <?php if( $proposal->status != 'pending' ): ?>
                                                            <a href="<?php echo e(url('freelancer/job/'.$proposal->job->slug)); ?>" class="wt-btn">
                                                                <?php echo e($status_btn); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if( method_exists($proposals,'links') ): ?>
                        <?php echo e($proposals->links('pagination.custom')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>