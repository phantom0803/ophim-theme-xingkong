@extends('themes::themexingkong.layout')

@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@push('header')
@endpush

@section('content')
    <div class="col-lg-wide-8 col-xs-1 padding-0">
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box clearfix">
                <div class="stui-pannel_bd clearfix">
                    <div class="stui-content col-pd clearfix">
                        <div class="stui-content__thumb">
                            <a class="stui-vodlist__thumb picture v-thumb" href="{{ $watch_url }}"
                                title="{{ $currentMovie->name }}">
                                <img class="lazyload" src="{{ asset('themes/xingkong/img/load.gif') }}"
                                    data-original="{{ $currentMovie->getThumbUrl() }}" />
                                <span class="play active hidden-xs"></span>
                                <span class="pic-text text-right">{{ $currentMovie->episode_current }}</span>
                            </a>
                        </div>
                        <div class="stui-content__detail">
                            <h1 class="title">{{ $currentMovie->name }}</h1>
                            <p class="data">
                            <h2>{{ $currentMovie->origin_name }}</h2>
                            </p>
                            <p class="movie-rating">
                                <span id="movies-rating-star"></span>
                            </p>
                            <p class="data">
                                <span class="text-muted hidden-xs">Thể Loại: </span>
                                {!! $currentMovie->categories->map(function ($category) {
                                        return '<a href="' . $category->getUrl() . '">' . $category->name . '</a>';
                                    })->implode(', ') !!}
                                <span class="split-line"></span>
                                <span class="text-muted hidden-xs">Quốc gia: </span>

                                {!! $currentMovie->regions->map(function ($region) {
                                        return '<a href="' . $region->getUrl() . '">' . $region->name . '</a>';
                                    })->implode(', ') !!}

                                <span class="split-line"></span>
                                <span class="text-muted hidden-xs">Năm: </span>{{ $currentMovie->publish_year }}
                            </p>
                            <p class="data">

                            </p>
                            <p class="data">
                                <span class="text-muted">Ngôn ngữ: </span>{{ $currentMovie->language }} <span
                                    class="split-line"></span>
                                <span class="text-muted hidden-xs">Chất lượng: </span>{{ $currentMovie->quality }}
                            </p>
                            <p class="data">
                                <span class="text-muted">Diễn viên: </span>
                                {!! $currentMovie->actors->map(function ($actor) {
                                        return '<a href="' . $actor->getUrl() . '">' . $actor->name . '</a>';
                                    })->implode(', ') !!}
                            </p>
                            <p class="data">
                                <span class="text-muted">Đạo diễn: </span>
                                {!! $currentMovie->directors->map(function ($director) {
                                        return '<a href="' . $director->getUrl() . '">' . $director->name . '</a>';
                                    })->implode(', ') !!}
                            </p>
                            <p class="desc detail hidden-xs">
                                <span class="left text-muted">Nội dung:</span>
                                <span class="detail-sketch">
                                    {!! Str::limit(strip_tags($currentMovie->content), 60, '...') !!}
                                </span>
                                <span class="detail-content" style="display: none;">
                                    {!! strip_tags($currentMovie->content) !!}
                                </span>
                                <a class="detail-more" href="javascript:;">Xem thêm <i
                                        class="icon iconfont icon-moreunfold"></i>
                                </a>
                            </p>
                            <div class="play-btn clearfix">
                                <div class="share bdsharebuttonbox hidden-sm hidden-xs pull-right"></div>
                                @if ($watch_url)
                                    <a class="btn btn-primary" href="{{ $watch_url }}">Xem Phim</a>
                                @endif
                                @if (strpos($currentMovie->trailer_url, 'youtube'))
                                    <a href="javascript:void(0);" class="btn btn-default" id="show-trailer">Trailer</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($watch_url)
            <div class="stui-pannel stui-pannel-bg clearfix">
                <div class="stui-pannel-box b playlist mb">
                    <div class="stui-pannel_hd">
                        <div class="stui-pannel__head bottom-line active clearfix">
                            <span class="more text-muted pull-right"></span>
                            <h3 class="title"> Xem phim {{ $currentMovie->name }} </h3>
                        </div>
                    </div>
                    <div class="stui-pannel_bd col-pd clearfix">
                        <ul class="stui-content__playlist clearfix">
                            @php
                                $currentMovie->episodes
                                    ->sortBy([['name', 'desc'], ['type', 'desc']])
                                    ->sortByDesc('name', SORT_NATURAL)
                                    ->unique('name')
                                    ->take(8)
                                    ->map(function ($episode) {
                                        echo '<li><a href="' . $episode->getUrl() . '">Tập ' . $episode->name . '</a></li>';
                                    });
                            @endphp
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @include('themes::themexingkong.inc.related_movie')
        @include('themes::themexingkong.inc.comment')
    </div>

    @include('themes::themexingkong.inc.right_bar')

    @if (strpos($currentMovie->trailer_url, 'youtube'))
        @php
            try {
                parse_str(parse_url($currentMovie->trailer_url, PHP_URL_QUERY), $parse_url);
                $trailer_id = $parse_url['v'];
            } catch (\Throwable $th) {
                $trailer_id = '';
            }
        @endphp
        <div class="stui-modal fade" id="modal-trailer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="stui-modal__dialog">
                <div class="stui-modal__content">
                    <div class="stui-pannel clearfix">
                        <div class="stui-pannel-box clearfix">
                            <div class="stui-pannel_hd">
                                <div class="stui-pannel__head active bottom-line clearfix">
                                    <a href="javascript:;" class="more close pull-right" data-dismiss="modal"
                                        aria-hidden="true">
                                        <i class="icon iconfont icon-close"></i>
                                    </a>
                                    <h3 class="title">Trailer phim {{ $currentMovie->name }}</h3>
                                </div>
                            </div>
                            <div class="stui-pannel_bd clearfix">
                                <iframe src="https://www.youtube.com/embed/{{ $trailer_id }}"
                                    style="width: 100%;height: 100%;" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#show-trailer").click(function() {
                $("#modal-trailer").modal('show');
            })
        })
    </script>
    <script src="/themes/xingkong/plugins/jquery-raty/jquery.raty.js"></script>
    <link href="/themes/xingkong/plugins/jquery-raty/jquery.raty.css" rel="stylesheet" type="text/css" />
    <script>
        var rated = false;
        $('#movies-rating-star').raty({
            score: {{ $currentMovie->getRatingStar() }},
            number: 10,
            numberMax: 10,
            hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                'rất hay', 'siêu phẩm'
            ],
            starOff: '/themes/xingkong/plugins/jquery-raty/images/star-off.png',
            starOn: '/themes/xingkong/plugins/jquery-raty/images/star-on.png',
            starHalf: '/themes/xingkong/plugins/jquery-raty/images/star-half.png',
            click: function(score, evt) {
                if (rated) return
                fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    },
                    body: JSON.stringify({
                        rating: score
                    })
                });
                rated = true;
                $('#movies-rating-star').data('raty').readOnly(true);
                alert(`Bạn đã đánh giá ${score} sao cho phim này!`);
            }
        });
    </script>
    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
