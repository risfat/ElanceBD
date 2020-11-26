@extends('back-end.master')
@section('content')
    <div class="freelancer-profile wt-dbsectionspace" id="user_profile">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="wt-dashboardbox wt-dashboardtabsholder">
                    @include('back-end.employer.profile-settings.tabs')
                    <div class="wt-tabscontent tab-content">
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
                        <div class="wt-personalskillshold lare-employer-profile tab-pane active fade show" id="wt-profile">
                            {!! Form::open(['url' => url('employer/store-profile-settings'), 'class' =>'wt-userform', 'id' => 'employer_data', '@submit.prevent' => 'submitEmployerProfile']) !!}
                                <div class="wt-yourdetails wt-tabsinfo">
                                    @include('back-end.employer.profile-settings.personal-detail.detail')
                                </div>
                                <div class="wt-profilephoto wt-tabsinfo">
                                    @include('back-end.employer.profile-settings.personal-detail.profile_photo') 
                                </div>
                                <div class="wt-bannerphoto wt-tabsinfo">
                                    @include('back-end.employer.profile-settings.personal-detail.profile_banner')
                                </div>
                                <div class="wt-skills">
                                    @include('back-end.employer.profile-settings.personal-detail.employer-detail')   
                                </div>
                                <div class="wt-location wt-tabsinfo">
                                    @include('back-end.employer.profile-settings.personal-detail.location')
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
@endsection
