@extends('back-end.master') 
@section('content')
    <div class="wt-haslayout wt-manage-account wt-dbsectionspace la-admin-setting" id="settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 float-left">
                <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                    <div class="wt-dashboardtabs">
                        <ul class="wt-tabstitle nav navbar-nav">
                            <li class="nav-item">
                                <a class="{{{ \Request::route()->getName()==='settings/#wt-general'? 'active': '' }}}" data-toggle="tab" href="#wt-general">{{ trans('lang.general_settings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{{ \Request::route()->getName()==='settings/#wt-email'? 'active': '' }}}" data-toggle="tab" href="#wt-email">{{ trans('lang.email_settings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{{ \Request::route()->getName()==='settings/#wt-payment'? 'active': '' }}}" data-toggle="tab" href="#wt-payment">{{ trans('lang.payment_settings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{{ \Request::route()->getName()==='settings/#wt-footer'? 'active': '' }}}" data-toggle="tab" href="#wt-footer">{{ trans('lang.footer_settings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{{ \Request::route()->getName()==='settings/#wt-demo'? 'active': '' }}}" data-toggle="tab" href="#wt-demo">{{ trans('lang.demo_content') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="wt-tabscontent tab-content">
                        <div class="wt-securityhold tab-pane active la-general-setting" id="wt-general">
                            @include('back-end.admin.settings.general.index')
                        </div>
                        <div class="wt-securityhold tab-pane la-email-setting" id="wt-email">
                            @include('back-end.admin.settings.email.index')
                        </div>
                        <div class="wt-securityhold tab-pane la-payment-setting" id="wt-payment">
                            @include('back-end.admin.settings.payment.commision-settings')
                            @include('back-end.admin.settings.payment.paypal-settings')
                        </div>
                        <div class="wt-securityhold tab-pane la-footer-setting" id="wt-footer">
                            @include('back-end.admin.settings.footer.index')
                        </div>
                        <div class="wt-securityhold tab-pane la-footer-setting" id="wt-demo">
                            @include('back-end.admin.settings.demo-content.index')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection