<div class="stui-pannel stui-pannel-bg clearfix">
    <div class="stui-pannel-box clearfix">
        <div class="stui-pannel_bd clearfix">
            <div class="stui-pannel_hd">
                <div class="stui-pannel__head clearfix">
                    <h3 class="title">
                        <img src="{{ asset('themes/xingkong/img/icon_30.png') }}" /> Bình luận
                    </h3>
                </div>
            </div>
            <div class="stui-pannel_bd">
                <div style="width: 100%; background-color: #fff">
                    <div style="width: 100%; background-color: #fff" class="fb-comments"
                        data-href="{{ $currentMovie->getUrl() }}" data-width="100%" data-colorscheme="light"
                        data-numposts="5" data-order-by="reverse_time" data-lazy="true"></div>
                </div>
            </div>
        </div>
    </div>
</div>
