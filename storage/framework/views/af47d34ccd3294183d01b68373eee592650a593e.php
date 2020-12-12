
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-insightsitemholder">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-20.png', 'layers')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(trans('lang.latest_proposals')); ?></h3>
                                        <a href="<?php echo e(route('showFreelancerProposals')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <countdown
                                date="<?php echo e($expiry_date); ?>"
                                :image_url="'<?php echo e(Helper::getDashExpiryImages('images/thumbnail/', 'img-21.png')); ?>'"
                                :title="'<?php echo e(trans('lang.check_pkg_expiry')); ?>'"
                                :package_url="'<?php echo e(url('dashboard/packages/freelancer')); ?>'"
                                :trail="'<?php echo e($trail); ?>'"
                                >
                                </countdown>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox <?php echo e($notify_class); ?>">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-19.png', 'book')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(trans('lang.new_msgs')); ?></h3>
                                        <a href="<?php echo e(route('message')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-22.png', 'lnr lnr-heart')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(trans('lang.view_saved_items')); ?></h3>
                                        <a href="<?php echo e(url('freelancer/saved-items')); ?>"><?php echo e(trans('lang.click_view')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-16.png', 'cross-circle')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e($cancelled_projects->count()); ?></h3>
                                        <h3><?php echo e(trans('lang.total_cancelled_projects')); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','img-17.png', 'cloud-sync')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e($ongoing_projects->count()); ?></h3>
                                        <h3><?php echo e(trans('lang.total_ongoing_projects')); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','icon-01.png', 'cart')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(!empty($symbol['symbol']) ? $symbol['symbol'] : '$'); ?><?php echo e(Helper::getProposalsBalance(Auth::user()->id, 'hired')); ?></h3>
                                        <h3><?php echo e(trans('lang.pending_bal')); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    <?php echo e(Helper::getImages('images/thumbnail/','icon-02.png', 'gift')); ?>

                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3><?php echo e(!empty($symbol['symbol']) ? $symbol['symbol'] : '$'); ?><?php echo e(Helper::getProposalsBalance(Auth::user()->id, 'completed')); ?></h3>
                                        <h3><?php echo e(trans('lang.curr_bal')); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.ongoing_project')); ?></h2>
                    </div>
                    <?php if(!empty($ongoing_projects) && $ongoing_projects->count() > 0): ?>
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories wt-freelancer-table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('lang.project_title')); ?></th>
                                        <th><?php echo e(trans('lang.employer_name')); ?></th>
                                        <th><?php echo e(trans('lang.project_cost')); ?></th>
                                        <th><?php echo e(trans('lang.actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $ongoing_projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $project = \App\Proposal::find($projects->id);
                                            $user = \App\User::find($project->job->user_id);
                                            $user_name = Helper::getUsername($project->job->user_id);
                                        ?>
                                        <tr>
                                            <td data-th="Project title"><span class="bt-content"><a target="_blank" href="<?php echo e(url('freelancer/job/'.$project->job->slug)); ?>"><?php echo e($project->job->title); ?></a></span></td>
                                            <td data-th="Hired freelancer">
                                                <span class="bt-content">
                                                    <a href="<?php echo e(url('profile/'.$user->slug)); ?>">
                                                        <?php if($user->user_verified): ?>
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <?php echo e($user_name); ?>					
                                                    </a>
                                                </span>
                                            </td>
                                            <td data-th="Project cost"><span class="bt-content"><?php echo e(!empty($symbol['symbol']) ? $symbol['symbol'] : '$'); ?><?php echo e($projects->amount); ?></span></td>
                                            <td data-th="Actions">
                                                <span class="bt-content">
                                                    <div class="wt-btnarea">
                                                        <a href="<?php echo e(url('freelancer/job/'.$project->job->slug)); ?>" class="wt-btn">View Details</a>
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox  wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.past_earnings')); ?></h2>
                    </div>
                    <?php if(!empty($completed_projects) && $completed_projects->count() > 0): ?>
                        <?php  
                            $commision = \App\SiteManagement::getMetaValue('commision'); 
                            $admin_commission = !empty($commision[0]['commision']) ? $commision[0]['commision'] : 0; 
                        ?>
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('lang.project_title')); ?></th>
                                        <th><?php echo e(trans('lang.date')); ?></th>
                                        <th><?php echo e(trans('lang.earnings')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $completed_projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $project = \App\Proposal::find($projects->id);
                                            $user_name = Helper::getUsername($project->job->user_id);
                                            $amount = !empty($project->amount) ? $project->amount - ($project->amount / 100) * $admin_commission : 0;
                                        ?>
                                        <tr class="wt-earning-contents">
                                            <td class="wt-earnig-single" data-th="Project Title"><span class="bt-content"><?php echo e($project->job->title); ?></span></td>
                                            <td data-th="Date"><span class="bt-content"><?php echo e($project->updated_at); ?></span></td>
                                            <td data-th="Earnings"><span class="bt-content"><?php echo e(!empty($symbol['symbol']) ? $symbol['symbol'] : '$'); ?><?php echo e($amount); ?></span></td>
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