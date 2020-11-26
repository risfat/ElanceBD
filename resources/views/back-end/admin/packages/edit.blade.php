@extends('back-end.master') 
@section('content')
    <div class="skills-listing" id="packages">
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{ trans('lang.edit_package') }}}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open(['url' => url('admin/packages/update/'.$package->slug.''), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory',
                            'id' => 'packages'] ) !!}
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::text( 'package_title', e($package->title), ['class' =>'form-control'.($errors->has('package_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_title')]) !!}
                                    @if ($errors->has('package_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('package_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::text( 'package_subtitle', e($package->subtitle), ['class' =>'form-control'.($errors->has('package_subtitle') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_subtitle')]) !!}
                                    @if ($errors->has('package_subtitle'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('package_subtitle') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::number( 'package_price', e($package->cost), ['class' =>'form-control '.($errors->has('package_price') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_price')]) !!}
                                    @if ($errors->has('package_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('package_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if ($package->role_id == 2)
                                    <div class="form-group">
                                        {!! Form::text('employer[jobs]', e($options['jobs']), array('class' => 'form-control', 'placeholder' => trans('lang.no_of_jobs'))) !!}
                                        @if ($errors->has('employer[jobs]'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('employer[jobs]') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::text('employer[featured_jobs]', e($options['featured_jobs']), array('class' => 'form-control', 'placeholder' => trans('lang.no_of_featuredjobs'))) !!}
                                        @if ($errors->has('employer[featured_jobs]'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('employer[featured_jobs]') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('employer[duration]') ? ' is-invalid' : '' }}">
                                        <span class="wt-select">
                                            <select name="employer[duration]">
                                                @foreach ($durations as $key => $duration)
                                                    <option value="{{$key}}" @if ($options['duration'] == $key) selected @endif>{{$key}}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        @if ($errors->has('employer[duration]'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('employer[duration]') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <switch_button v-model="banner_option">{{{ trans('lang.show_banner_opt') }}}</switch_button>
                                        <input type="hidden" :value="banner_option" name="employer[banner_option]">
                                    </div>
                                    <div class="form-group">
                                        <switch_button v-model="private_chat">{{{ trans('lang.enabale_disable_pvt_chat') }}}</switch_button>
                                        <input type="hidden" :value="private_chat" name="employer[private_chat]">
                                    </div>
                                    @if ($package->trial == 1)
                                        <div class="form-group">
                                            <span class="wt-checkbox">
                                                <input id="trial" type="checkbox" name="trial" checked>
                                                <label for="trial"><span>{{{ trans('lang.enable_trial') }}}</span></label>
                                            </span>
                                        </div>
                                    @endif 
                                @elseif ($package->role_id == 3)
                                    <div class="form-group">
                                        {!! Form::number('freelancer[no_of_connects]', e($options['no_of_connects']), array('class' => 'form-control', 'placeholder'
                                        => trans('lang.no_of_connects'))) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::number('freelancer[no_of_skills]', e($options['no_of_skills']), array('class' => 'form-control', 'placeholder'
                                        => trans('lang.no_of_skills'))) !!}
                                    </div>
                                    <div class="form-group">
                                        <span class="wt-select">
                                            <select name="freelancer[duration]">
                                                @foreach ($durations as $key => $duration)
                                                    <option value="{{$key}}" @if ($options['duration'] == $key) selected @endif>{{$key}}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('freelancer[badge]', $badges, $package->badge_id, array('placeholder' => trans('lang.select_badge'))) !!}
                                        </span>
                                    </div>                                 
                                    <div class="form-group">
                                        <switch_button v-model="banner_option">{{{ trans('lang.show_banner_opt') }}}</switch_button>
                                        <input type="hidden" :value="banner_option" name="freelancer[banner_option]">
                                    </div>
                                    <div class="form-group">
                                        <switch_button v-model="private_chat">{{{ trans('lang.enabale_disable_pvt_chat') }}}</switch_button>
                                        <input type="hidden" :value="private_chat" name="freelancer[private_chat]">
                                    </div>
                                    @if ($freelancer_trial->count() == 0)
                                        <div class="form-group">
                                            <span class="wt-checkbox">
                                                <input id="trial" type="checkbox" name="trial">
                                                <label for="trial"><span>{{{ trans('lang.enable_trial') }}}</span></label>
                                            </span>
                                        </div>
                                    @elseif ($package->trial == 1)
                                        <div class="form-group">
                                            <span class="wt-checkbox">
                                                <input id="trial" type="checkbox" name="trial" checked>
                                                <label for="trial"><span>{{{ trans('lang.enable_trial') }}}</span></label>
                                            </span>
                                        </div>
                                    @endif 
                                @endif
                                <div class="form-group wt-btnarea">
                                    {!! Form::submit(trans('lang.update_package'), ['class' => 'wt-btn']) !!}
                                </div>
                            </fieldset>
                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection