@extends('back-end.master')
@section('content')
    <div class="wt-dbsectionspace wt-haslayout la-ed-freelancer">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
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
                                {!! Form::open(['url' => url('freelancer/store-experience-settings'), 'class' =>'wt-formtheme wt-userform', 'id' => 'experience_form', '@submit.prevent'=>'submitExperienceEduction']) !!}
                                    <div class="wt-userexperience wt-tabsinfo">
                                        @include('back-end.freelancer.profile-settings.experience-education.experience')
                                    </div>
                                    <div class="wt-userexperience wt-tabsinfo">
                                        @include('back-end.freelancer.profile-settings.experience-education.education')
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
@endsection
