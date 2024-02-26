<div class="col-lg-wide-2 col-xs-1 stui-pannel-side visible-lg">
    @foreach ($tops as $top)
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="col-pd clearfix">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head bottom-line active clearfix">
                        <h3 class="title"> {{ $top['label'] }} </h3>
                    </div>
                </div>
                <div class="stui-pannel_bd">
                    <ul class="stui-vodlist__media active col-pd clearfix">
                        @foreach ($top['data'] as $movie)
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
    @endforeach
</div>
