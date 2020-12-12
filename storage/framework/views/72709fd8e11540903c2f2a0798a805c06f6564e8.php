<?php if(auth()->guard()->check()): ?>
    <div id="wt-sidebarwrapper" class="wt-sidebarwrapper">
        <div id="wt-btnmenutoggle" class="wt-btnmenutoggle">
            <span class="menu-icon">
                <em></em>
                <em></em>
                <em></em>
            </span>
        </div>
        <?php
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            $profile = \App\User::find($user->id)->profile;
            $setting = \App\SiteManagement::getMetaValue('footer_settings');
            $copyright = !empty($setting) ? $setting['copyright'] : 'Worketic All Rights Reserved';
        ?>
        <div id="wt-verticalscrollbar" class="wt-verticalscrollbar">
            <div class="wt-companysdetails wt-usersidebar">
                <figure class="wt-companysimg">
                    <img src="<?php echo e(asset(Helper::getUserProfileBanner($user->id, 'small'))); ?>" alt="<?php echo e(trans('lang.profile_banner')); ?>">
                </figure>
                <div class="wt-companysinfo">
                    <figure><img src="<?php echo e(asset(Helper::getProfileImage($user->id))); ?>" alt="<?php echo e(trans('lang.profile_photo')); ?>"></figure>
                    <div class="wt-title">
                        <h2>
                            <a href="<?php echo e($role != 'admin' ? url($role.'/dashboard') : 'javascript:void()'); ?>">
                                <?php echo e(!empty(Auth::user()) ? Helper::getUserName(Auth::user()->id) : 'No Name'); ?>

                            </a>
                        </h2>
                        <span><?php echo e(!empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 26, '') : Auth::user()->getRoleNames()->first()); ?></span>
                    </div>
                    <?php if($role === 'employer'): ?>
                        <div class="wt-btnarea"><a href="<?php echo e(url(route('employerPostJob'))); ?>" class="wt-btn"><?php echo e(trans('lang.post_job')); ?></a></div>
                    <?php elseif($role === 'freelancer'): ?>
                        <div class="wt-btnarea"><a href="<?php echo e(url(route('showUserProfile', ['slug' => Auth::user()->slug]))); ?>" class="wt-btn"><?php echo e(trans('lang.view_profile')); ?></a></div>
                    <?php endif; ?>
                </div>
            </div>
            <nav id="wt-navdashboard" class="wt-navdashboard">
                <ul>
                    <?php if($role === 'admin'): ?>
                        <li>
                            <a href="<?php echo e(route('allJobs')); ?>">
                                <i class="ti-briefcase"></i>
                                <span><?php echo e(trans('lang.all_jobs')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('reviewOptions')); ?>">
                                <i class="ti-check-box"></i>
                                <span><?php echo e(trans('lang.review_options')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('userListing')); ?>">
                                <i class="ti-user"></i>
                                <span><?php echo e(trans('lang.manage_users')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('emailTemplates')); ?>">
                                <i class="ti-email"></i>
                                <span><?php echo e(trans('lang.email_templates')); ?></span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span><?php echo e(trans('lang.pages')); ?></span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="<?php echo e(route('pages')); ?>"><?php echo e(trans('lang.all_pages')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('createPage')); ?>"><?php echo e(trans('lang.add_pages')); ?></a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo e(route('createPackage')); ?>">
                                <i class="ti-package"></i>
                                <span><?php echo e(trans('lang.packages')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('adminPayouts')); ?>">
                                <i class="ti-money"></i>
                                <span><?php echo e(trans('lang.payouts')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('homePageSettings')); ?>">
                                <i class="ti-home"></i>
                                <span><?php echo e(trans('lang.home_page_settings')); ?></span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span><?php echo e(trans('lang.settings')); ?></span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="<?php echo e(route('adminProfile')); ?>"><?php echo e(trans('lang.profile_settings')); ?></a></li>
                                <li><hr><a href="<?php echo e(url('admin/settings/#wt-general')); ?>"><?php echo e(trans('lang.general_settings')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('resetPassword')); ?>"><?php echo e(trans('lang.acc_settings')); ?></a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span><?php echo e(trans('lang.cats')); ?></span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="<?php echo e(route('skills')); ?>"><?php echo e(trans('lang.skills')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('categories')); ?>"><?php echo e(trans('lang.job_cats')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('departments')); ?>"><?php echo e(trans('lang.dpts')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('languages')); ?>"><?php echo e(trans('lang.langs')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('locations')); ?>"><?php echo e(trans('lang.locations')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('badges')); ?>"><?php echo e(trans('lang.badges')); ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if($role === 'employer' || $role === 'freelancer' ): ?>
                        <li>
                            <a href="<?php echo e(url($role.'/dashboard')); ?>">
                                <i class="ti-desktop"></i>
                                <span><?php echo e(trans('lang.dashboard')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('message')); ?>">
                                <i class="ti-envelope"></i>
                                <span><?php echo e(trans('lang.msg_center')); ?></span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span><?php echo e(trans('lang.settings')); ?></span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="<?php echo e(url($role.'/profile')); ?>"><?php echo e(trans('lang.profile_settings')); ?></a></li>
                                <li><hr><a href="<?php echo e(route('manageAccount')); ?>"><?php echo e(trans('lang.acc_settings')); ?></a></li>
                            </ul>
                        </li>
                        <?php if($role === 'employer'): ?>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-announcement"></i>
                                    <span><?php echo e(trans('lang.jobs')); ?></span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="<?php echo e(route('employerManageJobs')); ?>"><?php echo e(trans('lang.manage_job')); ?></a></li>
                                    <li><hr><a href="<?php echo e(url('employer/jobs/completed')); ?>"><?php echo e(trans('lang.completed_jobs')); ?></a></li>
                                    <li><hr><a href="<?php echo e(url('employer/jobs/hired')); ?>"><?php echo e(trans('lang.ongoing_jobs')); ?></a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span><?php echo e(trans('lang.invoices')); ?></span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="<?php echo e(url('employer/package/invoice')); ?>"><?php echo e(trans('lang.pkg_inv')); ?></a></li>
                                    <li><hr><a href="<?php echo e(url('employer/project/invoice')); ?>"><?php echo e(trans('lang.project_inv')); ?></a></li>
                                </ul>
                            </li>
                        <?php elseif($role === 'freelancer'): ?>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-briefcase"></i>
                                    <span><?php echo e(trans('lang.all_projects')); ?></span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="<?php echo e(url('freelancer/jobs/completed')); ?>"><?php echo e(trans('lang.completed_projects')); ?></a></li>
                                    <li><hr><a href="<?php echo e(url('freelancer/jobs/cancelled')); ?>"><?php echo e(trans('lang.cancelled_projects')); ?></a></li>
                                    <li><hr><a href="<?php echo e(url('freelancer/jobs/hired')); ?>"><?php echo e(trans('lang.ongoing_projects')); ?></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo e(route('showFreelancerProposals')); ?>">
                                    <i class="ti-bookmark-alt"></i>
                                    <span> <?php echo e(trans('lang.proposals')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('getFreelancerPayouts')); ?>">
                                    <i class="ti-money"></i>
                                    <span> <?php echo e(trans('lang.payouts')); ?></span>
                                </a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span><?php echo e(trans('lang.invoices')); ?></span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="<?php echo e(url('freelancer/package/invoice')); ?>"><?php echo e(trans('lang.pkg_inv')); ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(url('dashboard/packages/'.$role)); ?>">
                                <i class="ti-package"></i>
                                <span><?php echo e(trans('lang.packages')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url($role.'/saved-items')); ?>">
                                <i class="ti-heart"></i>
                                <span><?php echo e(trans('lang.saved_items')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                            <i class="lnr lnr-exit"></i><?php echo e(trans('lang.logout')); ?>

                        </a>
                        <form id="dashboard-logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </nav>
            <div class="wt-navdashboard-footer">
                <span>Copyright © 2020 Team xTmos, All Right Reserved RisfBD</span>
            </div>
        </div>
    </div>
<?php endif; ?>
