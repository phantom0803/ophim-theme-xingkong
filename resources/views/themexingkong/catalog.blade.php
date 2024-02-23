@extends('themes::themexingkong.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')->distinct()->pluck('publish_year')->sortDesc();
    });
@endphp

@push('header')
@endpush

@section('content')
    {{-- {{ $data->appends(request()->all())->links('themes::themexingkong.inc.pagination') }} --}}
@endsection
