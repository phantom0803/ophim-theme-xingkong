@extends('themes::themexingkong.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')->distinct()->pluck('publish_year')->sortDesc();
    });
@endphp

@push('header')
@endpush

@section('content')
    <div class="col-lg-wide-8 col-xs-1 padding-0">
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel_hd">
                    @include('themes::themexingkong.inc.catalog_filter')
                </div>
                <div class="stui-pannel_hd">
                    <h1>{{ $section_name }}</h1>
                </div>
                <div class="stui-pannel_bd">
                    <ul class="stui-vodlist clearfix">
                        @foreach ($data as $movie)
                            <li class="col-md-5 col-sm-4 col-xs-3">
                                <div class="stui-vodlist__box">
                                    <a class="stui-vodlist__thumb lazyload" href="{{ $movie->getUrl() }}"
                                        title="{{ $movie->name }}" data-original="{{ $movie->getThumbUrl() }}">
                                        <span class="play hidden-xs"></span>
                                        <span class="pic-text text-right">{{ $movie->episode_current }}</span>
                                    </a>
                                    <div class="stui-vodlist__detail">
                                        <h4 class="title text-overflow">
                                            <a href="{{ $movie->getUrl() }}"
                                                title="{{ $movie->name }}">{{ $movie->name }}</a>
                                        </h4>
                                        <p class="text text-overflow text-muted hidden-xs">{{ $movie->origin_name }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{ $data->appends(request()->all())->links('themes::themexingkong.inc.pagination') }}
    </div>
    @include('themes::themexingkong.inc.right_bar')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(".score").each(function() {
            var star = $(this).find(".branch").text().replace(".", "0.");
            $(this).find("#score").css("width", "" + star + "%");
        });
    </script>
@endpush
