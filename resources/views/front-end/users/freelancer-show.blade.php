@extends('front-end.master', ['body_class' => 'wt-innerbgcolor'])
@section('content')
    <div class="wt-haslayout wt-innerbannerholder wt-innerbannerholdervtwo" style="background-image: url({{{ asset($banner) }}});">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                </div>
            </div>
        </div>
    </div>
    <div class="wt-main-section wt-paddingtopnull wt-haslayout la-profile-holder" id="user_profile">
        @if (Auth::user())
            @if ($profile->user_id != Auth::user()->id)
                <chat :trans_image_alt="'{{trans('lang.img')}}'" :ph_new_msg="'{{ trans('lang.ph_new_msg') }}'" :trans_placeholder="'{{ trans('lang.ph_type_msg') }}'" :receiver_id="'{{$profile->user_id}}'" :receiver_profile_image="'{{{ asset($avatar) }}}'"></chat>
            @endif
        @endif
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                    <div class="wt-userprofileholder">
                        @if (!empty($badge))
                            <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                <img src="{{{ asset(Helper::getBadgeImage($badge_img)) }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style">
                            </span>
                        @endif
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 float-left">
                            <div class="row">
                                <div class="wt-userprofile">
                                    @if (!empty($avatar))
                                        <figure><img src="{{{ asset($avatar) }}}" alt="{{{ trans('lang.user_avatar') }}}"></figure>
                                    @endif
                                    <div class="wt-title">
                                        @if (!empty($user_name))
                                            <h3>@if ($user->user_verified === 1)<i class="fa fa-check-circle"></i> @endif {{{ $user_name }}}</h3>
                                        @endif
                                        <span>
                                            <div class="wt-proposalfeedback"><span class="wt-starcontent"> {{{ $rating }}}/<i>5</i>&nbsp;<em>({{{ $reviews->count() }}} {{ trans('lang.feedbacks') }})</em></span></div>
                                            @if (!empty($joining_date))
                                                {{{ trans('lang.member_since') }}}&nbsp;{{{ $joining_date }}}
                                            @endif
                                            <br>
                                            <a href="{{url('profile/'.$user->slug)}}">{{ '@' }}{{{ $user->slug }}}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 float-left">
                            <div class="row">
                                <div class="wt-proposalhead wt-userdetails">
                                    @if (!empty($profile->tagline))
                                        <h2>{{{ $profile->tagline }}}</h2>
                                    @endif
                                    <ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
                                        @if (!empty($profile->hourly_rate))
                                            <li><span><i class="far fa-money-bill-alt"></i> ${{{ $profile->hourly_rate }}} {{{ trans('lang.per_hour') }}}</span></li>
                                        @endif
                                        @if (!empty($user->location->title))
                                            <li>
                                                <span>
                                                    <img src="{{{asset(Helper::getLocationFlag($user->location->flag))}}}" alt="{{{ trans('lang.flag_img') }}}"> {{{ $user->location->title }}}
                                                </span>
                                            </li>
                                        @endif
                                        @if (in_array($profile->id, $save_freelancer))
                                            <li class="wt-btndisbaled">
                                                <a href="javascrip:void(0);" class="wt-clicksave wt-clicksave">
                                                    <i class="fa fa-heart"></i>
                                                    {{ trans('lang.btn_save') }}
                                                </a>
                                            </li>
                                            @else
                                            <li v-bind:class="disable_btn" v-cloak>
                                                <a href="javascrip:void(0);" v-bind:class="click_to_save" id="freelancer-{{$profile->id}}" @click.prevent="add_wishlist(freelancer-{{$profile->id}}, {{$profile->id}}, 'saved_freelancer', '{{trans("lang.saved")}}')" v-cloak>
                                                    <i v-bind:class="saved_class"></i>
                                                    @{{ text }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                    @if (!empty($profile->description))
                                        <div class="wt-description">
                                            <p>{{{ $profile->description }}}</p>
                                        </div>
                                    @endif
                                </div>
                                <div id="wt-statistics" class="wt-statistics wt-profilecounter">
                                    <div class="wt-statisticcontent wt-countercolor1">
                                        <h3 data-from="0" data-to="{{{ Helper::getProposals($user->id, 'hired')->count() }}}" data-speed="800" data-refresh-interval="03">{{{ Helper::getProposals($user->id, 'hired')->count() }}}</h3>
                                        <h4>{{ trans('lang.ongoing_project') }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor2">
                                        <h3 data-from="0" data-to="{{{ Helper::getProposals($user->id, 'completed')->count() }}}" data-speed="8000" data-refresh-interval="100">{{{ Helper::getProposals($user->id, 'completed')->count() }}}</h3>
                                        <h4>{{ trans('lang.completed_projects') }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor4">
                                        <h3 data-from="0" data-to="{{{ Helper::getProposals($user->id, 'cancelled')->count() }}}" data-speed="800" data-refresh-interval="02">{{{ Helper::getProposals($user->id, 'cancelled')->count() }}}</h3>
                                        <h4>{{ trans('lang.cancelled_projects') }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor3">
                                        <h3 data-from="0" data-to="{{ $amount }}" data-speed="8000" data-refresh-interval="100">{{ empty($amount) ? $currency_symbol.'0.00' : $amount }}</h3>
                                        <h4>{{ trans('lang.total_earnings') }}</h4>
                                    </div>
                                    <div class="wt-description">
                                        <p>{{ trans('lang.send_offer_note') }}</p>
                                        <a href="javascript:void(0);" @click.prevent='sendOffer("{{$auth_user}}")' class="wt-btn">{{{ trans('lang.btn_send_offer') }}}</a>
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
                                    <h2>{{ trans('lang.client_feedback') }}</h2>
                                </div>
                                @if (!empty($reviews) && $reviews->count() > 0)
                                    @foreach ($reviews as $key => $review)
                                        @php
                                            $job = \App\Job::where('id', $review->job_id)->first();
                                            $verified_user = \App\User::select('user_verified')->where('id', $review->user_id)->pluck('user_verified')->first();
                                        @endphp
                                        <div class="wt-userlistinghold wt-userlistingsingle">
                                            <figure class="wt-userlistingimg">
                                                <img src="{{ asset(Helper::getProfileImage($review->user_id)) }}" alt="{{{ trans('Employer') }}}">
                                            </figure>
                                            <div class="wt-userlistingcontent">
                                                <div class="wt-contenthead">
                                                    <div class="wt-title">
                                                        <a href="{{{ url('profile/'.$job->employer->slug) }}}">@if ($verified_user === 1)<i class="fa fa-check-circle"></i>@endif {{{ Helper::getUserName($review->user_id) }}}</a>
                                                        <h3>{{{ $job->title }}}</h3>
                                                    </div>
                                                    <ul class="wt-userlisting-breadcrumb">
                                                        <li><span><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i> {{{ \App\Helper::getProjectLevel($job->project_level) }}}</span></li>
                                                        <li>
                                                            <span>
                                                                <img src="{{{asset(App\Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.flag_img') }}}"> {{{ $job->location->title }}}
                                                            </span>
                                                        </li>
                                                        <li><span><i class="far fa-calendar"></i> {{ Carbon\Carbon::parse($job->created_at)->format('M Y') }} - {{ Carbon\Carbon::parse($job->updated_at)->format('M Y') }}</span></li>
                                                        <li>
                                                            <vue-stars
                                                            :name="'rating[{{$key}}][rate]'"
                                                            :active-color="'#fecb02'"
                                                            :inactive-color="'#999999'"
                                                            :shadow-color="'#ffff00'"
                                                            :hover-color="'#fecb02'"
                                                            :max="5"
                                                            :value="{{$review->avg_rating}}"
                                                            :readonly="true"
                                                            :char="'★'"
                                                            id="rating-{{$key}}"
                                                            />
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="wt-description">
                                                @if (!empty($review->feedback))
                                                    <p>“ {{{ $review->feedback }}} ”</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="wt-userprofile">
                                        @include('errors.no-record')
                                    </div>
                                @endif
                            </div>
                            <div class="wt-craftedprojects">
                                <div class="wt-usertitle">
                                    <h2>{{{ trans('lang.crafted_projects') }}}</h2>
                                </div>
                                @if (!empty($projects))
                                    <crafted_project :no_of_post="3" :project="'{{  json_encode($projects) }}'" :freelancer_id="'{{$profile->user_id}}'" :img="'{{ trans('lang.img') }}'"></crafted_project>
                                @else
                                    <div class="wt-userprofile">
                                        @include('errors.no-record')
                                    </div>
                                @endif
                            </div>
                            <div class="wt-experience">
                                <div class="wt-usertitle">
                                    <h2>{{{ trans('lang.experience') }}}</h2>
                                </div>
                                @if (!empty($experiences))
                                    <div class="wt-experiencelisting-hold">
                                        <experience :freelancer_id="'{{$profile->user_id}}'" :no_of_post="2"></experience>
                                    </div>
                                @else
                                    <div class="wt-userprofile">
                                        @include('errors.no-record')
                                    </div>
                                @endif
                            </div>
                            <div class="wt-experience wt-education">
                                <div class="wt-usertitle">
                                    <h2>{{{ trans('lang.education') }}}</h2>
                                </div>
                                @if (!empty($education))
                                    <education :freelancer_id="'{{$profile->user_id}}'" :no_of_post="1"></education>
                                @else
                                    <div class="wt-userprofile">
                                        @include('errors.no-record')
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                        <aside id="wt-sidebar" class="wt-sidebar">
                            <div id="wt-ourskill" class="wt-widget">
                                <div class="wt-widgettitle">
                                    <h2>{{ trans('lang.my_skills') }}</h2>
                                </div>
                                @if (!empty($skills) && $skills->count() > 0)
                                    <div class="wt-widgetcontent wt-skillscontent">
                                        @foreach ($skills as $skill)
                                            <div class="wt-skillholder" data-percent="{{{ $skill->pivot->skill_rating }}}%">
                                                <span>{{{ $skill->title }}} <em>{{{ $skill->pivot->skill_rating }}}%</em></span>
                                                <div class="wt-skillbarholder"><div class="wt-skillbar"></div></div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>{{ trans('lang.no_skills') }}</p>
                                @endif
                            </div>
                            @if (!empty($awards))
                                <div class="wt-widget wt-widgetarticlesholder wt-articlesuser">
                                    <div class="wt-widgettitle">
                                        <h2>{{{ trans('lang.awards_certifications') }}}</h2>
                                    </div>
                                    <div class="wt-widgetcontent wt-verticalscrollbar">
                                        @foreach ($awards as $award)
                                            <div class="wt-particlehold">
                                                @if (!empty($award['award_hidden_image']))
                                                    <figure>
                                                        <img src="{{{ asset('uploads/users/'.$profile->user_id.'/awards/'.$award['award_hidden_image']) }}}" alt="{{ trans('lang.img') }}">
                                                    </figure>
                                                @endif
                                                @if (!empty($award['award_title']))
                                                    <div class="wt-particlecontent">
                                                        <h3><a href="javascrip:void(0);">{{{ $award['award_title'] }}}</a></h3>
                                                        <span><i class="lnr lnr-calendar"></i> {{{ $joining_date }}}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="wt-proposalsr">
                                <div class="tg-authorcodescan tg-authorcodescanvtwo">
                                    <figure class="tg-qrcodeimg">
                                        {!! QrCode::size(100)->generate(Request::url('profile/'.$user->slug)); !!}
                                    </figure>
                                    <div class="tg-qrcodedetail">
                                        <span class="lnr lnr-laptop-phone"></span>
                                        <div class="tg-qrcodefeat">
                                            <h3>{{ trans('lang.scan_with_smartphone') }} <span>{{ trans('lang.smartphone') }} </span> {{ trans('lang.get_handy') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-widget wt-sharejob">
                                <div class="wt-widgettitle">
                                    <h2>{{ trans('lang.share_freelancer') }}</h2>
                                </div>
                                <div class="wt-widgetcontent">
                                    <ul class="wt-socialiconssimple">
                                        <li class="wt-facebook">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" class="social-share">
                                            <i class="fa fa fa-facebook-f"></i>{{ trans('lang.share_fb') }}</a>
                                        </li>
                                        <li class="wt-twitter">
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}" class="social-share">
                                            <i class="fa fab fa-twitter"></i>{{ trans('lang.share_twitter') }}</a>
                                        </li>
                                        <li class="wt-pinterest">
                                            <a href="//pinterest.com/pin/create/button/?url={{ urlencode(Request::fullUrl()) }}"
                                            onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
                                            <i class="fa fab fa-pinterest-p"></i>{{ trans('lang.share_pinterest') }}</a>
                                        </li>
                                        <li class="wt-googleplus">
                                            <a href="https://plus.google.com/share?url={{ urlencode(Request::fullUrl()) }}" class="social-share">
                                            <i class="fa fab fa-google-plus-g"></i>{{ trans('lang.share_google') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="wt-widget wt-reportjob">
                                <div class="wt-widgettitle">
                                    <h2>{{ trans('lang.report_user') }}</h2>
                                </div>
                                <div class="wt-widgetcontent">
                                    {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-formreport', 'id' => 'submit-report',  '@submit.prevent'=>'submitReport("'.$profile->user_id.'","freelancer-report")']) !!}
                                        <fieldset>
                                            <div class="form-group">
                                                <span class="wt-select">
                                                    {!! Form::select('reason', \Illuminate\Support\Arr::pluck($reasons, 'title'), null ,array('class' => '', 'placeholder' => trans('lang.select_reason'), 'v-model' => 'report.reason')) !!}
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::textarea( 'description', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'), 'v-model' => 'report.description'] ) !!}
                                            </div>
                                            <div class="form-group wt-btnarea">
                                                {!! Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn']) !!}
                                            </div>
                                        </fieldset>
                                    {!! form::close(); !!}
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
		<b-modal ref="myModalRef" hide-footer title="Project Status">
            <div class="d-block text-center">
                {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'send-offer-form', '@submit.prevent'=>'submitProjectOffer("'.$profile->user_id.'")'])!!}
                    <div class="wt-projectdropdown-hold">
                        <div class="wt-projectdropdown">
                            <span class="wt-select">
                                {{{ Form::select('offer[project]', $employer_projects, null, array('class' => 'form-control', 'placeholder' => trans('lang.ph_select_projects'))) }}}
                            </span>
                        </div>
                    </div>
                    <div class="wt-formtheme wt-formpopup">
                        <fieldset>
                            <div class="form-group">
                                {{{ Form::textarea('offer[desc]', null, array('placeholder' => trans('lang.ph_add_desc'))) }}}
                            </div>
                            <div class="form-group wt-btnarea">
                                {!! Form::submit(trans('lang.btn_send_offer'), ['class' => 'wt-btn']) !!}
                            </div>
                        </fieldset>
                    </div>
                {!! Form::close() !!}
            </div>
        </b-modal>
    </div>
@endsection
