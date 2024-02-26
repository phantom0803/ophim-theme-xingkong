@extends('themes::themexingkong.layout')


@php
    use Ophim\Core\Models\Movie;
    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)->limit(get_theme_option('recommendations_limit', 10))->orderBy('updated_at', 'desc')->get();
    });
    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $link, $template] = array_merge($list, ['Phim mới cập nhật', '', 'type', 'series', 'created_at', 'desc', 8, '/', 'default']);
                try {
                    $top = null;
                    if ($template === 'with_top') {
                        $top = Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy('view_week', 'desc')
                            ->limit(9)
                            ->get();
                    }
                    $data[] = [
                        'label' => $label,
                        'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
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
                        'top' => $top,
                        'link' => $link ?: '#',
                        'template' => $template,
                    ];
                } catch (\Exception $e) {
                }
            }
        }
        return $data;
    });
@endphp

@push('header')
    <style type="text/css">
        .stui-vodlist__thumb.banner {
            padding-top: 30%;
        }

        @media (max-width:767px) {
            .stui-vodlist__thumb.banner {
                padding-top: 45%;
            }
        }
    </style>
@endpush

@section('content')
    @include('themes::themexingkong.inc.slider_recommended')

    @foreach ($data as $item)
        @include('themes::themexingkong.inc.sections.' . $item['template'])
    @endforeach
@endsection

@push('scripts')
    <script type="text/javascript">
        $(".score").each(function() {
            var star = $(this).find(".branch").text().replace(".", "0.");
            $(this).find("#score").css("width", "" + star + "%");
        });
    </script>
@endpush
