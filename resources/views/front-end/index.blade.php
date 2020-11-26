@extends('front-end.master')
@section('content')
    <div id="home" class="la-home-page">
        @if (Session::has('not_verified'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('not_verified') }}}'" v-cloak></flash_messages>
            </div>
            @php session()->forget('not_verified'); @endphp
        @endif
        <div class="wt-haslayout wt-bannerholder" style="background-image:url({{{ asset(Helper::getBackgroundImage($banner)) }}})">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="wt-bannerimages">
                          <!--  <figure class="wt-bannermanimg" data-tilt> -->
                                <img src="{{{ asset(Helper::getBannerImage($banner_inner_image)) }}}" alt="{{{ trans('lang.img') }}}">
                            <!-- </figure> -->
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="wt-bannercontent">
                            <div class="wt-bannerhead">
                                <div class="wt-title">
                                    <h1>
                                        @if (!empty($banner_title))<span>{{{ $banner_title }}}</span> @endif 
                                        @if ($banner_subtitle){{{ $banner_subtitle }}} @endif
                                    </h1>
                                </div>
                                <div class="wt-description">
                                    <p>{{{ $banner_description }}}</p>
                                </div>
                            </div>
                            <search-form :widget_type="'home'"></search-form>
                            <div class="wt-videoholder">
                                <div class="wt-videoshow">
                                    <a data-rel="prettyPhoto[video]" href="{{{ $banner_video_link }}}"><i class="fa fa-play"></i></a>
                                </div>
                                <div class="wt-videocontent">
                                    <span>{{{ $banner_video_title }}}<em>{{{ $banner_video_desc }}}</em></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($categories))
            <section class="wt-haslayout wt-main-section">
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                            <div class="wt-sectionhead wt-textcenter">
                                <div class="wt-sectiontitle">
                                    <h2>{{ trans('lang.explore_cats') }}</h2>
                                    <span>{{ trans('lang.professional_by_cats') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="wt-categoryexpl">
                            @foreach ($categories as $category)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 float-left">
                                    <div class="wt-categorycontent">
                                        <figure><img src="{{{ asset(Helper::getCategoryImage($category->image)) }}}" alt="{{{ $category->title }}}"></figure>
                                        <div class="wt-cattitle">
                                            <h3><a href="{{{url('search-results?type=job&category%5B%5D='.$category->slug)}}}">{{{ $category->title }}}</a></h3>
                                        </div>
                                        <div class="wt-categoryslidup">
                                            @if (!empty($category->abstract))
                                                <p>{{{ $category->abstract }}}</p>
                                            @endif
                                            <a href="{{{url('search-results?type=job&category%5B%5D='.$category->slug)}}}">{{ trans('lang.explore') }} <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($categories->count() > 9)
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                                    <div class="wt-btnarea">
                                        <a href="{{{ route('categoriesList') }}}" class="wt-btn">{{ trans('lang.view_all') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <section class="wt-haslayout wt-main-section wt-paddingnull wt-bannerholdervtwo" style="background-image:url({{{ asset(Helper::getBannerImage($section_bg)) }}})">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="wt-companydetails">
                            @if (!empty($company_title) || !empty($company_desc))
                                <div class="wt-companycontent">
                                    <div class="wt-companyinfotitle">
                                        <h2>{{{ $company_title }}}</h2>
                                    </div>
                                    <div class="wt-description">
                                        <p>{{{  $company_desc  }}}</p>
                                    </div>
                                    <div class="wt-btnarea">
                                        <a href="{{{ $company_url }}}" class="wt-btn">{{ trans('lang.join_now') }}</a>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($freelancer_title) || !empty($freelancer_desc))
                                <div class="wt-companycontent">
                                    <div class="wt-companyinfotitle">
                                        <h2>{{{ $freelancer_title }}}</h2>
                                    </div>
                                    <div class="wt-description">
                                        <p>{{{ $freelancer_desc }}}</p>
                                    </div>
                                    <div class="wt-btnarea">
                                        <a href="{{{ $freelancer_url }}}" class="wt-btn">{{ trans('lang.join_now') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- <section class="wt-haslayout wt-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                        <figure class="wt-mobileimg">
                            <img src="{{{ asset(Helper::getDownloadAppImage($download_app_img)) }}}" alt="{{{ trans('lang.img') }}}">
                        </figure>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                        <div class="wt-experienceholder">
                            <div class="wt-sectionhead">
                                <div class="wt-sectiontitle">
                                    <h2>{{{ $app_title }}}</h2>
                                    <span>{{{ $app_subtitle  }}}</span>
                                </div>
                                <div class="wt-description">
                                    @php echo htmlspecialchars_decode(stripslashes($app_desc)); @endphp
                                </div>
                                <ul class="wt-appicon">
                                    <li>
                                        <a href="{{ $app_android_link }}">
                                            <figure><img src="{{{ asset('images/android.png') }}}" alt="{{{ trans('lang.img') }}}"></figure>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $app_ios_link }}">
                                            <figure><img src="{{{ asset('images/ios.png') }}}" alt="{{{ trans('lang.img') }}}"></figure>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->


        
        <section class="wt-haslayaout wt-main-section wt-footeraboutus">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="wt-widgetskills">
                            <div class="wt-fwidgettitle">
                                <h3>{{ trans('lang.by_skills') }}</h3>
                            </div>
                            @if (!empty($skills))
                                <ul class="wt-fwidgetcontent">
                                    @foreach ($skills as $skill)
                                        <li><a href="{{{url('search-results?type=job&skills%5B%5D='.$skill->slug)}}}">{{{ $skill->title }}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="wt-footercol wt-widgetcategories">
                            <div class="wt-fwidgettitle">
                                <h3>{{ trans('lang.by_cats') }}</h3>
                            </div>
                            @if (!empty($categories))
                                <ul class="wt-fwidgetcontent">
                                    @foreach ($categories as $category)
                                        <li><a href="{{{url('search-results?type=job&category%5B%5D='.$category->slug)}}}">{{{ $category->title }}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="wt-widgetbylocation">
                            <div class="wt-fwidgettitle">
                                <h3>{{ trans('lang.by_locs') }}</h3>
                            </div>
                            @if (!empty($locations))
                                <ul class="wt-fwidgetcontent">
                                    @foreach ($locations as $location)
                                        <li><a href="{{{url('search-results?type=job&locations%5B%5D='.$location->slug)}}}">{{{ $location->title }}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="wt-widgetbylocation">
                            <div class="wt-fwidgettitle">
                                <h3>{{ trans('lang.by_lang') }}</h3>
                            </div>
                            @if (!empty($languages))
                                <ul class="wt-fwidgetcontent">
                                    @foreach ($languages as $language)
                                        <li><a href="{{{url('search-results?type=job&languages%5B%5D='.$language->slug)}}}">{{{ $language->title }}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
