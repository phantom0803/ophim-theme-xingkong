<div class="stui-pannel stui-pannel-bg clearfix">
    <div class="stui-pannel-box">
        <div class="stui-pannel_hd">
            <div class="stui-pannel__head bottom-line active clearfix">
                <h3 class="title">
                    <img src="{{ asset('themes/xingkong/img/icon_6.png') }}" /> Có thể bạn sẽ thích?
                </h3>
            </div>
        </div>
        <div class="stui-pannel_bd">
            <ul class="stui-vodlist__bd clearfix">
                @foreach ($movie_related as $movie)
                    <li class="col-md-6 col-sm-4 col-xs-3 ">
                        <div class="stui-vodlist__box">
                            <a class="stui-vodlist__thumb lazyload" href="{{ $movie->getUrl() }}"
                                title="{{ $movie->name }}" data-original="{{ $movie->getThumbUrl() }}">
                                <span class="play hidden-xs"></span>
                                <span class="pic-text text-right">{{ $movie->episode_current }}</span>
                            </a>
                            <div class="stui-vodlist__detail">
                                <h4 class="title text-overflow">
                                    <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}">{{ $movie->name }}</a>
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
