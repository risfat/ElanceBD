@auth
    <div id="wt-sidebarwrapper" class="wt-sidebarwrapper">
        <div id="wt-btnmenutoggle" class="wt-btnmenutoggle">
            <span class="menu-icon">
                <em></em>
                <em></em>
                <em></em>
            </span>
        </div>
        @php
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            $profile = \App\User::find($user->id)->profile;
            $setting = \App\SiteManagement::getMetaValue('footer_settings');
            $copyright = !empty($setting) ? $setting['copyright'] : 'Worketic All Rights Reserved';
        @endphp
        <div id="wt-verticalscrollbar" class="wt-verticalscrollbar">
            <div class="wt-companysdetails wt-usersidebar">
                <figure class="wt-companysimg">
                    <img src="{{{ asset(Helper::getUserProfileBanner($user->id, 'small')) }}}" alt="{{{ trans('lang.profile_banner') }}}">
                </figure>
                <div class="wt-companysinfo">
                    <figure><img src="{{{ asset(Helper::getProfileImage($user->id)) }}}" alt="{{{ trans('lang.profile_photo') }}}"></figure>
                    <div class="wt-title">
                        <h2>
                            <a href="{{{ $role != 'admin' ? url($role.'/dashboard') : 'javascript:void()' }}}">
                                {{{ !empty(Auth::user()) ? Helper::getUserName(Auth::user()->id) : 'No Name' }}}
                            </a>
                        </h2>
                        <span>{{{ !empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 26, '') : Auth::user()->getRoleNames()->first() }}}</span>
                    </div>
                    @if ($role === 'employer')
                        <div class="wt-btnarea"><a href="{{{ url(route('employerPostJob')) }}}" class="wt-btn">{{{ trans('lang.post_job') }}}</a></div>
                    @elseif ($role === 'freelancer')
                        <div class="wt-btnarea"><a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                    @endif
                </div>
            </div>
            <nav id="wt-navdashboard" class="wt-navdashboard">
                <ul>
                    @if ($role === 'admin')
                        <li>
                            <a href="{{{ route('allJobs') }}}">
                                <i class="ti-briefcase"></i>
                                <span>{{ trans('lang.all_jobs') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('reviewOptions') }}}">
                                <i class="ti-check-box"></i>
                                <span>{{ trans('lang.review_options') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('userListing') }}}">
                                <i class="ti-user"></i>
                                <span>{{ trans('lang.manage_users') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('emailTemplates') }}}">
                                <i class="ti-email"></i>
                                <span>{{ trans('lang.email_templates') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.pages') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('pages') }}}">{{ trans('lang.all_pages') }}</a></li>
                                <li><hr><a href="{{{ route('createPage') }}}">{{ trans('lang.add_pages') }}</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="{{{ route('createPackage') }}}">
                                <i class="ti-package"></i>
                                <span>{{ trans('lang.packages') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('adminPayouts') }}}">
                                <i class="ti-money"></i>
                                <span>{{ trans('lang.payouts') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('homePageSettings') }}}">
                                <i class="ti-home"></i>
                                <span>{{ trans('lang.home_page_settings') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span>{{ trans('lang.settings') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('adminProfile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                                <li><hr><a href="{{{ url('admin/settings/#wt-general') }}}">{{ trans('lang.general_settings') }}</a></li>
                                <li><hr><a href="{{{ route('resetPassword') }}}">{{ trans('lang.acc_settings') }}</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.cats') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('skills') }}}">{{ trans('lang.skills') }}</a></li>
                                <li><hr><a href="{{{ route('categories') }}}">{{ trans('lang.job_cats') }}</a></li>
                                <li><hr><a href="{{{ route('departments') }}}">{{ trans('lang.dpts') }}</a></li>
                                <li><hr><a href="{{{ route('languages') }}}">{{ trans('lang.langs') }}</a></li>
                                <li><hr><a href="{{{ route('locations') }}}">{{ trans('lang.locations') }}</a></li>
                                <li><hr><a href="{{{ route('badges') }}}">{{ trans('lang.badges') }}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ($role === 'employer' || $role === 'freelancer' )
                        <li>
                            <a href="{{{ url($role.'/dashboard') }}}">
                                <i class="ti-desktop"></i>
                                <span>{{ trans('lang.dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('message') }}}">
                                <i class="ti-envelope"></i>
                                <span>{{ trans('lang.msg_center') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span>{{ trans('lang.settings') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ url($role.'/profile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                                <li><hr><a href="{{{ route('manageAccount') }}}">{{ trans('lang.acc_settings') }}</a></li>
                            </ul>
                        </li>
                        @if ($role === 'employer')
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-announcement"></i>
                                    <span>{{ trans('lang.jobs') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.manage_job') }}</a></li>
                                    <li><hr><a href="{{{ url('employer/jobs/completed') }}}">{{ trans('lang.completed_jobs') }}</a></li>
                                    <li><hr><a href="{{{ url('employer/jobs/hired') }}}">{{ trans('lang.ongoing_jobs') }}</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span>{{ trans('lang.invoices') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('employer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                    <li><hr><a href="{{{ url('employer/project/invoice') }}}">{{ trans('lang.project_inv') }}</a></li>
                                </ul>
                            </li>
                        @elseif ($role === 'freelancer')
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.all_projects') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('freelancer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                                    <li><hr><a href="{{{ url('freelancer/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                                    <li><hr><a href="{{{ url('freelancer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{{ route('showFreelancerProposals') }}}">
                                    <i class="ti-bookmark-alt"></i>
                                    <span> {{ trans('lang.proposals') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{{ route('getFreelancerPayouts') }}}">
                                    <i class="ti-money"></i>
                                    <span> {{ trans('lang.payouts') }}</span>
                                </a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span>{{ trans('lang.invoices') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('freelancer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a href="{{{ url('dashboard/packages/'.$role) }}}">
                                <i class="ti-package"></i>
                                <span>{{ trans('lang.packages') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ url($role.'/saved-items') }}}">
                                <i class="ti-heart"></i>
                                <span>{{ trans('lang.saved_items') }}</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                            <i class="lnr lnr-exit"></i>{{{trans('lang.logout')}}}
                        </a>
                        <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </nav>
            <div class="wt-navdashboard-footer">
                <span>Copyright © 2020 Team xTmos, All Right Reserved RisfBD</span>
            </div>
        </div>
    </div>
@endauth
