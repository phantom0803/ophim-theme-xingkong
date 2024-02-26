<div class="stui-pannel stui-pannel-bg clearfix">
    <div class="stui-pannel-box clearfix">
        <div class="stui-pannel-bd">
            <div class="carousel carousel_default flickity-page">
                @foreach ($recommendations as $movie)
                    <div class="col-xs-1">
                        <a href="{{ $movie->getUrl() }}" class="stui-vodlist__thumb banner" title="{{ $movie->name }}"
                            style="background: url({{ $movie->getPosterUrl() }}) no-repeat; background-position:50% 50%; background-size: cover;">
                            <span class="pic-text text-center">{{ $movie->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
