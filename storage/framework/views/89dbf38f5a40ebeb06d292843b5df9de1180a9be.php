 
<?php $__env->startSection('content'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('jobDetail',$job->slug); ?>
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                    <div class="wt-title"><h2><?php echo e(trans('lang.job_detail')); ?></h2></div>
                    <?php if(count($breadcrumbs)): ?>
                        <ol class="wt-breadcrumb">
                            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <?php if($breadcrumb->url && !$loop->last): ?>
                                    <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                                <?php else: ?>
                                    <li class="active"><?php echo e($breadcrumb->title); ?></li>
                                <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-haslayout wt-main-section">
        <div class="container">
            <div class="row">
                <div class="job-single wt-haslayout">
                    <div id="jobs" class="wt-twocolumns wt-haslayout">
                        <?php if(Session::has('error')): ?>
                            <div class="flash_msg">
                                <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
                            </div>
                        <?php endif; ?> 
                        <?php if(!empty($job)): ?>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left">
                                <div class="wt-proposalholder">
                                    <?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
                                        <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.img')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                    <?php endif; ?>
                                    <?php if(
                                        !empty($job->professional_level) ||
                                        !empty($job->title) ||
                                        !empty($location['title'])  ||
                                        !empty($job->project_type) ||
                                        !empty($job->duration)
                                        ): ?>
                                        <div class="wt-proposalhead">
                                            <?php if(!empty($job->title)): ?>
                                                <h2><?php echo e($job->title); ?></h2>
                                            <?php endif; ?>
                                            <?php if(
                                                !empty($job->professional_level) ||
                                                !empty($location['title'])  ||
                                                !empty($job->price) ||
                                                !empty($job->duration)
                                                ): ?>
                                                <ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
                                                    <?php if(!empty($job->project_level)): ?>
                                                        <li><span><i class="fa fa-dollar-sign wt-viewjobdollar"></i> <?php echo e(Helper::getProjectLevel($job->project_level)); ?></span></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->location->title)): ?>
                                                        <li><span><img src="<?php echo e(asset(Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.img')); ?>"> <?php echo e($job->location->title); ?></span></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->project_type)): ?>
                                                        <li><span class="wt-clicksavefolder"><i class="far fa-folder wt-viewjobfolder"></i> <?php echo e(trans('lang.type')); ?> <?php echo e($job->project_type); ?></span></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->duration)): ?>
                                                        <li><span class="wt-dashboradclock"><i class="far fa-clock wt-viewjobclock"></i> <?php echo e(trans('lang.duration')); ?> <?php echo e(Helper::getJobDurationList($job->duration)); ?></span></li>															
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->price)): ?>
                                                        <li>
                                                            <span>
                                                                <i class="far fa-money-bill-alt wt-budget"></i> <?php echo e($job->price); ?>

                                                            </span>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="wt-btnarea"><a href="javascript:void(0);" @click.prevent="check_auth('<?php echo e(url('job/proposal/'.$job->slug)); ?>')" class="wt-btn"><?php echo e(trans('lang.send_propsal')); ?></a></div>  
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                                <div class="wt-projectdetail-holder">
                                    <?php if(!empty($job->description)): ?>
                                        <div class="wt-projectdetail">
                                            <div class="wt-title">
                                                <h3><?php echo e(trans('lang.project_detail')); ?></h3>
                                            </div>
                                            <div class="wt-description">
                                                <?php echo htmlspecialchars_decode(stripslashes($job->description)); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($job->skills) && $job->skills->count() > 0): ?>
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3><?php echo e(trans('lang.skills_req')); ?></h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <?php $__currentLoopData = $job->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(url('search-results?type=job&skills%5B%5D='.$skill->id)); ?>"><?php echo e($skill->title); ?></a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($attachments) && $job->show_attachments === 'true'): ?>
                                        <div class="wt-attachments">
                                            <div class="wt-title">
                                                <h3><?php echo e(trans('lang.attachments')); ?></h3>
                                            </div>
                                            <ul class="wt-attachfile">
                                                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <span><?php echo e(Helper::formateFileName($attachment)); ?></span>
                                                        <em>
                                                            <?php if(Storage::disk('local')->exists('uploads/jobs/'.$job->employer->id.'/'.$attachment)): ?>
                                                                <?php echo e(trans('lang.file_size')); ?> <?php echo e(Helper::bytesToHuman(Storage::size('uploads/jobs/'.$job->employer->id.'/'.$attachment))); ?>

                                                            <?php endif; ?>
                                                            <a href="<?php echo e(route('getfile', ['type'=>'jobs','attachment'=>$attachment,'id'=>$job->user_id])); ?>"><i class="lnr lnr-download"></i></a>
                                                        </em>
                                                    </li> 
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
                            <?php echo $__env->make('front-end.jobs.sidebar.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.master', ['body_class' => 'wt-innerbgcolor'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>