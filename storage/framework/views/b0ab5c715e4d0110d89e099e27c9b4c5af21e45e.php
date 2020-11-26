<?php $__env->startSection('content'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('showUserProfile', $user->slug); ?>
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                    <div class="wt-title"><h2><?php echo e(Helper::getUserName($user->id)); ?></h2></div>
                    <ol class="wt-breadcrumb">
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($breadcrumb->url && !$loop->last): ?>
                                <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                            <?php else: ?>
                                <li class="active"><?php echo e($breadcrumb->title); ?></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-main-section wt-haslayout la-profile-holder" id="user_profile">
        <div class="container">
            <div class="row">
                <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                    <?php if(!empty($banner)): ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left">
                            <div class="wt-comsingleimg">
                                <figure><img src="<?php echo e(asset(Helper::getUserProfileBanner($user->id, 'medium'))); ?>" alt="<?php echo e(trans('lang.company_banner')); ?>"></figure>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                        <aside id="wt-sidebar" class="wt-sidebar">
                            <div class="wt-proposalsr wt-proposalsrvtwo">
                                <div class="wt-widgetcontent wt-companysinfo">
                                    <figure><img src="<?php echo e(asset($avatar)); ?>" alt="<?php echo e(trans('lang.img')); ?>"></figure>
                                    <div class="wt-title">
                                        <?php if($user->user_verified === 1): ?>
                                            <a href="<?php echo e(url('profile/'.$user->slug)); ?>"><i class="fa fa-check-circle"></i> <?php echo e(trans('lang.verified_company')); ?></a>
                                        <?php endif; ?>
                                        <h2><?php echo e($user_name); ?></h2>
                                    </div>

                                </div>
                                <div class="tg-authorcodescan">
                                    <figure class="tg-qrcodeimg">
                                        <?php echo QrCode::size(100)->generate(Request::url('profile/'.$user->slug));; ?>

                                    </figure>
                                    <div class="tg-qrcodedetail">
                                        <span class="lnr lnr-laptop-phone"></span>
                                        <div class="tg-qrcodefeat">
                                            <h3><?php echo e(trans('lang.scan_with_smartphone')); ?>

                                                <span><?php echo e(trans('lang.smartphone')); ?> </span>
                                                <?php echo e(trans('lang.get_handy')); ?>

                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <?php if(in_array($user->id, $save_employer)): ?>
                                <div class="wt-clicksavearea">
                                    <a href="javascript:void(0);" class="wt-clicksavebtn wt-btndisbaled" >
                                        <i class="fa fa-heart"></i>
                                        following
                                    </a>
                                </div>
                                <?php else: ?>
                                <div class="wt-clicksavearea">
                                    <a href="javascript:void(0);" id="profile-<?php echo e($user->id); ?>" class="wt-clicksavebtn" @click.prevent="add_wishlist('profile-<?php echo e($user->id); ?>', <?php echo e($user->id); ?>, 'saved_employers', 'following')" v-cloak>
                                        <i></i>
                                        Click to Follow
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="wt-widget">
                                <div class="wt-widgettitle">
                                    <h2><?php echo e(trans('lang.company_followers')); ?></h2>
                                </div>
                                <div class="wt-widgetcontent wt-comfollowers wt-verticalscrollbar">
                                    <?php if($followers->count() > 0): ?>
                                        <ul>
                                            <?php $__currentLoopData = $followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $profile = \App\Profile::all()->where('user_id', $follower->follower)->first();
                                                    $role_id = Helper::getRoleByUserID($follower->follower);
                                                ?>
                                                <?php if(Helper::getRoleName($role_id) !== 'admin'): ?>
                                                    <li>
                                                        <a href="<?php echo e(url('profile/'.$profile->user->slug)); ?>">
                                                            <span><img src="<?php echo e(asset(Helper::getProfileImage($follower->follower))); ?>" alt="Follower"></span>
                                                            <span><?php echo e(Helper::getUserName($follower->follower)); ?></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php else: ?>
                                        <p><?php echo e(trans('lang.no_followers')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="wt-widget wt-sharejob">
                                <div class="wt-widgettitle">
                                    <h2><?php echo e(trans('lang.share_company')); ?></h2>
                                </div>
                                <div class="wt-widgetcontent">
                                    <ul class="wt-socialiconssimple">
                                        <li class="wt-facebook">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(Request::fullUrl())); ?>" class="social-share">
                                            <i class="fa fa fa-facebook-f"></i><?php echo e(trans('lang.share_fb')); ?></a>
                                        </li>
                                        <li class="wt-twitter">
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(Request::fullUrl())); ?>" class="social-share">
                                            <i class="fa fab fa-twitter"></i><?php echo e(trans('lang.share_twitter')); ?></a>
                                        </li>
                                        <li class="wt-pinterest">
                                            <a href="//pinterest.com/pin/create/button/?url=<?php echo e(urlencode(Request::fullUrl())); ?>"
                                            onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
                                            <i class="fa fab fa-pinterest-p"></i><?php echo e(trans('lang.share_pinterest')); ?></a>
                                        </li>
                                        <li class="wt-googleplus">
                                            <a href="https://plus.google.com/share?url=<?php echo e(urlencode(Request::fullUrl())); ?>" class="social-share">
                                            <i class="fa fab fa-google-plus-g"></i><?php echo e(trans('lang.share_google')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="wt-widget wt-reportjob">
                                <div class="wt-widgettitle">
                                    <h2><?php echo e(trans('lang.report_employer')); ?></h2>
                                </div>
                                <div class="wt-widgetcontent">
                                    <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-formreport', 'id' => 'submit-report',  '@submit.prevent'=>'submitReport("'.$profile->user_id.'","employer-report")']); ?>

                                        <fieldset>
                                            <div class="form-group">
                                                <span class="wt-select">
                                                    <?php echo Form::select('reason', \Illuminate\Support\Arr::pluck($reasons, 'title'), null ,array('class' => '', 'placeholder' => trans('lang.select_reason'), 'v-model' => 'report.reason')); ?>

                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <?php echo Form::textarea( 'description', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'), 'v-model' => 'report.description'] ); ?>

                                            </div>
                                            <div class="form-group wt-btnarea">
                                                <?php echo Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn']); ?>

                                            </div>
                                        </fieldset>
                                    <?php echo form::close();; ?>

                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-left">
                        <div class="wt-userlistingholder wt-haslayout">
                            <div class="wt-comcontent">
                                <div class="wt-title">
                                    <h3><?php echo e(trans('lang.about')); ?> “<?php echo e($user_name); ?>”</h3>
                                </div>
                                <div class="wt-description">
                                    <?php echo htmlspecialchars_decode(stripslashes($profile->description)); ?>
                                </div>
                            </div>
                            <?php if(!empty($jobs) && $jobs->count() > 0): ?>
                                <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $job = \App\Job::find($job->id);
                                        $description = strip_tags(stripslashes($job->description));
                                        $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                    ?>
                                    <div class="wt-userlistinghold wt-userlistingholdvtwo <?php echo e($featured_class); ?>">
                                        <?php if($job->is_featured == 'true'): ?>
                                            <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                        <?php endif; ?>
                                        <div class="wt-userlistingcontent">
                                            <div class="wt-contenthead">
                                                <div class="wt-title">
                                                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                                                        <?php if($job->employer->user_verified === 1): ?>
                                                            <i class="fa fa-check-circle"></i>
                                                        <?php endif; ?>
                                                        <?php echo e($job->employer->first_name.' '.$job->employer->last_name); ?>

                                                    </a>
                                                    <h2><?php echo e($job->title); ?></h2>
                                                </div>
                                                <div class="wt-description">
                                                    <p><?php echo htmlspecialchars_decode(stripslashes(str_limit($description, 200))); ?></p>
                                                </div>
                                                <div class="wt-tag wt-widgettag">
                                                    <?php $__currentLoopData = $job->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(url('search-results?type=job&skills%5B%5D='.$skill->slug)); ?>"><?php echo e($skill->title); ?></a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                            <div class="wt-viewjobholder">
                                                <ul>
                                                    <li><span><i class="fa fa-dollar-sign wt-viewjobdollar"></i><?php echo e($job->price); ?></span></li>
                                                    <?php if(!empty($job->location->title)): ?>
                                                        <li><span><img src="<?php echo e(asset(App\Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.location')); ?>"> <?php echo e($job->location->title); ?></span></li>
                                                    <?php endif; ?>
                                                    <li><span><i class="far fa-folder wt-viewjobfolder"></i><?php echo e(trans('lang.type')); ?> <?php echo e($job->project_type); ?></span></li>
                                                    <li><span><i class="far fa-clock wt-viewjobclock"></i><?php echo e(Helper::getJobDurationList($job->duration)); ?></span></li>
                                                    <li><span><i class="fa fa-tag wt-viewjobtag"></i><?php echo e(trans('lang.job_id')); ?> <?php echo e($job->code); ?></span></li>

                                                    <?php if(!empty($save_jobs) && in_array($job->id, $save_jobs)): ?>
                                                        <li style="pointer-events: none;"><a href="javascript:void(0);" class="wt-clicklike wt-clicksave">
                                                            <i class="fa fa-heart"></i> <?php echo e(trans("lang.saved")); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="javascrip:void(0);" class="wt-clicklike" id="job-<?php echo e($job->id); ?>" @click.prevent="add_wishlist('job-<?php echo e($job->id); ?>', <?php echo e($job->id); ?>, 'saved_jobs', '<?php echo e(trans("lang.saved")); ?>')" v-cloak>
                                                                <i class="fa fa-heart"></i>
                                                                <span class="save_text">Click to Save</span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li class="wt-btnarea"><a href="<?php echo e(url('job/'.$job->slug)); ?>" class="wt-btn"><?php echo e(trans('lang.view_job')); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if( method_exists($jobs,'links') ): ?>
                                    <?php echo e($jobs->links('pagination.custom')); ?>

                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.master', ['body_class' => 'wt-innerbgcolor'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>