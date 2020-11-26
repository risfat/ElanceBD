@extends('back-end.master') 
@section('content')
    <div class="pages-listing" id="pages-list">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @endif @if ($errors->any())
            <ul class="wt-jobalerts">
                @foreach ($errors->all() as $error)
                <div class="flash_msg">
                    <flash_messages :message_class="'danger'" :time='10' :message="'{{{ $error }}}'" v-cloak></flash_messages>
                </div>
                @endforeach
            </ul>
        @endif
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2>{{{ trans('lang.add_page') }}}</h2>
                            <div class="wt-rightarea">
                                <a href="{{{ url('admin/create/pages') }}}" class="wt-btn">{{{ trans('lang.create_page') }}}</a>
                            </div>
                        </div>
                        @if ($pages->count() > 0)
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
                                        @foreach ($pages as $page)
                                            <tr class="del-{{{ $page->id }}}" v-bind:id="pageID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-{{{ $counter }}}" type="checkbox" name="head">
                                                        <label for="wt-check-{{{ $counter }}}"></label>
                                                    </span>
                                                </td>
                                                <td>{{{ $page->title }}}</td>
                                                <td>{{{ $page->slug }}}</td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="{{{ url('admin/pages/edit-page') }}}/{{{ $page->id }}}" class="wt-addinfo wt-pages">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{$page->id}}'" :message="'{{trans("lang.ph_page_delete_message")}}'" :url="'{{url('admin/pages/delete-page')}}'"></delete>                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp 
                                        @endforeach
                                    </tbody>
                                </table>
                                @if( method_exists($pages,'links') ) {{ $pages->links('pagination.custom') }} @endif
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