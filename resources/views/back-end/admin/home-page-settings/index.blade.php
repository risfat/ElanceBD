@extends('back-end.master')
@section('content')
    <div class="wt-haslayout wt-manage-account wt-dbsectionspace la-setting-holder" id="settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'home-settings-form', '@submit.prevent'=>'submitHomeSettings'])!!}
                    <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                        <div class="wt-dashboardtabs">
                            <ul class="wt-tabstitle nav navbar-nav">
                                <li class="nav-item">
                                    <a class="active" data-toggle="tab" href="#wt-banner">{{ trans('lang.banner_settings') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="" data-toggle="tab" href="#wt-sections">{{ trans('lang.sections') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="wt-tabscontent tab-content">
                            <div class="wt-securityhold tab-pane active la-banner-settings" id="wt-banner">
                                @include('back-end.admin.home-page-settings.banner-settings.index')
                            </div>
                            <div class="wt-securityhold tab-pane la-section-settings" id="wt-sections">
                                @include('back-end.admin.home-page-settings.sections.index')
                            </div>
                        </div>
                        <div class="wt-updatall">
                            {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection