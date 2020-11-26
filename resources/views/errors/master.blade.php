@extends('master') 
@push('stylesheets')
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush 
@section('header')
	@include('includes.header')
@endsection
@section('main')
<main id="wt-main" class="wt-main wt-haslayout">
	@include('back-end.includes.dashboard-menu')
	@yield('content')
</main>
@endsection
@push('scripts')
@endpush
