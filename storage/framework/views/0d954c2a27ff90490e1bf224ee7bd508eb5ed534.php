<?php $__env->startSection('content'); ?>
    <div class="wt-haslayout wt-innerbannerholder wt-innerbannerholdervtwo" style="background-image: url(<?php echo e(asset($banner)); ?>);">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                </div>
            </div>
        </div>
    </div>
    <div class="wt-main-section wt-paddingtopnull wt-haslayout la-profile-holder" id="user_profile">
        <?php if(Auth::user()): ?>
            <?php if($profile->user_id != Auth::user()->id): ?>
                <chat :trans_image_alt="'<?php echo e(trans('lang.img')); ?>'" :ph_new_msg="'<?php echo e(trans('lang.ph_new_msg')); ?>'" :trans_placeholder="'<?php echo e(trans('lang.ph_type_msg')); ?>'" :receiver_id="'<?php echo e($profile->user_id); ?>'" :receiver_profile_image="'<?php echo e(asset($avatar)); ?>'"></chat>
            <?php endif; ?>
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                    <div class="wt-userprofileholder">
                        <?php if(!empty($badge)): ?>
                            <span class="wt-featuredtag" style="border-top: 40px solid <?php echo e($badge_color); ?>;">
                                <img src="<?php echo e(asset(Helper::getBadgeImage($badge_img))); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style">
                            </span>
                        <?php endif; ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 float-left">
                            <div class="row">
                                <div class="wt-userprofile">
                                    <?php if(!empty($avatar)): ?>
                                        <figure><img src="<?php echo e(asset($avatar)); ?>" alt="<?php echo e(trans('lang.user_avatar')); ?>"></figure>
                                    <?php endif; ?>
                                    <div class="wt-title">
                                        <?php if(!empty($user_name)): ?>
                                            <h3><?php if($user->user_verified === 1): ?><i class="fa fa-check-circle"></i> <?php endif; ?> <?php echo e($user_name); ?></h3>
                                        <?php endif; ?>
                                        <span>
                                            <div class="wt-proposalfeedback"><span class="wt-starcontent"> <?php echo e($rating); ?>/<i>5</i>&nbsp;<em>(<?php echo e($reviews->count()); ?> <?php echo e(trans('lang.feedbacks')); ?>)</em></span></div>
                                            <?php if(!empty($joining_date)): ?>
                                                <?php echo e(trans('lang.member_since')); ?>&nbsp;<?php echo e($joining_date); ?>

                                            <?php endif; ?>
                                            <br>
                                            <a href="<?php echo e(url('profile/'.$user->slug)); ?>"><?php echo e('@'); ?><?php echo e($user->slug); ?></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 float-left">
                            <div class="row">
                                <div class="wt-proposalhead wt-userdetails">
                                    <?php if(!empty($profile->tagline)): ?>
                                        <h2><?php echo e($profile->tagline); ?></h2>
                                    <?php endif; ?>
                                    <ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
                                        <?php if(!empty($profile->hourly_rate)): ?>
                                            <li><span><i class="far fa-money-bill-alt"></i> $<?php echo e($profile->hourly_rate); ?> <?php echo e(trans('lang.per_hour')); ?></span></li>
                                        <?php endif; ?>
                                        <?php if(!empty($user->location->title)): ?>
                                            <li>
                                                <span>
                                                    <img src="<?php echo e(asset(Helper::getLocationFlag($user->location->flag))); ?>" alt="<?php echo e(trans('lang.flag_img')); ?>"> <?php echo e($user->location->title); ?>

                                                </span>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(in_array($profile->id, $save_freelancer)): ?>
                                            <li class="wt-btndisbaled">
                                                <a href="javascrip:void(0);" class="wt-clicksave wt-clicksave">
                                                    <i class="fa fa-heart"></i>
                                                    <?php echo e(trans('lang.btn_save')); ?>

                                                </a>
                                            </li>
                                            <?php else: ?>
                                            <li v-bind:class="disable_btn" v-cloak>
                                                <a href="javascrip:void(0);" v-bind:class="click_to_save" id="freelancer-<?php echo e($profile->id); ?>" @click.prevent="add_wishlist(freelancer-<?php echo e($profile->id); ?>, <?php echo e($profile->id); ?>, 'saved_freelancer', '<?php echo e(trans("lang.saved")); ?>')" v-cloak>
                                                    <i v-bind:class="saved_class"></i>
                                                    {{ text }}
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                    <?php if(!empty($profile->description)): ?>
                                        <div class="wt-description">
                                            <p><?php echo e($profile->description); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div id="wt-statistics" class="wt-statistics wt-profilecounter">
                                    <div class="wt-statisticcontent wt-countercolor1">
                                        <h3 data-from="0" data-to="<?php echo e(Helper::getProposals($user->id, 'hired')->count()); ?>" data-speed="800" data-refresh-interval="03"><?php echo e(Helper::getProposals($user->id, 'hired')->count()); ?></h3>
                                        <h4><?php echo e(trans('lang.ongoing_project')); ?></h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor2">
                                        <h3 data-from="0" data-to="<?php echo e(Helper::getProposals($user->id, 'completed')->count()); ?>" data-speed="8000" data-refresh-interval="100"><?php echo e(Helper::getProposals($user->id, 'completed')->count()); ?></h3>
                                        <h4><?php echo e(trans('lang.completed_projects')); ?></h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor4">
                                        <h3 data-from="0" data-to="<?php echo e(Helper::getProposals($user->id, 'cancelled')->count()); ?>" data-speed="800" data-refresh-interval="02"><?php echo e(Helper::getProposals($user->id, 'cancelled')->count()); ?></h3>
                                        <h4><?php echo e(trans('lang.cancelled_projects')); ?></h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor3">
                                        <h3 data-from="0" data-to="<?php echo e($amount); ?>" data-speed="8000" data-refresh-interval="100"><?php echo e(empty($amount) ? $currency_symbol.'0.00' : $amount); ?></h3>
                                        <h4><?php echo e(trans('lang.total_earnings')); ?></h4>
                                    </div>
                                    <div class="wt-description">
                                        <p><?php echo e(trans('lang.send_offer_note')); ?></p>
                                        <a href="javascript:void(0);" @click.prevent='sendOffer("<?php echo e($auth_user); ?>")' class="wt-btn"><?php echo e(trans('lang.btn_send_offer')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-left">
                        <div class="wt-usersingle">
                            <div class="wt-clientfeedback la-no-record">
                                <div class="wt-usertitle wt-titlewithselect">
                                    <h2><?php echo e(trans('lang.client_feedback')); ?></h2>
                                </div>
                                <?php if(!empty($reviews) && $reviews->count() > 0): ?>
                                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $job = \App\Job::where('id', $review->job_id)->first();
                                            $verified_user = \App\User::select('user_verified')->where('id', $review->user_id)->pluck('user_verified')->first();
                                        ?>
                                        <div class="wt-userlistinghold wt-userlistingsingle">
                                            <figure class="wt-userlistingimg">
                                                <img src="<?php echo e(asset(Helper::getProfileImage($review->user_id))); ?>" alt="<?php echo e(trans('Employer')); ?>">
                                            </figure>
                                            <div class="wt-userlistingcontent">
                                                <div class="wt-contenthead">
                                                    <div class="wt-title">
                                                        <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>"><?php if($verified_user === 1): ?><i class="fa fa-check-circle"></i><?php endif; ?> <?php echo e(Helper::getUserName($review->user_id)); ?></a>
                                                        <h3><?php echo e($job->title); ?></h3>
                                                    </div>
                                                    <ul class="wt-userlisting-breadcrumb">
                                                        <li><span><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i> <?php echo e(\App\Helper::getProjectLevel($job->project_level)); ?></span></li>
                                                        <li>
                                                            <span>
                                                                <img src="<?php echo e(asset(App\Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.flag_img')); ?>"> <?php echo e($job->location->title); ?>

                                                            </span>
                                                        </li>
                                                        <li><span><i class="far fa-calendar"></i> <?php echo e(Carbon\Carbon::parse($job->created_at)->format('M Y')); ?> - <?php echo e(Carbon\Carbon::parse($job->updated_at)->format('M Y')); ?></span></li>
                                                        <li>
                                                            <vue-stars
                                                            :name="'rating[<?php echo e($key); ?>][rate]'"
                                                            :active-color="'#fecb02'"
                                                            :inactive-color="'#999999'"
                                                            :shadow-color="'#ffff00'"
                                                            :hover-color="'#fecb02'"
                                                            :max="5"
                                                            :value="<?php echo e($review->avg_rating); ?>"
                                                            :readonly="true"
                                                            :char="'★'"
                                                            id="rating-<?php echo e($key); ?>"
                                                            />
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="wt-description">
                                                <?php if(!empty($review->feedback)): ?>
                                                    <p>“ <?php echo e($review->feedback); ?> ”</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="wt-userprofile">
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="wt-craftedprojects">
                                <div class="wt-usertitle">
                                    <h2><?php echo e(trans('lang.crafted_projects')); ?></h2>
                                </div>
                                <?php if(!empty($projects)): ?>
                                    <crafted_project :no_of_post="3" :project="'<?php echo e(json_encode($projects)); ?>'" :freelancer_id="'<?php echo e($profile->user_id); ?>'" :img="'<?php echo e(trans('lang.img')); ?>'"></crafted_project>
                                <?php else: ?>
                                    <div class="wt-userprofile">
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="wt-experience">
                                <div class="wt-usertitle">
                                    <h2><?php echo e(trans('lang.experience')); ?></h2>
                                </div>
                                <?php if(!empty($experiences)): ?>
                                    <div class="wt-experiencelisting-hold">
                                        <experience :freelancer_id="'<?php echo e($profile->user_id); ?>'" :no_of_post="2"></experience>
                                    </div>
                                <?php else: ?>
                                    <div class="wt-userprofile">
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="wt-experience wt-education">
                                <div class="wt-usertitle">
                                    <h2><?php echo e(trans('lang.education')); ?></h2>
                                </div>
                                <?php if(!empty($education)): ?>
                                    <education :freelancer_id="'<?php echo e($profile->user_id); ?>'" :no_of_post="1"></education>
                                <?php else: ?>
                                    <div class="wt-userprofile">
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                        <aside id="wt-sidebar" class="wt-sidebar">
                            <div id="wt-ourskill" class="wt-widget">
                                <div class="wt-widgettitle">
                                    <h2><?php echo e(trans('lang.my_skills')); ?></h2>
                                </div>
                                <?php if(!empty($skills) && $skills->count() > 0): ?>
                                    <div class="wt-widgetcontent wt-skillscontent">
                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="wt-skillholder" data-percent="<?php echo e($skill->pivot->skill_rating); ?>%">
                                                <span><?php echo e($skill->title); ?> <em><?php echo e($skill->pivot->skill_rating); ?>%</em></span>
                                                <div class="wt-skillbarholder"><div class="wt-skillbar"></div></div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <p><?php echo e(trans('lang.no_skills')); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if(!empty($awards)): ?>
                                <div class="wt-widget wt-widgetarticlesholder wt-articlesuser">
                                    <div class="wt-widgettitle">
                                        <h2><?php echo e(trans('lang.awards_certifications')); ?></h2>
                                    </div>
                                    <div class="wt-widgetcontent wt-verticalscrollbar">
                                        <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="wt-particlehold">
                                                <?php if(!empty($award['award_hidden_image'])): ?>
                                                    <figure>
                                                        <img src="<?php echo e(asset('uploads/users/'.$profile->user_id.'/awards/'.$award['award_hidden_image'])); ?>" alt="<?php echo e(trans('lang.img')); ?>">
                                                    </figure>
                                                <?php endif; ?>
                                                <?php if(!empty($award['award_title'])): ?>
                                                    <div class="wt-particlecontent">
                                                        <h3><a href="javascrip:void(0);"><?php echo e($award['award_title']); ?></a></h3>
                                                        <span><i class="lnr lnr-calendar"></i> <?php echo e($joining_date); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="wt-proposalsr">
                               
                               <!--
                                <div class="tg-authorcodescan tg-authorcodescanvtwo">
                                    <figure class="tg-qrcodeimg">
                                        <?php echo QrCode::size(100)->generate(Request::url('profile/'.$user->slug));; ?>

                                    </figure>
                                    <div class="tg-qrcodedetail">
                                        <span class="lnr lnr-laptop-phone"></span>
                                        <div class="tg-qrcodefeat">
                                            <h3><?php echo e(trans('lang.scan_with_smartphone')); ?> <span><?php echo e(trans('lang.smartphone')); ?> </span> <?php echo e(trans('lang.get_handy')); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                
                                -->
                            </div>
                            <div class="wt-widget wt-sharejob">
                                <div class="wt-widgettitle">
                                    <h2><?php echo e(trans('lang.share_freelancer')); ?></h2>
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
                                    <h2><?php echo e(trans('lang.report_user')); ?></h2>
                                </div>
                                <div class="wt-widgetcontent">
                                    <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-formreport', 'id' => 'submit-report',  '@submit.prevent'=>'submitReport("'.$profile->user_id.'","freelancer-report")']); ?>

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
                </div>
            </div>
        </div>
		<b-modal ref="myModalRef" hide-footer title="Project Status">
            <div class="d-block text-center">
                <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'send-offer-form', '@submit.prevent'=>'submitProjectOffer("'.$profile->user_id.'")']); ?>

                    <div class="wt-projectdropdown-hold">
                        <div class="wt-projectdropdown">
                            <span class="wt-select">
                                <?php echo e(Form::select('offer[project]', $employer_projects, null, array('class' => 'form-control', 'placeholder' => trans('lang.ph_select_projects')))); ?>

                            </span>
                        </div>
                    </div>
                    <div class="wt-formtheme wt-formpopup">
                        <fieldset>
                            <div class="form-group">
                                <?php echo e(Form::textarea('offer[desc]', null, array('placeholder' => trans('lang.ph_add_desc')))); ?>

                            </div>
                            <div class="form-group wt-btnarea">
                                <?php echo Form::submit(trans('lang.btn_send_offer'), ['class' => 'wt-btn']); ?>

                            </div>
                        </fieldset>
                    </div>
                <?php echo Form::close(); ?>

            </div>
        </b-modal>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front-end.master', ['body_class' => 'wt-innerbgcolor'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>