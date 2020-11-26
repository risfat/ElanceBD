@extends('back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left" id="packages">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.packages') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-packages">
                        <div class="wt-package wt-packagedetails">
                            <div class="wt-packagehead">
                            </div>
                            <div class="wt-packagecontent">
                                <ul class="wt-packageinfo">
                                    @foreach($package_options as $options) 
                                        <li @if ($options == 'Price') class="wt-packageprices" @endif><span>{{{$options}}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if (!empty($packages) && $packages->count() > 0)
                            @foreach ($packages as $key => $package)
                                @php  $options = unserialize($package->options); @endphp 
                                @if (!empty($package))
                                    <div class="wt-package wt-baiscpackage">
                                        @if (!empty($package->title || $package->subtitle ))
                                            <div class="wt-packagehead">
                                                <h3>{{{$package->title}}}</h3>
                                                <span>{{{ $package->subtitle }}}</span>
                                            </div>
                                        @endif
                                        <div class="wt-packagecontent">
                                            <ul class="wt-packageinfo">
                                                <li class="wt-packageprice"><span><sup>$</sup>{{{$package->cost}}}<sub>\ {{{ Helper::getPackageDurationList($options['duration']) }}}</sub></span></li>
                                                @foreach ($options as $key => $option)
                                                    @php  
                                                        if ($key == 'banner_option' || $key == 'private_chat') {
                                                            $class = $option == true ? 'ti-check' : 'ti-na'; 
                                                        }
                                                    @endphp 
                                                    @if ($key == 'banner_option' || $key == 'private_chat')
                                                        <li><span><i class="{{{ $class }}}"></i></span></li>
                                                    @elseif ($key == 'duration') 
                                                        <li><span> {{ Helper::getPackageDurationList($options['duration']) }}</span></li>
                                                    @elseif ($key == 'badge')
                                                        <li><span> {{ Helper::getBadgeTitle($package->badge_id) }}</span></li>
                                                    @else
                                                        <li><span> {{ $option }}</span></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            @if (Auth::user()->getRoleNames()[0] != "admin")
                                                @if (in_array($package->id, $purchase_packages)) 
                                                    <a class="wt-btn" href="javascript:void(0);" style="pointer-events:none"><span>{{ trans('lang.purchased') }}</span></a>  
                                                @else 
                                                    <a class="wt-btn" v-on:click.prevent="getPurchasePackage('{{{$package->id}}}')" href="javascript:void(0);"><span>{{ trans('lang.buy_now') }}</span></a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 float-left">
                                <div class="wt-jobalerts">
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        <em>Alert:</em> <span> Your are currently on trial package</span>
                                        <a href="javascript:void(0)" class="wt-alertbtn warning">Buy Now</a>
                                        <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left">
                                <div class="row justify-content-md-center">
                                    <div class="wt-sectionhead wt-textcenter">
                                        <div class="wt-sectiontitle">
                                            <h1><i class="ti-face-sad"></i></h1>
                                            <span>{{ trans('lang.no_pkg_found') }}</span>
                                        </div>
                                        <a href="{{{ url('/') }}}" class="btn btn-default wt-btn"><span class="ti-home"></span> {{ trans('lang.home') }}</a>
                                    </div>
                                </div> 
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
