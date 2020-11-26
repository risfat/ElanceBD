{!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'email-setting-form', '@submit.prevent'=>'submitEmailSettings'])!!}
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.from_email_name') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('email_data[0][from_email]', e($from_email), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.from_email_id') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('email_data[0][from_email_id]', e($from_email_id), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
        @include('back-end.admin.settings.email.logo')
        @include('back-end.admin.settings.email.banner')
        @include('back-end.admin.settings.email.signature')
    <div class="wt-updatall la-updateall-holder">
        {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
    </div>  
{!! Form::close() !!}