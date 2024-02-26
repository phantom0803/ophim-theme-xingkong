@extends('themes::layout')

@php
@endphp

@push('header')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('themes/xingkong/css/iconfont.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('themes/xingkong/css/stui_block.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('themes/xingkong/css/stui_block_color.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('themes/xingkong/css/stui_default.css') }}" type="text/css" />

    <script type="text/javascript" src="{{ asset('themes/xingkong/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/xingkong/js/stui_default.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/xingkong/js/stui_block.js') }}"></script>
@endpush

@section('body')
    @include('themes::themexingkong.inc.header')
    @if (get_theme_option('ads_header'))
        <div class="container">
            <div id="top-banner">
                {!! get_theme_option('ads_header') !!}
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

@section('footer')
    {!! get_theme_option('footer') !!}

    @if (get_theme_option('ads_catfish'))
        <div class="container">
            <div id="catfish-banner">
                {!! get_theme_option('ads_catfish') !!}
            </div>
        </div>
    @endif

    {!! setting('site_scripts_google_analytics') !!}
@endsection
