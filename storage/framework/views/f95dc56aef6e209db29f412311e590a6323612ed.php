
<?php $__env->startSection('content'); ?>
	<div class="wt-haslayout wt-dbsectionspace la-manage-jobs-holder">
		<div class="manage-jobs float-left">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="wt-dashboardbox">
						<div class="wt-dashboardboxtitle">
							<h2><?php echo e(trans('lang.manage_job')); ?></h2>
						</div>
						<div class="wt-dashboardboxcontent wt-jobdetailsholder">
							<?php if(!empty($job_details) && $job_details->count() > 0): ?>
								<div class="wt-freelancerholder">
									<div class="wt-tabscontenttitle">
										<h2><?php echo e(trans('lang.posted_jobs')); ?></h2>
									</div>
									<div class="wt-managejobcontent">
										<?php $__currentLoopData = $job_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php 
												$image = '';
												$duration  =  \App\Helper::getJobDurationList($job->duration);
												$user_name = $job->employer->first_name.' '.$job->employer->last_name;
												$proposals = \App\Proposal::where('job_id', $job->id)->where('status', '!=', 'cancelled')->get();
												$employer_img = \App\Profile::select('avater')->where('user_id', $job->employer->id)->first();										
												$image = !empty($employer_img->avater) ? '/uploads/users/'.$job->employer->id.'/'.$employer_img->avater : '';
												$verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
											?>
											<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
												<?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
													<span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
												<?php endif; ?>
												<div class="wt-userlistingcontent">
													<div class="wt-contenthead">
														<?php if(!empty($user_name) || !empty($job->title) ): ?>
															<div class="wt-title">
																<?php if(!empty($user_name)): ?>
																	<a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
																	<?php if($verified_user === 1): ?>
																		<i class="fa fa-check-circle"></i>&nbsp;
																	<?php endif; ?>
																	<?php echo e($user_name); ?></a>
																<?php endif; ?>
																<?php if(!empty($job->title)): ?>
																	<h2><?php echo e($job->title); ?></h2>
																<?php endif; ?>
															</div>
														<?php endif; ?>
														<?php if(!empty($job->price) || 
															!empty($job->location->title)  ||
															!empty($job->project_type) ||
															!empty($job->duration)
															): ?>
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
														<?php endif; ?>
													</div>
													<div class="wt-rightarea">
														<div class="wt-btnarea">
															<a href="<?php echo e(url('job/'.$job->slug)); ?>" class="wt-btn"><?php echo e(trans('lang.view_detail')); ?></a>
															<a href="<?php echo e(url('job/edit-job/'.$job->slug)); ?>" class="wt-btn"><?php echo e(trans('lang.edit_job')); ?></a>
															<?php if($proposals->count() > 0): ?>
																<a href="<?php echo e(url('employer/dashboard/job/'.$job->slug.'/proposals')); ?>" class="wt-btn"><?php echo e(trans('lang.view_proposals')); ?></a>
															<?php endif; ?>
														</div>
														<div class="wt-hireduserstatus">
															<h4><?php echo e($proposals->count()); ?></h4><span>Proposals</span>
															<?php if($proposals->count() > 0): ?>
																<ul class="wt-hireduserimgs">
																	<?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																		<?php
																			$profile = \App\User::find($proposal->freelancer_id)->profile;
																			$user_image = !empty($profile) ? $profile->avater : '';
																			$profile_image = !empty($user_image) ? '/uploads/users/'.$proposal->freelancer_id.'/'.$user_image : 'images/user-login.png';
																		?>
																		<li><figure><img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded"></figure></li>
																	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																</ul>
															<?php endif; ?>
														</div>
													</div>
												</div>	
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
								<?php if(method_exists($job_details,'links')): ?>
									<?php echo e($job_details->links('pagination.custom')); ?>

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

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>