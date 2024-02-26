<div class="stui-pannel clearfix">
    <div class="stui-pannel-box padding-0">
        <div class="col-lg-wide-8 col-xs-1 padding-0">
            <div class="col-pd stui-pannel-bg">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head bottom-line active clearfix">
                        <a class="more text-muted pull-right" href="{{ $item['link'] }}">Xem thêm <i
                                class="icon iconfont icon-more"></i>
                        </a>
                        <h3 class="title">
                            <img src="{{ asset('themes/xingkong/img/icon_1.png') }}" alt="{{ $item['label'] }}" />
                            <a href="{{ $item['link'] }}">{{ $item['label'] }}</a>
                        </h3>
                    </div>
                </div>
                <div class="stui-pannel_bd clearfix">
                    <ul class="stui-vodlist clearfix">
                        @foreach ($item['data'] as $movie)
                            <li class="col-md-5 col-sm-4 col-xs-3 ">
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
                                        <p class="text text-overflow text-muted hidden-xs">{{ $movie->origin_name }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-wide-2 stui-pannel-side hidden-md hidden-sm hidden-xs">
            <div class="col-pd stui-pannel-bg clearfix">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head bottom-line active clearfix">
                        <h3 class="title"> Top tuần </h3>
                    </div>
                </div>
                <div class="stui-pannel_bd">
                    <ul class="stui-vodlist__media active col-pd clearfix">
                        @foreach ($item['top'] as $movie)
                            <li class="top-line-dot">
                                <div class="thumb">
                                    <a class="stui-vodlist__thumb" href="{{ $movie->getUrl() }}"
                                        title="{{ $movie->name }}"
                                        style="width: 33.5px; background-image: url({{ $movie->getThumbUrl() }});"></a>
                                </div>
                                <div class="detail detail-side" style="padding-top: 5px;">
                                    <p class="margin-0 text_single-line">
                                        <a href="{{ $movie->getUrl() }}">{{ $movie->name }}</a>
                                    </p>
                                    <div class="score">
                                        <div class="star">
                                            <span class="star-cur" id="score"></span>
                                        </div>
                                        <span class="branch">{{ $movie->getRatingStar() }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
