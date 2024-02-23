@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@push('header')
@endpush

@section('body')
    @include('themes::themexingkong.inc.header')
    @if (get_theme_option('ads_header'))
        <div id="top-banner">
            {!! get_theme_option('ads_header') !!}
        </div>
    @endif

    @yield('content')
@endsection

@push('scripts')
@endpush

@section('footer')
    {!! get_theme_option('footer') !!}

    @if (get_theme_option('ads_catfish'))
        <div id="catfish-banner">
            {!! get_theme_option('ads_catfish') !!}
        </div>
    @endif

    {!! setting('site_scripts_google_analytics') !!}
@endsection
