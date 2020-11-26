<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.import_demo') }}}</h2>
</div>
{!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id'
        =>'import-demo', '@submit.prevent'=>'']) !!}
    <div class="wt-selectdesign la-wt-demo">
        <ul>
            <li>
                <div class="wt-templateoption">
                    <div class="wt-designimg"><img src="{{ asset('images/demo-content/screenshot.jpg') }}" alt="{{ trans('lang.img') }}"></div>
                    <div class="la-designtitle-holder">
                        <div class="wt-designtitle">
                            <span>{{ trans('lang.preview_demo') }}</span>
                            <a target="_blank" href="http://amentotech.com/projects/worketic" class="wt-btn">{{ trans('lang.btn_preview') }}</a>
                        </div>
                        <div class="wt-designtitle">
                            <span>{{ trans('lang.refresh_site') }}</span>
                            <a href="javascript:void(0)" v-on:click.prevent="importDemo('do you want to import demo content')" class="wt-btn">{{ trans('lang.btn_import_demo') }}</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
{!! Form::close() !!}