@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
    @php
        $settings = array();
        $pages = App\Page::all();
        $setting = \App\SiteManagement::getMetaValue('settings');
        $logo = '/images/logo.png';
        $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
    @endphp
@endif
<header id="wt-header" class="wt-header wt-haslayout {{$inner_header}}">
    <div class="wt-navigationarea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @auth
                        {{ Helper::displayEmailWarning() }}
                    @endauth
                    @if (!empty($logo) || Schema::hasTable('site_managements'))
                        <strong class="wt-logo">
                          <a href="{{{ url('/') }}}"><h4><b> ElanceBD</b></h4></a> 
                        <!--<a href="{{{ url('/') }}}"><img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}">--></a></strong>
                    @endif
                    @if (Route::getCurrentRoute()->uri() != '/')
                        <search-form></search-form>
                    @endif
                    <div class="wt-rightarea">
                        <nav id="wt-nav" class="wt-nav navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="lnr lnr-menu"></i>
                            </button>
                            <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
                                <ul class="navbar-nav">
                                    @if (!empty($pages) || Schema::hasTable('pages'))
                                        @foreach ($pages as $page)
                                            @php  $page_has_child = App\Page::pageHasChild($page->id); $pageID = Request::segment(2); @endphp
                                            @if ($page->relation_type == 0)
                                                <li class="{{!empty($page_has_child) ? 'menu-item-has-children page_item_has_children' : '' }} @if ($pageID == $page->slug ) current-menu-item @endif">
                                                    <a href="{{url('page/'.$page->slug)}}">{{{$page->title}}}</a>
                                                    @if (!empty($page_has_child))
                                                        <ul class="sub-menu">
                                                            @foreach($page_has_child as $parent)
                                                                @php $child = App\Page::getChildPages($parent->child_id);@endphp
                                                                <li class="@if ($pageID == $child->slug ) current-menu-item @endif">
                                                                    <a href="{{url('page/'.$child->slug.'/')}}">
                                                                        {{{$child->title}}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <li>
                                        <a href="{{url('search-results?type=freelancer')}}">
                                            {{{ trans('lang.view_freelancers') }}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('search-results?type=employer')}}">
                                            {{{ trans('lang.view_employers') }}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('search-results?type=job')}}">
                                            {{{ trans('lang.browse_jobs') }}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        @guest
                            <div class="wt-loginarea">
                                <figure class="wt-userimg">
                                    <img src="{{ asset('images/user-login.png') }}" alt="{{ trans('lang.img') }}">
                                </figure>
                                <div class="wt-loginoption">
                                    <a href="javascript:void(0);" id="wt-loginbtn" class="wt-loginbtn">{{{trans('lang.login') }}}</a>
                                    <div class="wt-loginformhold" @if ($errors->has('email') || $errors->has('password')) style="display: block;" @endif>
                                        <div class="wt-loginheader">
                                            <span>{{{ trans('lang.login') }}}</span>
                                            <a href="javascript:;"><i class="fa fa-times"></i></a>
                                        </div>
                                        <form method="POST" action="{{ route('login') }}" class="wt-formtheme wt-loginform do-login-form">
                                            @csrf
                                            <fieldset>
                                                <div class="form-group">
                                                    <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        placeholder="Email" required autofocus>
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input id="password" type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        placeholder="Password" required>
                                                    @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="wt-logininfo">
                                                        <button type="submit" class="wt-btn do-login-button">{{{ trans('lang.login') }}}</button>
                                                    <span class="wt-checkbox">
                                                        <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label for="remember">{{{ trans('lang.remember') }}}</label>
                                                    </span>
                                                </div>
                                            </fieldset>
                                            <div class="wt-loginfooterinfo">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="wt-forgot-password">{{{ trans('lang.forget_pass') }}}</a>
                                                @endif
                                                <a href="{{{ route('register') }}}">{{{ trans('lang.create_account') }}}</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <a href="{{{ route('register') }}}" class="wt-btn">{{{ trans('lang.join_now') }}}</a>
                            </div>
                        @endguest
                        @auth
                            @php
                                $user = !empty(Auth::user()) ? Auth::user() : '';
                                $role = !empty($user) ? $user->getRoleNames()->first() : array();
                                $profile = \App\User::find($user->id)->profile;
                                $user_image = !empty($profile) ? $profile->avater : '';
                                $employer_job = \App\Job::select('status')->where('user_id', Auth::user()->id)->first();
                                $profile_image = !empty($user_image) ? '/uploads/users/'.$user->id.'/'.$user_image : 'images/user-login.png';
                            @endphp
                                <div class="wt-userlogedin">
                                    <figure class="wt-userimg">
                                        <img src="{{{ asset($profile_image) }}}" alt="{{{ trans('lang.user_avatar') }}}">
                                    </figure>
                                    <div class="wt-username">
                                        <h3>{{{ Helper::getUserName(Auth::user()->id) }}}</h3>
                                        <span>{{{ !empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 26, '') : Auth::user()->getRoleNames()->first() }}}</span>
                                    </div>
                                    @include('back-end.includes.profile-menu')
                                </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
