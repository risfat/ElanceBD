@extends('back-end.master')
@section('content')
    @php session()->put(['job_id' => e($job->id)]); @endphp
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left" id="jobs">
                @if (Session::has('error'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                    </div>
                    @php 
                        session()->forget('error'); 
                        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
                    @endphp
                @endif
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.hire_freelancer') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-jobdetailscontent la-papaldetailscontent">
                            <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                    <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                @endif
                                <div class="wt-userlistingcontent">
                                    <div class="wt-contenthead">
                                        @if (!empty($employer_name) || !empty($job->title) )
                                            <div class="wt-title">
                                                @if (!empty($employer_name))
                                                    <a href="{{{ url('profile/'.$job->employer->slug) }}}">
                                                        @if ($verified_user === 1)
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        @endif
                                                        {{{ $employer_name }}}
                                                    </a>
                                                @endif
                                                @if (!empty($job->title))
                                                    <h2>{{{ $job->title }}}</h2>
                                                @endif
                                            </div>
                                        @endif
                                        @if (!empty($job->price) || 
                                            !empty($job->location->title))
                                            <ul class="wt-userlisting-breadcrumb">
                                                @if (!empty($job->price))
                                                    <li><span><i class="far fa-money-bill-alt"></i> ${{{ $job->price }}}</span></li>
                                                @endif
                                                @if (!empty($job->location->title))
                                                    <li>
                                                        <span>
                                                            <img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{ trans('lang.location_img') }}"> {{{ $job->location->title }}}
                                                        </span>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="wt-rightarea">
                                        <div class="wt-hireduserstatus">
                                            <span>{{{ $freelancer_name }}}</span>
                                            <ul class="wt-hireduserimgs">
                                                <li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>	
                            </div>
                            <div class="wt-btnarea"><a class="wt-btn" href="{{{url('paypal/ec-checkout')}}}"><span>{{ trans('lang.paypal') }}</span></a></div>
                        </div>
                        @php
                            session()->put(['product_id' => e($proposal->id)]);  
                            session()->put(['product_title' => e($job->title)]); 
                            session()->put(['product_price' => e($job->price)]); 
                            session()->put(['type' => 'project']); 
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
