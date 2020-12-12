
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9" id="dashboard">
                <div class="wt-dashboardbox wt-dashboardtabsholder wt-saveitemholder">
                    <div class="wt-dashboardtabs">
                        <ul class="wt-tabstitle nav navbar-nav">
                            <li class="nav-item">
                                <a class="active" data-toggle="tab" href="#wt-skills"><?php echo e(trans('lang.saved_jobs')); ?></a>
                            </li>
                            <li class="nav-item"><a data-toggle="tab" href="#wt-education"><?php echo e(trans('lang.followed_companies')); ?></a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#wt-awards"><?php echo e(trans('lang.liked_freelancers')); ?></a></li>
                        </ul>
                    </div>
                    <div class="wt-tabscontent tab-content tab-savecontent">
                        <div class="wt-personalskillshold tab-pane active fade show" id="wt-skills">
                            <div class="wt-yourdetails">
                                <div class="wt-tabscontenttitle">
                                    <h2><?php echo e(trans('lang.saved_jobs')); ?></h2>
                                </div>
                                <?php if(!empty($saved_jobs)): ?>
                                    <div class="wt-dashboradsaveitem">
                                        <?php $__currentLoopData = $saved_jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php  
                                                $job = \App\Job::where('id', $job_id)->first(); 
                                                $duration  =  Helper::getJobDurationList($job->duration);
                                                $user_name = $job->employer->first_name.' '.$job->employer->last_name;
                                            ?>
                                            <div class="wt-userlistinghold wt-featured wt-dashboradsaveditems">
                                                <?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
                                                    <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                                <?php endif; ?>
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead wt-dashboardsavehead">
                                                        <?php if(!empty($user_name) || !empty($job->title)): ?>
                                                            <div class="wt-title">
                                                                <?php if(!empty($user_name)): ?>
                                                                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                                                                        <?php if($job->employer->user_verified === 1): ?><i class="fa fa-check-circle"></i>&nbsp;<?php echo e($user_name); ?> <?php endif; ?>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if(!empty($job->title)): ?>
                                                                    <h2><?php echo e($job->title); ?></h2>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                            <?php if(!empty($job->price)): ?>
                                                                <li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> <?php echo e($job->price); ?></span></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($job->location->title)): ?>
                                                                <li><span><img src="<?php echo e(asset(Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.img')); ?>"> <?php echo e($job->location->title); ?></span></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($job->project_type)): ?>
                                                                <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> <?php echo e(trans('lang.type')); ?> <?php echo e($job->project_type); ?></a></li>
                                                            <?php endif; ?>
                                                            <?php if(!empty($job->duration)): ?>
                                                                <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> <?php echo e(trans('lang.duration')); ?> <?php echo e($duration); ?></span></li>															
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>	
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endif; ?>
                            </div>
                            <?php if( method_exists($saved_jobs,'links') ): ?>
                                <?php echo e($saved_jobs->links('pagination.custom')); ?>

                            <?php endif; ?>
                        </div>
                        <div class="wt-educationholder tab-pane fade" id="wt-education">
                            <div class="wt-userexperience wt-followcompomy">
                                <div class="wt-tabscontenttitle">
                                    <h2><?php echo e(trans('lang.followed_companies')); ?></h2>
                                </div>
                                <?php if(!empty($saved_employers)): ?>
                                    <div class="wt-focomponylist">
                                        <?php $__currentLoopData = $saved_employers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $user = \App\User::find($employer);
                                                $profile = \App\User::find($employer)->profile;
                                                $user_image = !empty($profile) ? $profile->avater : '';
                                                $profile_image = !empty($user_image) ? '/uploads/users/'.$employer.'/'.$user_image : 'images/user-login.png';
                                                $user_name = Helper::getUserName($employer);
                                            ?>
                                            <div class="wt-followedcompnies">
                                                <div class="wt-userlistinghold wt-userlistingsingle">
                                                    <figure class="wt-userlistingimg">
                                                        <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>">
                                                    </figure>
                                                    <div class="wt-userlistingcontent">
                                                        <div class="wt-contenthead wt-followcomhead">
                                                            <div class="wt-title">
                                                                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                                                                        <?php if($job->employer->user_verified === 1): ?>
                                                                            <i class="fa fa-check-circle"></i> <?php echo e(trans('lang.verified_company')); ?></a>
                                                                        <?php endif; ?>
                                                                <h3><?php echo e($user_name); ?></h3>
                                                            </div>
                                                            <ul class="wt-followcompomy-breadcrumb wt-userlisting-breadcrumb">
                                                                <li><a href="<?php echo e(url('jobs/'.$user->slug)); ?>"> <?php echo e(trans('lang.open_jobs')); ?>  </a></li>
                                                                <li><a href="<?php echo e(url('profile/'.$user->slug)); ?>"> <?php echo e(trans('lang.full_profile')); ?></a></li>
                                                                <li><a href="javascript:void(0);" class="wt-savefollow"> <?php echo e(trans('lang.following')); ?></a></li>
                                                            </ul>
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
                            <?php if( method_exists($saved_employers,'links') ): ?>
                                <?php echo e($saved_employers->links('pagination.custom')); ?>

                            <?php endif; ?>
                        </div>
                        <div class="wt-awardsholder tab-pane fade" id="wt-awards">
                            <div class="wt-addprojectsholder wt-likefreelan">
                                <div class="wt-tabscontenttitle">
                                    <h2><?php echo e(trans('lang.liked_freelancers')); ?></h2>
                                </div>
                                <?php if(!empty($saved_freelancers)): ?>
                                    <div class="wt-likedfreelancers wt-haslayout">
                                        <?php $__currentLoopData = $saved_freelancers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $freelancer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $user = \App\User::find($freelancer);
                                                $profile = \App\User::find($freelancer)->profile;
                                                $rating = !empty($profile->rating) ? $profile->rating : 0;
                                                $user_image = !empty($profile) ? $profile->avater : '';
                                                $profile_image = !empty($user_image) ? '/uploads/users/'.$freelancer.'/'.$user_image : 'images/user.jpg';
                                                $user_name = Helper::getUserName($freelancer);
                                                $reviews = \App\Review::where('receiver_id', $freelancer)->count();
                                                $avg_rating = \App\Review::where('receiver_id', $user->id)->sum('avg_rating');
                                                $user_rating  = $avg_rating != 0 ? round($avg_rating/\App\Review::count()) : 0;
                                                $user_reviews = \App\Review::where('receiver_id', $user->id)->get();
                                                $stars  = $user_reviews->sum('avg_rating') != 0 ? $user_reviews->sum('avg_rating')/20*100 : 0;
                                            ?>
                                            <div class="wt-userlistinghold wt-featured">
                                                <figure class="wt-userlistingimg">
                                                    <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>">
                                                </figure>
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead">
                                                        <div class="wt-title">
                                                                <a href="<?php echo e(url('profile/'.$user->slug)); ?>">
                                                                    <?php if($user->user_verified === 1): ?>
                                                                        <i class="fa fa-check-circle"></i>
                                                                    <?php endif; ?> 
                                                                    <?php echo e($user_name); ?>

                                                                </a>
                                                            <h2>
                                                                <?php echo e($profile->tagline); ?>

                                                            </h2>
                                                        </div>
                                                        <ul class="wt-userlisting-breadcrumb">
                                                            <?php if(!empty($profile->hourly_rate)): ?>
                                                                <li>
                                                                    <span><i class="far fa-money-bill-alt"></i>
                                                                    <?php echo e(!empty($symbol) ? $symbol['symbol'] : '$'); ?>

                                                                    <?php echo e($profile->hourly_rate); ?> / hr</span>
                                                                </li>
                                                            <?php endif; ?>
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <img src="<?php echo e(asset(Helper::getLocationFlag($user->location->flag))); ?>" alt="<?php echo e(trans('lang.locations')); ?>"> 
                                                                    <?php echo e($user->location->title); ?>

                                                                </span>
                                                            </li>
                                                            <li class="wt-btndisbaled">
                                                                <a href="javascript:void(0);" class="wt-clicksave">
                                                                    <i class="fa fa-heart"></i> <?php echo e(trans('lang.saved')); ?>

                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="wt-rightarea">
                                                        <span class="wt-stars"><span style="width: <?php echo e($stars); ?>%;"></span></span>
                                                        <span class="wt-starcontent"><?php echo e($rating); ?>/<sub>5</sub> <em>(<?php echo e($reviews); ?> <?php echo e(trans('lang.feedbacks')); ?>)</em></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endif; ?>
                            </div>
                            <?php if( method_exists($saved_freelancers,'links') ): ?>
                                <?php echo e($saved_freelancers->links('pagination.custom')); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
                    <div class="wt-proposalsr">
                        <div class="wt-proposalsrcontent">
                            <figure>
                                <?php echo e(Helper::getImages('images/','save-1.png', 'graduation-hat')); ?>

                            </figure>
                            <div class="wt-title">
                                <h3><?php echo e(count($saved_jobs)); ?></h3>
                                <span><?php echo e(trans('lang.jobs_you_saved')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="wt-proposalsr">
                        <div class="wt-proposalsrcontent wt-componyfolow">
                            <figure>
                                <?php echo e(Helper::getImages('images/','save-2.png', 'apartment')); ?>

                            </figure>
                            <div class="wt-title">
                                <h3><?php echo e(count($saved_employers)); ?></h3>
                                <span><?php echo e(trans('lang.compnies_followed')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="wt-proposalsr">
                        <div class="wt-proposalsrcontent  wt-freelancelike">
                            <figure>
                                <?php echo e(Helper::getImages('images/','save-3.png', 'users')); ?>

                            </figure>
                            <div class="wt-title">
                                <h3><?php echo e(count($saved_freelancers)); ?></h3>
                                <span><?php echo e(trans('lang.freelancers_liked')); ?></span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>