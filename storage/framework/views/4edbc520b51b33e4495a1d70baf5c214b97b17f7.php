
<?php $__env->startSection('content'); ?>
<div class="wt-haslayout wt-dbsectionspace">
    <div class="manage-proposals float-left">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="jobs">
                <?php if(Session::has('error')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
                    </div>
                <?php endif; ?> 
				<div class="wt-dashboardbox">
					<div class="wt-dashboardboxtitle">
						<h2><?php echo e(trans('lang.job_proposals')); ?></h2>
                    </div>
                    <?php if(!empty($proposals)): ?>
                        <?php
                            $user = \App\User::find($job->user_id);
                            $user_name = $user->first_name.' '.$user->last_name;
                            $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
                            $count = 0;
                            $received_proposal_count = 0;
                            $feature_class = !empty($job->is_featured) ? 'wt-featured' : '';
                        ?>
                        <div class="wt-dashboardboxcontent wt-rcvproposala">
                            <div class="wt-userlistinghold wt-userlistingvtwo <?php echo e($feature_class); ?>">
                                <?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
                                    <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                <?php endif; ?>
                                <div class="wt-userlistingcontent">
                                    <div class="wt-contenthead">
                                        <?php if(!empty($user_name) || !empty($job->title) ): ?>
                                            <div class="wt-title">
                                                <?php if(!empty($user_name)): ?>
                                                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>"><?php if($verified_user === 1): ?><i class="fa fa-check-circle"></i><?php endif; ?>&nbsp;<?php echo e($user_name); ?></a>
                                                <?php endif; ?>
                                                <?php if(!empty($job->title)): ?>
                                                    <h2><?php echo e($job->title); ?></h2>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(!empty($job->professional_level) ||
                                            !empty($location['title'])  ||
                                            !empty($job->price) ||
                                            !empty($job->duration)
                                            ): ?>
                                            <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                <?php if(!empty($job->price)): ?>
                                                    <li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> <?php echo e($job->price); ?></span></li>
                                                <?php endif; ?>
                                                <?php if(!empty($job->location->title)): ?>
                                                    <li><span><img src="<?php echo e(asset(App\Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.img')); ?>"> <?php echo e($job->location->title); ?></span></li>
                                                <?php endif; ?>
                                                <?php if(!empty($job->project_type)): ?>
                                                    <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> <?php echo e(trans('lang.type')); ?> <?php echo e($job->project_type); ?></a></li>
                                                <?php endif; ?>
                                                <?php if(!empty($job->duration)): ?>
                                                    <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> <?php echo e(trans('lang.duration')); ?> <?php echo e($duration); ?></span></li>
                                                <?php endif; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="wt-rightarea">
                                        <div class="wt-hireduserstatus">
                                            <h4><?php echo e($proposals->count()); ?></h4><span><?php echo e(trans('lang.proposals')); ?></span>
                                            <?php if($proposals->count() > 0): ?>
                                                <ul class="wt-hireduserimgs">
                                                    <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $profile = \App\User::find($proposal->freelancer_id)->profile;
                                                            $user_image = !empty($profile) ? $profile->avater : '';
                                                            $profile_image = !empty($user_image) ? '/uploads/users/'.$proposal->freelancer_id.'/'.$user_image : 'images/user-login.png';
                                                        ?>
                                                        <li><figure><img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.img')); ?>" class="mCS_img_loaded"></figure></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($accepted_proposal)): ?>
                                <div class="wt-freelancerholder wt-rcvproposalholder">
                                <div class="wt-tabscontenttitle">
                                    <h2><?php echo e(trans('lang.hired_freelancers')); ?></h2>
                                </div>
                                <div class="wt-managejobcontent">
                                    <?php
                                        $user = \App\User::find($accepted_proposal->freelancer_id);
                                        $profile = \App\User::find($accepted_proposal->freelancer_id)->profile;
                                        $user_image = !empty($profile) ? $profile->avater : '';
                                        $profile_image = !empty($user_image) ? '/uploads/users/'.$accepted_proposal->freelancer_id.'/'.$user_image : 'images/user-login.png';
                                        $user_name = Helper::getUserName($user->id);
                                        $rating = !empty($profile->rating) ? $profile->rating : 'Not Rated Yet';
                                        $completion_time = !empty($accepted_proposal->completion_time) ? \App\Helper::getJobDurationList($accepted_proposal->completion_time) : '';
                                        $p_attachments = !empty($accepted_proposal->attachments) ? unserialize($accepted_proposal->attachments) : '';
                                        $feedbacks = \App\Review::select('feedback')->where('receiver_id', $user->id)->count();
                                        $badge = Helper::getUserBadge($user->id);
                                        $feature_class = !empty($badge) ? 'wt-featured' : '';
                                        $badge_color = !empty($badge) ? $badge->color : '';
                                        $badge_img  = !empty($badge) ? $badge->image : '';
                                        ?>
                                        <div class="wt-userlistinghold wt-proposalitem <?php echo e($feature_class); ?>">
                                            <?php if(!empty($badge)): ?>
                                                <span class="wt-featuredtag" style="border-top: 40px solid <?php echo e($badge_color); ?>;">
                                                    <img src="<?php echo e(asset(Helper::getBadgeImage($badge_img))); ?>" alt="<?php echo e(trans('lang.hired_freelancers')); ?>" data-tipso="Plus Member" class="template-content tipso_style">
                                                </span>
                                            <?php endif; ?>
                                            <figure class="wt-userlistingimg">
                                                <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded">
                                            </figure>
                                            <div class="wt-proposaldetails">
                                                <?php if(!empty($user_name)): ?>
                                                    <div class="wt-contenthead">
                                                        <div class="wt-title">
                                                            <a href="<?php echo e(url('profile/'.$user->slug)); ?>"><?php echo e($user_name); ?></a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="wt-proposalfeedback">
                                                    <span class="wt-starcontent"><?php echo e($rating); ?>&nbsp;<em> (<?php echo e($feedbacks); ?> <?php echo e(trans('lang.feedbacks')); ?>)</em></span>
                                                </div>
                                            </div>
                                            <div class="wt-rightarea">
                                                <div class="wt-btnarea">
                                                    <a href="javascript:void(0);" class="wt-btn" style="pointer-events:none;"><?php echo e(trans('lang.hired')); ?></a>
                                                    <a href="<?php echo e(url('proposal/'.$job->slug.'/'.$job->status)); ?>"  class="wt-btn"><?php echo e(trans('lang.view_detail')); ?></a>
                                                </div>
                                                <div class="wt-hireduserstatus">
                                                    <h5>&#36;<?php echo e($accepted_proposal->amount); ?></h5>
                                                    <?php if(!empty($completion_time)): ?>
                                                        <span><?php echo e($completion_time); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="wt-hireduserstatus">
                                                    <i class="far fa-envelope"></i>
                                                    <a href="javascript:void(0);" v-on:click.prevent="showCoverLetter('<?php echo e($accepted_proposal->id); ?>')" ><span><?php echo e(trans('lang.cover_letter')); ?></span></a>
                                                </div>
                                                <div class="wt-hireduserstatus">
                                                    <i class="fa fa-paperclip"></i>
                                                    <?php if(!empty($p_attachments)): ?>
                                                        <?php echo Form::open(['url' => url('proposal/download-attachments'), 'class' =>'post-job-form wt-haslayout', 'id' => 'accepted-download-attachments-form-'.$accepted_proposal->id]); ?>

                                                            <?php $__currentLoopData = $p_attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(Storage::disk('local')->exists('uploads/proposals/'.$accepted_proposal->freelancer_id.'/'.$attachments)): ?>
                                                                    <?php echo Form::hidden('attachments['.$count.']', $attachments, []); ?>

                                                                    <?php $count++; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo Form::hidden('freelancer_id', $accepted_proposal->freelancer_id, []); ?>

                                                        <?php echo form::close();; ?>

                                                        <a href="javascript:void(0);"  v-on:click.prevent="downloadAttachments('<?php echo e('accepted-download-attachments-form-'.$accepted_proposal->id); ?>')" ><span><?php echo e($count); ?> <?php echo e(trans('lang.files_attached')); ?></span></a>
                                                    <?php else: ?> 
                                                        <span><?php echo e($count); ?> <?php echo e(trans('lang.files_attached')); ?></span>  
                                                    <?php endif; ?>                                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <b-modal ref="myModalRef-<?php echo e($accepted_proposal->id); ?>" hide-footer title="Cover Letter" v-cloak>
                                    <div class="d-block text-center">
                                            <?php echo e($accepted_proposal->content); ?>

                                        </div>
                                </b-modal>
                            <?php endif; ?>
                            <div class="wt-freelancerholder wt-rcvproposalholder">
                                    <div class="wt-tabscontenttitle">
                                        <h2><?php echo e(trans('lang.received_proposals')); ?></h2>
                                    </div>
                                    <?php if(!empty($proposals)): ?>
                                        <div class="wt-managejobcontent">
                                            <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $user = \App\User::find($proposal->freelancer_id);
                                                    $profile = \App\User::find($proposal->freelancer_id)->profile;
                                                    $user_image = !empty($profile) ? $profile->avater : '';
                                                    $profile_image = !empty($user_image) ? '/uploads/users/'.$proposal->freelancer_id.'/'.$user_image : 'images/user-login.png';
                                                    $user_name = $user->first_name.' '.$user->last_name;
                                                    $rating = !empty($profile->rating) ? $profile->rating : 'Not Rated Yet';
                                                    $completion_time = !empty($proposal->completion_time) ? \App\Helper::getJobDurationList($proposal->completion_time) : '';
                                                    $attachments = !empty($proposal->attachments) ? unserialize($proposal->attachments) : '';
                                                    $attachments_count = 0;
                                                    if (!empty($attachments)){
                                                        $attachments_count = count($attachments);
                                                    }
                                                    $reviews = \App\Review::where('receiver_id', $user->id)->count();
                                                    $badge = Helper::getUserBadge($user->id);
                                                    $feature_class = !empty($badge) ? 'wt-featured' : '';
                                                    $badge_color = !empty($badge) ? $badge->color : '';
                                                    $badge_img  = !empty($badge) ? $badge->image : '';
                                                ?>
                                                <div class="wt-userlistinghold wt-proposalitem <?php echo e($feature_class); ?>">
                                                    <?php if(!empty($badge)): ?>
                                                        <span class="wt-featuredtag" style="border-top: 40px solid <?php echo e($badge_color); ?>;">
                                                            <img src="<?php echo e(asset(Helper::getBadgeImage($badge_img))); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style">
                                                        </span> 
                                                    <?php endif; ?>
                                                    <figure class="wt-userlistingimg">
                                                        <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded">
                                                    </figure>
                                                    <div class="wt-proposaldetails">
                                                        <?php if(!empty($user_name)): ?>
                                                            <div class="wt-contenthead">
                                                                <div class="wt-title">
                                                                    <a href="<?php echo e(url('profile/'.$user->slug)); ?>"><?php echo e($user_name); ?></a>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="wt-proposalfeedback">
                                                            <span class="wt-starcontent"><?php echo e($rating); ?>&nbsp;<em> (<?php echo e($reviews); ?> <?php echo e(trans('lang.feedbacks')); ?>)</em></span>
                                                        </div>
                                                    </div>
                                                    <div class="wt-rightarea">
                                                        <div class="wt-btnarea">
                                                            <?php if(empty($accepted_proposal)): ?>
                                                                <a href="javascript:void(0);"  v-on:click.prevent="hireFreelancer('<?php echo e($proposal->id); ?>')" class="wt-btn"><?php echo e(trans('lang.hire_now')); ?></a>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="wt-hireduserstatus">
                                                            <h5>&#36;<?php echo e($proposal->amount); ?></h5>
                                                            <?php if(!empty($completion_time)): ?>
                                                                <span><?php echo e($completion_time); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="wt-hireduserstatus">
                                                            <i class="far fa-envelope"></i>
                                                            <a href="javascript:void(0);"  v-on:click.prevent="showCoverLetter('<?php echo e($proposal->id); ?>')" ><span><?php echo e(trans('lang.cover_letter')); ?></span></a>
                                                        </div>
                                                        <div class="wt-hireduserstatus">
                                                            <i class="fa fa-paperclip"></i>
                                                            <?php if(!empty($attachments)): ?>
                                                                <?php echo Form::open(['url' => url('proposal/download-attachments'), 'class' =>'post-job-form wt-haslayout', 'id' => 'download-attachments-form-'.$proposal->id]); ?>

                                                                    <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if(Storage::disk('local')->exists('uploads/proposals/'.$proposal->freelancer_id.'/'.$attachment)): ?>
                                                                            <?php echo Form::hidden('attachments['.$received_proposal_count.']', $attachment, []); ?>

                                                                            <?php $received_proposal_count++; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php echo Form::hidden('freelancer_id', $proposal->freelancer_id, []); ?>

                                                                <?php echo form::close();; ?>

                                                                <a href="javascript:void(0);"  v-on:click.prevent="downloadAttachments('<?php echo e('download-attachments-form-'.$proposal->id); ?>')" ><span><?php echo e($received_proposal_count); ?> <?php echo e(trans('lang.files_attached')); ?></span></a>
                                                            <?php else: ?> 
                                                                <span><?php echo e($attachments_count); ?> <?php echo e(trans('lang.files_attached')); ?></span>  
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                </div>
                                <b-modal ref="myModalRef-<?php echo e($proposal->id); ?>" hide-footer title="Cover Letter" v-cloak>
                                    <div class="d-block text-center">
                                        <?php echo e($proposal->content); ?>

                                    </div>
                                </b-modal>
                            </div>
                            <?php if( method_exists($proposals,'links') ): ?>
                                <?php echo e($proposals->links('pagination.custom')); ?>

                            <?php endif; ?>
                    <?php endif; ?>
				</div>
			</div>
		</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>