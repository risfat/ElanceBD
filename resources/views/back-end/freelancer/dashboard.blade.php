@extends('back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-insightsitemholder">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-20.png', 'layers') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ trans('lang.latest_proposals') }}</h3>
                                        <a href="{{route('showFreelancerProposals')}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <countdown
                                date="{{$expiry_date}}"
                                :image_url="'{{{ Helper::getDashExpiryImages('images/thumbnail/', 'img-21.png') }}}'"
                                :title="'{{ trans('lang.check_pkg_expiry') }}'"
                                :package_url="'{{url('dashboard/packages/freelancer')}}'"
                                :trail="'{{$trail}}'"
                                >
                                </countdown>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox {{$notify_class}}">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-19.png', 'book') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ trans('lang.new_msgs') }}</h3>
                                        <a href="{{{ route('message') }}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-22.png', 'lnr lnr-heart') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ trans('lang.view_saved_items') }}</h3>
                                        <a href="{{url('freelancer/saved-items')}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-16.png', 'cross-circle') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{{ $cancelled_projects->count() }}}</h3>
                                        <h3>{{ trans('lang.total_cancelled_projects') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','img-17.png', 'cloud-sync') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{{ $ongoing_projects->count() }}}</h3>
                                        <h3>{{ trans('lang.total_ongoing_projects') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','icon-01.png', 'cart') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{ Helper::getProposalsBalance(Auth::user()->id, 'hired') }}}</h3>
                                        <h3>{{ trans('lang.pending_bal') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('images/thumbnail/','icon-02.png', 'gift') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{ Helper::getProposalsBalance(Auth::user()->id, 'completed') }}}</h3>
                                        <h3>{{ trans('lang.curr_bal') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.ongoing_project') }}</h2>
                    </div>
                    @if (!empty($ongoing_projects) && $ongoing_projects->count() > 0)
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories wt-freelancer-table">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.project_title')}}</th>
                                        <th>{{trans('lang.employer_name')}}</th>
                                        <th>{{trans('lang.project_cost')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ongoing_projects as $projects)
                                        @php
                                            $project = \App\Proposal::find($projects->id);
                                            $user = \App\User::find($project->job->user_id);
                                            $user_name = Helper::getUsername($project->job->user_id);
                                        @endphp
                                        <tr>
                                            <td data-th="Project title"><span class="bt-content"><a target="_blank" href="{{{ url('freelancer/job/'.$project->job->slug) }}}">{{{ $project->job->title }}}</a></span></td>
                                            <td data-th="Hired freelancer">
                                                <span class="bt-content">
                                                    <a href="{{{url('profile/'.$user->slug)}}}">
                                                        @if ($user->user_verified)
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        @endif
                                                        {{{$user_name}}}					
                                                    </a>
                                                </span>
                                            </td>
                                            <td data-th="Project cost"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{$projects->amount}}</span></td>
                                            <td data-th="Actions">
                                                <span class="bt-content">
                                                    <div class="wt-btnarea">
                                                        <a href="{{{ url('freelancer/job/'.$project->job->slug) }}}" class="wt-btn">View Details</a>
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox  wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.past_earnings') }}</h2>
                    </div>
                    @if (!empty($completed_projects) && $completed_projects->count() > 0)
                        @php  
                            $commision = \App\SiteManagement::getMetaValue('commision'); 
                            $admin_commission = !empty($commision[0]['commision']) ? $commision[0]['commision'] : 0; 
                        @endphp
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.project_title')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.earnings')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($completed_projects as $projects)
                                        @php
                                            $project = \App\Proposal::find($projects->id);
                                            $user_name = Helper::getUsername($project->job->user_id);
                                            $amount = !empty($project->amount) ? $project->amount - ($project->amount / 100) * $admin_commission : 0;
                                        @endphp
                                        <tr class="wt-earning-contents">
                                            <td class="wt-earnig-single" data-th="Project Title"><span class="bt-content">{{{ $project->job->title }}}</span></td>
                                            <td data-th="Date"><span class="bt-content">{{$project->updated_at}}</span></td>
                                            <td data-th="Earnings"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$amount}}}</span></td>
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
