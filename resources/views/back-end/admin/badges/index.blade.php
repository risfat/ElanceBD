@extends('back-end.master')
@section('content')
    <div class="cats-listing" id="cat-list">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 float-left">
                    <div class="wt-dashboardbox  la-color-picker-form-wrapper">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{ trans('lang.add_badge') }}}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open([ 'url' => url('admin/store-badge'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory','id'=> 'categories'])!!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text( 'badge_title', null, ['class' =>'form-control'.($errors->has('badge_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_badge_title')] ) !!}
                                        <span class="form-group-description">{{{ trans('lang.desc') }}}</span>
                                        @if ($errors->has('badge_title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('badge_title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="wt-settingscontent">
                                        <div class = "wt-formtheme wt-userform">
                                            <upload-image
                                                :id="'badge_image'"
                                                :img_ref="'badge_ref'"
                                                :url="'{{url('admin/badges/upload-temp-image')}}'"
                                                :name="'uploaded_image'"
                                                >
                                            </upload-image>
                                            {!! Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ) !!}
                                        </div>
                                    </div>
                                    <div class="form-group la-color-picker">
                                        <verte display="widget" v-model="color" menuPosition="left" model="hex"></verte>
                                        <input type="hidden" name="color" :value="color">
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        {!! Form::submit(trans('lang.add_badge'), ['class' => 'wt-btn']) !!}
                                    </div>
                                </fieldset>
                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2>{{{ trans('lang.badges') }}}</h2>
                            {!! Form::open(['url' => url('admin/badges/search'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']) !!}
                                <fieldset>
                                    <div class="form-group">
                                        <input type="search" name="s" value="{{{ !empty($_GET['s']) ? $_GET['s'] : '' }}}" class="form-control" placeholder="{{{ trans('lang.ph_search_badges') }}}">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                        @if ($badges->count() > 0)
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories la-badges">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input id="wt-name" type="checkbox" name="head">
                                                    <label for="wt-name"></label>
                                                </span>
                                            </th>
                                            <th>{{{ trans('lang.badge_icon') }}}</th>
                                            <th>{{{ trans('lang.name') }}}</th>
                                            <th>{{{ trans('lang.slug') }}}</th>
                                            <th>{{{ trans('lang.action') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($badges as $badge)
                                            <tr class="del-{{{ $badge->id }}}">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-{{{ $counter }}}" type="checkbox" name="head">
                                                        <label for="wt-check-{{{ $counter }}}"></label>
                                                    </span>
                                                </td>
                                                <td data-th="Icon"><span class="bt-content"><figure style="background-color:{{ $badge->color }}"><img src="{{{ asset(Helper::getBadgeImage($badge->image)) }}}" alt="{{{ $badge->title }}}"></figure></span></td>
                                                <td>{{{ $badge->title }}}</td>
                                                <td>{{{ $badge->slug }}}</td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="{{{ url('admin/badges/edit-badges') }}}/{{{ $badge->id }}}" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ $badge->id }}'" :message="'{{trans("lang.ph_badge_delete_message")}}'" :url="'{{url('admin/badges/delete-badges')}}'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ( method_exists($badges,'links') )
                                    {{ $badges->links('pagination.custom') }}
                                @endif
                            </div>
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
