@extends('front-end.master', ['body_class' => 'wt-innerbgcolor'])
@section('content')
    @php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                        <div class="wt-title">
                            <h2>{{ trans('lang.employers') }}</h2>
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
    <div class="wt-haslayout wt-main-section" id="user_profile">
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
                            @include('front-end.employers.filters')
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                            <div class="wt-userlistingtitle">
                                @if (!empty($users))
                                    <span>{{ trans('lang.01') }} {{$users->count()}} of {{\App\User::role('employer')->count()}} results @if (!empty($keyword)) for <em>"{{{$keyword}}}"</em> @endif</span>
                                @endif
                            </div>
                            <div class="wt-companysinfoholder">
                                <div class="row">
                                    @if (!empty($users))
                                        @foreach ($users as $employer)
                                            @php
                                                $verified_user = \App\User::select('user_verified')->where('id', $employer->id)->pluck('user_verified')->first();
                                            @endphp
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="wt-companysdetails">
                                                    <figure class="wt-companysimg">
                                                        <img src="{{{ asset(Helper::getUserProfileBanner($employer->id, 'small')) }}}" alt="Company">
                                                    </figure>
                                                    <div class="wt-companysinfo">
                                                        <figure><img src="{{{ asset(Helper::getProfileImage($employer->id)) }}}" alt="Company"></figure>
                                                        <div class="wt-title">
                                                            <a href="{{{ url('profile/'.$employer->slug) }}}">
                                                            @if ($verified_user === 1)
                                                                <i class="fa fa-check-circle"></i> {{ trans('lang.verified_company') }}</a>
                                                            @endif
                                                            <a href="{{{ url('profile/'.$employer->slug) }}}"><h2>{{{ Helper::getUserName($employer->id) }}}</h2></a>
                                                        </div>
                                                        <ul class="wt-postarticlemeta">
                                                            <li>
                                                                <a href="{{ url('profile/'.$employer->slug) }}">
                                                                    <span>{{ trans('lang.open_jobs') }}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ url('profile/'.$employer->slug) }}}">
                                                                    <span>{{ trans('lang.full_profile') }}</span>
                                                                </a>
                                                            </li>
                                                            @if (in_array($employer->id, $save_employer))
                                                                <li class="wt-following wt-btndisbaled">
                                                                    <a href="javascript:void(0);">
                                                                        {{ trans('lang.following') }}
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a href="javascript:void(0);" id="profile-{{$employer->id}}" @click.prevent="add_wishlist('profile-{{$employer->id}}', {{$employer->id}}, 'saved_employers', '{{trans("lang.following")}}')" v-cloak>
                                                                        <span>{{ trans('lang.click_to_follow') }}</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ( method_exists($users,'links') )
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 la-employerpagintaion">
                                                {{ $users->links('pagination.custom') }}
                                            </div>
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
    </div>
    @endsection
