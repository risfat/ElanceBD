@extends('back-end.master') 
@section('content')
    <div class="dpts-listing" id="dpt-list">
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{ trans('lang.edit_review_options') }}}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open([ 'url' => url('admin/review-options/update-review-options/'.$review_options->id.''), 'class' =>'wt-formtheme
                            wt-formprojectinfo wt-formcategory','id' => 'review_options']) !!}
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::text( 'review_option_title', e($review_options['title']), ['class' =>'form-control'.($errors->has('review_option_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_review_option_title')]) !!}
                                    @if ($errors->has('review_option_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('review_option_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group wt-btnarea">
                                    {!! Form::submit(trans('lang.update_review_options'), ['class' => 'wt-btn']) !!}
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