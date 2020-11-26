@extends('back-end.master') 
@section('content')
    <div class="langs-listing" id="lang-list">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @endif 
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{ trans('lang.add_lang') }}}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open(['url' => url('admin/store-language'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory','id' =>
                            'languages']) !!}
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::text( 'language_title', null, ['class' =>'form-control'.($errors->has('language_title') ? ' is-invalid' : ''), 
                                    'placeholder' => trans('lang.ph_lang_title')] ) !!}
                                    <span class="form-group-description">{{{ trans('lang.desc') }}}</span>
                                    @if ($errors->has('language_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('language_title') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea( 'language_desc', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ) !!}
                                    <span class="form-group-description">{{{ trans('lang.cat_desc') }}}</span>
                                </div>
                                <div class="form-group wt-btnarea">
                                    {!! Form::submit(trans('lang.add_lang'), ['class' => 'wt-btn']) !!}
                                </div>
                            </fieldset>
                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2>{{{ trans('lang.langs') }}}</h2>
                            {!! Form::open(['url' => url('admin/languages/search'), 'method' => 'get', 'class' =>'wt-formtheme wt-formsearch']) !!}
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}" 
                                            class="form-control" placeholder="{{{ trans('lang.ph_search_langs') }}}">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                        @if ($langs->count() > 0)
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input id="wt-name" type="checkbox" name="head">
                                                    <label for="wt-name"></label>
                                                </span>
                                            </th>
                                            <th>{{{ trans('lang.name') }}}</th>
                                            <th>{{{ trans('lang.slug') }}}</th>
                                            <th>{{{ trans('lang.action') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($langs as $lang)
                                            <tr class="del-{{{ $lang->id }}}" v-bind:id="langID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-{{{ $counter }}}" type="checkbox" name="head">
                                                        <label for="wt-check-{{{ $counter }}}"></label>
                                                    </span>
                                                </td>
                                                <td>{{{ $lang->title }}}</td>
                                                <td>{{{ $lang->slug }}}</td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="{{{ url('admin/languages/edit-langs') }}}/{{{ $lang->id }}}" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{$lang->id}}'" :message="'{{trans("lang.ph_lang_delete_message")}}'" :url="'{{url('admin/languages/delete-langs')}}'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                @if( method_exists($langs,'links') ) {{ $langs->links('pagination.custom') }} @endif
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
