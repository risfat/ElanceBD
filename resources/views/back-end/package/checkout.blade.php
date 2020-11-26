@extends('back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.package') }}</h2>
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
                        @php  
                            $options = unserialize($package->options);
                            $banner = $options['banner_option'] = 1 ? 'ti-check' : 'ti-na';
                            $chat = $options['private_chat'] = 1 ? 'ti-check' : 'ti-na';
                        @endphp 
                        <div class="wt-package wt-baiscpackage">
                            <div class="wt-packagehead">
                                <h3>{{{$package->title}}}</h3>
                                <span>{{{$package->subtitle}}}</span>
                            </div>
                            <div class="wt-packagecontent">
                                <ul class="wt-packageinfo">
                                    <li class="wt-packageprice"><span><sup>$</sup>{{{$package->cost}}}<sub>\ {{{$options['duration']}}}</sub></span></li>
                                    @foreach ($options as $key => $option)
                                        @php  
                                            if ($key == 'banner_option' || $key == 'private_chat') {
                                                $class = $option == true ? 'ti-check' : 'ti-na'; 
                                            }
                                        @endphp 
                                        @if ($key == 'banner_option' || $key == 'private_chat')
                                            <li><span><i class="{{{$class}}}"></i></span></li>
                                        @else 
                                            <li><span> {{ $option }}</span></li>
                                        @endif
                                    @endforeach
                                </ul>
                                @php
                                    session()->put(['product_id' => e($package->id)]);  
                                    session()->put(['product_title' => e($package->title)]); 
                                    session()->put(['product_price' => e($package->cost)]); 
                                    session()->put(['type' => 'package']); 
                                @endphp
                                <a class="wt-btn" href="{{{url('paypal/ec-checkout')}}}"><span>{{ trans('lang.paypal') }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
