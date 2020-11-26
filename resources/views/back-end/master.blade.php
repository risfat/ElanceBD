@extends('master') 
@push('stylesheets')
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dbresponsive.css') }}" rel="stylesheet">
@endpush 
@section('header')
	@include('includes.header')
@endsection
@section('main')
	<main id="wt-main" class="wt-main wt-haslayout">
		@if (Auth::user())
			@include('back-end.includes.dashboard-menu')
		@endif
		@yield('content')
	</main>
@endsection
@push('scripts')
@endpush
