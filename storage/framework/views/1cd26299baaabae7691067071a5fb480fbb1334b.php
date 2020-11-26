
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-insightsitemholder">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="wt-insightsitem wt-dashboardbox <?php echo e($notify_class); ?>">
                            <figure class="wt-userlistingimg">
                                <?php echo e(Helper::getImages('images/thumbnail/','img-19.png', 'book')); ?>

                            </figure>
                            <div class="wt-insightdetails">
                                <div class="wt-title">
                                    <h3><?php echo e(trans('lang.new_msgs')); ?></h3>
                                    <a href="<?php echo e(url('message-center')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-20.png', 'layers')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(trans('lang.latest_proposals')); ?></h3>
                                        <a href="<?php echo e(url('employer/dashboard/manage-jobs')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <countdown 
                                date="<?php echo e($expiry_date); ?>" 
                                :image_url="'<?php echo e(Helper::getDashExpiryImages('images/thumbnail/', 'img-21.png')); ?>'"
                                :title="'<?php echo e(trans('lang.check_pkg_expiry')); ?>'"
                                :package_url="'<?php echo e(url('dashboard/packages/employer')); ?>'"
                                >
                                </countdown>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-22.png', 'lnr lnr-heart')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(trans('lang.view_saved_items')); ?></h3>
                                        <a href="<?php echo e(url('employer/saved-items')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                    </div>													
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-16.png', 'cross-circle')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(Helper::getTotalJobs('cancelled')); ?></h3>
                                        <span><?php echo e(trans('lang.total_cancelled_jobs')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-17.png', 'cloud-sync')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(Helper::getTotalJobs('hired')); ?></h3>
                                        <span><?php echo e(trans('lang.total_ongoing_jobs')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-18.png', 'checkmark-circle')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(Helper::getTotalJobs('completed')); ?></h3>
                                        <span><?php echo e(trans('lang.total_completed_jobs')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-15.png', 'enter')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(Helper::getTotalJobs('posted')); ?></h3>
                                        <span><?php echo e(trans('lang.total_posted_jobs')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects wt-earningsholder">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.ongoing_project')); ?></h2>
                    </div>
                    <?php if(!empty($ongoing_jobs) && $ongoing_jobs->count() > 0): ?> 
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories wt-freelancer-table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('lang.project_title')); ?></th>
                                        <th><?php echo e(trans('lang.hired_freelancers')); ?></th>
                                        <th><?php echo e(trans('lang.project_cost')); ?></th>
                                        <th><?php echo e(trans('lang.actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $ongoing_jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $proposal_freelancer = $project->proposals->where('status', 'hired')->pluck('freelancer_id')->first();
                                            $freelancer = \App\User::find($proposal_freelancer);
                                            $user_name = Helper::getUsername($proposal_freelancer);
                                        ?>
                                        <tr>
                                            <td data-th="Project title"><span class="bt-content"><a target="_blank" href="<?php echo e(url('job/'.$project->slug)); ?>"><?php echo e($project->title); ?></a></span></td>
                                            <td data-th="Hired freelancer">
                                                <span class="bt-content">
                                                    <a href="<?php echo e(url('profile/'.$freelancer->slug)); ?>">
                                                        <?php if($freelancer->user_verified): ?>
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <?php echo e($user_name); ?>					
                                                    </a>
                                                </span>
                                            </td>
                                            <td data-th="Project cost"><span class="bt-content"><?php echo e(!empty($symbol['symbol']) ? $symbol['symbol'] : '$'); ?><?php echo e($project->price); ?></span></td>
                                            <td data-th="Actions">
                                                <span class="bt-content">
                                                    <div class="wt-btnarea">
                                                        <a href="<?php echo e(url('employer/dashboard/job/'.$project->slug.'/proposals')); ?>" class="wt-btn">View Details</a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>