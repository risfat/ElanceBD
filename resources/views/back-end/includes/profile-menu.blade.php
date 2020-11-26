<nav id="wt-profiledashboard" class="wt-usernav">
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
                    <a href="{{{ route('pages') }}}">
                        <i class="ti-layers"></i>
                        <span>{{ trans('lang.pages') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ route('pages') }}}">{{ trans('lang.all_pages') }}</a></li>
                        <li><a href="{{{ route('createPage') }}}">{{ trans('lang.add_pages') }}</a></li>
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
                    <a href="{{{ route('adminProfile') }}}">
                        <i class="ti-settings"></i>
                        <span>{{ trans('lang.settings') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ route('adminProfile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                        <li><a href="{{{ route('settings') }}}">{{ trans('lang.general_settings') }}</a></li>
                        <li><a href="{{{ route('resetPassword') }}}">{{ trans('lang.acc_settings') }}</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <span class="wt-dropdowarrow"><i class="ti-layers"></i></span>
                    <a href="{{{ route('categories') }}}">
                        <i class="ti-layers"></i>
                        <span>{{ trans('lang.cats') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ route('skills') }}}">{{ trans('lang.skills') }}</a></li>
                        <li><a href="{{{ route('categories') }}}">{{ trans('lang.job_cats') }}</a></li>
                        <li><a href="{{{ route('departments') }}}">{{ trans('lang.dpts') }}</a></li>
                        <li><a href="{{{ route('languages') }}}">{{ trans('lang.langs') }}</a></li>
                        <li><a href="{{{ route('locations') }}}">{{ trans('lang.locations') }}</a></li>
                        <li><a href="{{{ route('badges') }}}">{{ trans('lang.badges') }}</a></li>
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
                    <a href="javascript:void(0);">
                        <i class="ti-settings"></i>
                        <span>{{ trans('lang.settings') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ url($role.'/profile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                        <li><a href="{{{ route('manageAccount') }}}">{{ trans('lang.acc_settings') }}</a></li>
                    </ul>
                </li>
                @if ($role === 'employer')
                    <li>
                        <a href="{{{ route('employerPostJob') }}}">
                            <i class="ti-pencil-alt"></i>
                            <span>{{{ trans('lang.post_job') }}}</span>
                        </a>
                    </li>
                    <li class="menu-item-has-children page_item_has_children">
                        <a href="javascript:void(0);">
                            <i class="ti-announcement"></i>
                            <span>{{ trans('lang.jobs') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.manage_job') }}</a></li>
                            <li><a href="{{{ url('employer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                            <li><a href="{{{ url('employer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                            <i class="ti-file"></i>
                            <span>{{ trans('lang.invoices') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('employer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                            <li><a href="{{{ url('employer/project/invoice') }}}">{{ trans('lang.project_inv') }}</a></li>
                        </ul>
                    </li>
                @elseif ($role === 'freelancer')
                    <li class="menu-item-has-children page_item_has_children">
                        <a href="{{{ route('jobs') }}}">
                            <i class="ti-briefcase"></i>
                            <span>{{ trans('lang.all_projects') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('freelancer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                            <li><a href="{{{ url('freelancer/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                            <li><a href="{{{ url('freelancer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{{ route('showFreelancerProposals') }}}">
                            <i class="ti-bookmark-alt"></i>
                            <span>{{ trans('lang.proposals') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{{ route('getFreelancerPayouts') }}}">
                            <i class="ti-money"></i>
                            <span>{{ trans('lang.payouts') }}</span>
                        </a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                            <i class="ti-file"></i>
                            <span>{{ trans('lang.invoices') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('freelancer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
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
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();">
                    <i class="lnr lnr-exit"></i>
                    {{{trans('lang.logout')}}}
                </a>
                <form id="profile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
