{!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'general-setting-form', '@submit.prevent'=>'submitGeneralSettings'])!!}
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.site_title') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('settings[0][title]', e($title), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.email_address') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::email('settings[0][email]', e($email), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    @include('back-end.admin.settings.general.logo')
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.job_cost') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::number('settings[0][connects_per_job]', e($connects_per_job), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.google_map_api_key') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('settings[0][gmap_api_key]', e($gmap_api_key), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-updatall la-updateall-holder">
        {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
    </div>
{!! Form::close() !!}
