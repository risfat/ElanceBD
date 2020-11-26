@extends('back-end.master', ['body_class' => 'wt-innerbgcolor']) 
@section('content')
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-dashboardbox la-alljob-holder">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.all_jobs') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-freelancerholder">
                            @if (!empty($jobs) && $jobs->count() > 0)
                                <div class="wt-managejobcontent">
                                    @foreach ($jobs as $job) 
                                        @php 
                                            $duration = !empty($job->duration) ? \App\Helper::getJobDurationList($job->duration) : ''; 
                                            $user_name = !empty($job->employer->id) ? \App\Helper::getUserName($job->employer->id) : ''; 
                                            $verified_user = !empty($job->employer->id) ? $job->employer->user_verified : '';
                                        @endphp
                                        <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                            @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                            <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>                        @endif
                                            <div class="wt-userlistingcontent">
                                                <div class="wt-contenthead">
                                                    @if (!empty($user_name) || !empty($job->title) )
                                                        <div class="wt-title">
                                                            @if (!empty($user_name))
                                                                <a href="{{{ url('profile/'.$job->employer->slug) }}}">
                                                                @if ($verified_user === 1)
                                                                    <i class="fa fa-check-circle"></i>
                                                                @endif
                                                                &nbsp;{{{ $user_name }}}</a>
                                                            @endif 
                                                            @if (!empty($job->title))
                                                                <h2>{{{ $job->title }}}</h2>
                                                            @endif
                                                        </div>
                                                    @endif 
                                                    @if (!empty($job->price) || !empty($location['title']) || !empty($job->project_type) || !empty($job->duration) )
                                                        <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                            @if (!empty($job->price))
                                                                <li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{{ $job->price }}}</span></li>
                                                            @endif 
                                                            @if (!empty($job->location->title))
                                                                <li><span><img src="{{{asset(App\Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.locations') }}}"> {{{ $job->location->title }}}</span></li>
                                                            @endif 
                                                            @if (!empty($job->project_type))
                                                                <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> Type: {{{ $job->project_type }}}</a></li>
                                                            @endif 
                                                            @if (!empty($job->duration))
                                                                <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ $duration }}}</span></li>
                                                            @endif
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="wt-rightarea">
                                                    @if ($job->proposals->count() > 0) 
                                                        <div class="wt-btnarea">
                                                            @if ($job->proposals->where('status', 'cancelled')->count() > 0) 
                                                                {{{ $job->status }}}
                                                                <a href="{{{ url('proposal/'.$job->slug . '/cancelled') }}}" class="wt-btn">{{ trans('lang.view_detail') }} }}                               
                                                            @else
                                                                <a href="{{{ url('proposal/'.$job->slug . '/'. $job->proposals[0]->status) }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a>                                    
                                                            @endif 
                                                        </div>
                                                    @else
                                                        <div class="wt-hireduserstatus">
                                                            <h4>{{{ $job->status }}}</h4>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>  
                            @else
                                @include('errors.no-record')
                            @endif
                        </div>
                    </div>
                    @if ( method_exists($jobs,'links') ) {{ $jobs->links('pagination.custom') }} @endif
                </div>
            </div>
        </div>
    </div>
@endsection