@extends('back-end.master')
@section('content')
    <div class="wt-dbsectionspace wt-haslayout la-pm-freelancer">
        <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <div class="freelancer-profile" id="user_profile">
                        @if (Session::has('message'))
                            <div class="flash_msg">
                                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                            </div>
                        @endif
                        @if ($errors->any())
                            <ul class="wt-jobalerts">
                                @foreach ($errors->all() as $error)
                                    <div class="flash_msg">
                                        <flash_messages :message_class="'danger'" :time ='10' :message="'{{{ $error }}}'" v-cloak></flash_messages>
                                    </div>
                                @endforeach
                            </ul>
                        @endif
                        <div class="wt-dashboardbox wt-dashboardtabsholder">
                            @include('back-end.freelancer.profile-settings.tabs')
                            <div class="wt-tabscontent tab-content">
                                <div class="wt-educationholder" id="wt-education">
                                    {!! Form::open(['url' => url('freelancer/store-payment-settings'), 'class' =>'wt-formtheme wt-userform', 'id' => 'payment_settings', '@submit.prevent'=>'submitPaymentSettings']) !!}
                                        <div class="wt-userexperience wt-tabsinfo">
                                            <div class="wt-tabscontenttitle">
                                                <h2>{{{ trans('lang.payout_id') }}}</h2>
                                                <span>{{{ trans('lang.payout_note') }}}</span>
                                            </div>
                                            <div class="wt-settingscontent">
                                                <div class="wt-formtheme wt-userform">
                                                    <div class="form-group form-group-half">
                                                        {{{Form::text('payout_id',  e($payout_id), ['class' => 'form-control', 'placeholder' => trans('lang.ph_payout_id')])}}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wt-updatall">
                                            <i class="ti-announcement"></i>
                                            <span>{{{ trans('lang.save_changes_note') }}}</span>
                                            {!! Form::submit(trans('lang.btn_save_update'), ['class' => 'wt-btn', 'id'=>'submit-profile']) !!}
                                        </div>
                                    {!! form::close(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
