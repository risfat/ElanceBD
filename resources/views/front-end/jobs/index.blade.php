@extends('front-end.master', ['body_class' => 'wt-innerbgcolor']) 
@section('content')
    @php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp 
        <div class="wt-haslayout wt-innerbannerholder">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                        <div class="wt-innerbannercontent">
                            <div class="wt-title">
                                <h2>{{ trans('lang.jobs') }}</h2>
                            </div>
                            @if (count($breadcrumbs))
                                <ol class="wt-breadcrumb">
                                    @foreach ($breadcrumbs as $breadcrumb) 
                                        @if ($breadcrumb->url && !$loop->last)
                                            <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                                        @else
                                            <li class="active">{{{ $breadcrumb->title }}}</li>
                                        @endif 
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="wt-haslayout wt-main-section" id="jobs">
        @if (Session::has('payment_message'))
            @php $response = Session::get('payment_message') @endphp
            <div class="flash_msg">
                <flash_messages :message_class="'{{{$response['code']}}}'" :time ='5' :message="'{{{ $response['message'] }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <div class="wt-haslayout">
            <div class="container">
                <div class="row">
                    <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
                            @include('front-end.jobs.filters')   
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                            <div class="wt-userlistingholder wt-haslayout">
                                @if (!empty($keyword))
                                    <div class="wt-userlistingtitle">
                                        <span>{{ trans('lang.01') }} {{$jobs->count()}} of {{$Jobs_total_records}} results for <em>"{{{$keyword}}}"</em></span>
                                    </div>
                                @endif
                                @if (!empty($jobs) && $jobs->count() > 0)
                                    @foreach ($jobs as $job)
                                        @php 
                                            $job = \App\Job::find($job->id);
                                            $description = strip_tags(stripslashes($job->description)); 
                                            $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                            $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                                        @endphp
                                        <div class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                            @if ($job->is_featured == 'true')
                                                <span class="wt-featuredtag"><img src="images/featured.png" alt="{{{ trans('ph.is_featured') }}}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                            @endif
                                            <div class="wt-userlistingcontent">
                                                <div class="wt-contenthead">
                                                    <div class="wt-title">
                                                        <a href="{{ url('profile/'.$job->employer->slug) }}"><i class="fa fa-check-circle"></i> {{{ Helper::getUserName($job->employer->id) }}}</a>
                                                        <h2>{{{$job->title}}}</h2>
                                                    </div>
                                                    <div class="wt-description">
                                                        <p>{{ str_limit($description, 200) }}</p>
                                                    </div>
                                                    <div class="wt-tag wt-widgettag">
                                                        @foreach ($job->skills as $skill )
                                                            <a href="{{{url('search-results?type=job&skills%5B%5D='.$skill->id)}}}">{{$skill->title}}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="wt-viewjobholder">
                                                    <ul>
                                                        @if (!empty($job->project_level))
                                                            <li><span><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{Helper::getProjectLevel($job->project_level)}}}</span></li>
                                                        @endif
                                                        @if (!empty($job->location->title))
                                                            <li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"> {{{ $job->location->title }}}</span></li>
                                                        @endif
                                                        <li><span><i class="far fa-folder wt-viewjobfolder"></i>{{{ trans('lang.type') }}} {{{$job->project_type}}}</span></li>
                                                        <li><span><i class="far fa-clock wt-viewjobclock"></i>{{{ \App\Helper::getJobDurationList($job->duration)}}}</span></li>
                                                        <li><span><i class="fa fa-tag wt-viewjobtag"></i>{{{ trans('lang.job_id') }}} {{{$job->code}}}</span></li>
                                                        @if (!empty($user->profile->saved_jobs) && in_array($job->id, unserialize($user->profile->saved_jobs))) 
                                                            <li style=pointer-events:none;><a href="javascript:void(0);" class="wt-clicklike wt-clicksave"><i class="fa fa-heart"></i> {{trans("lang.saved")}}</a></li>
                                                        @else 
                                                            <li>
                                                                <a href="javascrip:void(0);" class="wt-clicklike" id="job-{{$job->id}}" @click.prevent="add_wishlist('job-{{$job->id}}', {{$job->id}}, 'saved_jobs', '{{trans("lang.saved")}}')" v-cloak>
                                                                    <i class="fa fa-heart"></i>
                                                                    <span class="save_text">Click to Save</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li class="wt-btnarea"><a href="{{url('job/'.$job->slug)}}" class="wt-btn">{{{ trans('lang.view_job') }}}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ( method_exists($jobs,'links') )
                                        {{ $jobs->links('pagination.custom') }}
                                    @endif
                                @else
                                    @include('errors.no-record') 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection