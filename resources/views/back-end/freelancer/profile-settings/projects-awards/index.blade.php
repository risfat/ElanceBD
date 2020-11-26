@extends('back-end.master')
@section('content')
    <div class="wt-dbsectionspace wt-haslayout la-aw-freelancer">
        <div class="freelancer-profile" id="user_profile">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <div class="wt-dashboardbox wt-dashboardtabsholder">
                        @include('back-end.freelancer.profile-settings.tabs')
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
                            <div class="wt-awardsholder" id="wt-awards">
                                {!! Form::open(['url' => url('freelancer/store-project-award-settings'), 'class' =>'wt-formtheme wt-userform wt-formprojectinfo', 'id' => 'awards_projects', '@submit.prevent' => 'submitAwardsProjects']) !!}
                                    <div class="wt-addprojectsholder wt-tabsinfo">
                                        @include('back-end.freelancer.profile-settings.projects-awards.projects')
                                    </div>
                                    <div class="wt-addprojectsholder wt-tabsinfo la-awards">
                                        @include('back-end.freelancer.profile-settings.projects-awards.awards') 
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