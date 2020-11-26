<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.add_socials') }}}</h2>
</div>
    @include('back-end.admin.settings.footer.socials')
    {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id'
        =>'footer-setting-form', '@submit.prevent'=>'submitFooterSettings']) !!}
        @include('back-end.admin.settings.footer.logo')
        <div class="wt-location wt-tabsinfo">
            <div class="wt-tabscontenttitle">
                <h2>{{{ trans('lang.about_us_note') }}}</h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        {!! Form::textarea('footer[description]', e($footer_desc), array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2>{{{ trans('lang.copyright_text') }}}</h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        {!! Form::text('footer[copyright]', e($footer_copyright), array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2>{{{ trans('lang.footer_menu_1') }}}</h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        {!! Form::text('footer[menu_title_1]', $menu_title_1 ,array('class' => 'form-control', 'placeholder' => trans('lang.menu_title'))) !!}
                    </div>
                </div>
            </div>
            <div class="wt-settingscontent la-footer-settings">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <span class="wt-select">
                            {!! Form::select('footer[menu_pages_1][]', $pages, $menu_pages_1 ,array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_pages'))) !!}
                        </span>
                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2>{{{ trans('lang.footer_menu') }}}</h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <span class="wt-select">
                            {!! Form::select('footer[pages][]', $pages, $menu_pages ,array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_pages'))) !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="wt-updatall la-updateall-holder">
            {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
        </div>
    {!! Form::close() !!}
    <div class="wt-settingscontent">
        @include('back-end.admin.settings.footer.search-menu')
    </div>
