@extends('back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-insightsitemholder">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="wt-insightsitem wt-dashboardbox {{$notify_class}}">
                            <figure class="wt-userlistingimg">
                                {{ Helper::getImages('images/thumbnail/','img-19.png', 'book') }}
                            </figure>
                            <div class="wt-insightdetails">
                                <div class="wt-title">
                                    <h3>{{ trans('lang.new_msgs') }}</h3>
                                    <a href="{{ url('message-center') }}">{{ trans('lang.click_view') }}</a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-20.png', 'layers') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ trans('lang.latest_proposals') }}</h3>
                                        <a href="{{{ url('employer/dashboard/manage-jobs') }}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <countdown 
                                date="{{$expiry_date}}" 
                                :image_url="'{{{ Helper::getDashExpiryImages('images/thumbnail/', 'img-21.png') }}}'"
                                :title="'{{ trans('lang.check_pkg_expiry') }}'"
                                :package_url="'{{url('dashboard/packages/employer')}}'"
                                >
                                </countdown>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-22.png', 'lnr lnr-heart') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ trans('lang.view_saved_items') }}</h3>
                                        <a href="{{ url('employer/saved-items') }}">{{ trans('lang.click_view') }}</a>
                                    </div>													
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-16.png', 'cross-circle') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{Helper::getTotalJobs('cancelled')}}</h3>
                                        <span>{{ trans('lang.total_cancelled_jobs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-17.png', 'cloud-sync') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{Helper::getTotalJobs('hired')}}</h3>
                                        <span>{{ trans('lang.total_ongoing_jobs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-18.png', 'checkmark-circle') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{Helper::getTotalJobs('completed')}}</h3>
                                        <span>{{ trans('lang.total_completed_jobs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-15.png', 'enter') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{Helper::getTotalJobs('posted')}}</h3>
                                        <span>{{ trans('lang.total_posted_jobs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects wt-earningsholder">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.ongoing_project') }}</h2>
                    </div>
                    @if (!empty($ongoing_jobs) && $ongoing_jobs->count() > 0) 
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories wt-freelancer-table">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.project_title')}}</th>
                                        <th>{{trans('lang.hired_freelancers')}}</th>
                                        <th>{{trans('lang.project_cost')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ongoing_jobs as $project)
                                        @php
                                            $proposal_freelancer = $project->proposals->where('status', 'hired')->pluck('freelancer_id')->first();
                                            $freelancer = \App\User::find($proposal_freelancer);
                                            $user_name = Helper::getUsername($proposal_freelancer);
                                        @endphp
                                        <tr>
                                            <td data-th="Project title"><span class="bt-content"><a target="_blank" href="{{{ url('job/'.$project->slug) }}}">{{{ $project->title }}}</a></span></td>
                                            <td data-th="Hired freelancer">
                                                <span class="bt-content">
                                                    <a href="{{{url('profile/'.$freelancer->slug)}}}">
                                                        @if ($freelancer->user_verified)
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        @endif
                                                        {{{$user_name}}}					
                                                    </a>
                                                </span>
                                            </td>
                                            <td data-th="Project cost"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{$project->price}}</span></td>
                                            <td data-th="Actions">
                                                <span class="bt-content">
                                                    <div class="wt-btnarea">
                                                        <a href="{{{ url('employer/dashboard/job/'.$project->slug.'/proposals') }}}" class="wt-btn">View Details</a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('errors.no-record')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
