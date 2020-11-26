{!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'comission-form', '@submit.prevent'=>'submitCommisionSettings'])!!}
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.payout_settings') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-description">
                <p>{{ trans('lang.set_comm_project') }}</p>
            </div>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::number('payment[0][commision]', $commision, array('class' => 'form-control', 'placeholder' => '0')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.min_payout') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-description">
                <p>{{ trans('lang.set_min_payout') }}</p>
            </div>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::number('payment[0][min_payout]', e($min_payout), ['class' => 'form-control', 'placeholder' => trans('lang.ph_min_payout')]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.select_payment_method') }}}</h2>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <select name="payment[0][payment_method]" class="form-control">
                        <option value="" selected>{{ trans('lang.select_payment_method') }}</option>
                        @foreach ($payment_methods as $key => $payment_method)
                            <option value="{{$payment_method['value']}}" @if ($payment_gateway == $payment_method['value']) selected @endif >{{$payment_method['title']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-updatall la-updateall-holder">
        {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
    </div>
{!! Form::close() !!}
