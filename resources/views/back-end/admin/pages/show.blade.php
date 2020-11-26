@extends('front-end.master', ['body_class' => 'wt-innerbgcolor']) 
@section('content')
    @php $breadcrumbs = Breadcrumbs::generate('showPage',$page, $slug); @endphp 
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                        @if (!empty($page))
                            <div class="wt-title">
                                <h2>{{{ $page->title }}}</h2>
                            </div>
                        @endif
                        @if (count($breadcrumbs))
                            <ol class="wt-breadcrumb">
                                @foreach ($breadcrumbs as $breadcrumb) 
                                    @if ($breadcrumb->url && !$loop->last)
                                        <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                                    @else
                                        <li class="active">{{{ $breadcrumb->title }}}</li>
                                    @endif 
                                @endforeach
                            </ol>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($page))
        <div class="wt-contentwrappers">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                        <div class="wt-howitwork-hold wt-haslayout">
                            <div class="wt-haslayout wt-main-section">
                                @php echo htmlspecialchars_decode(stripslashes($page->body)); @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
        @include('errors.404')
    @endif
@endsection