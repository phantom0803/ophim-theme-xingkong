@extends('themes::themexingkong.layout')

@push('header')
    <style>
        #wrapper-video {
            height: 505px !important;
        }

        @media only screen and (max-width: 500px) {
            #wrapper-video {
                height: 210px !important;
            }
        }

        @media only screen and (min-width: 501px) and (max-width: 767px) {
            #wrapper-video {
                height: 286px !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            #wrapper-video {
                height: 388px !important;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            #wrapper-video {
                height: 525px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="col-lg-wide-8 col-xs-1 padding-0">
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel-bd">
                    <div class="stui-player col-pd">
                        <div id="wrapper-video" class="stui-player__video clearfix">

                        </div>
                        <div class="stui-player__detail detail">
                            <ul class="more-btn">
                                <li>
                                    <div class="" style="display: flex;gap:5px">
                                        @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                            <button onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}"
                                                data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                                class="streaming-server btn btn-default">VIP
                                                #{{ $loop->index + 1 }}</button>
                                        @endforeach
                                    </div>

                                </li>
                                <li>
                                    <button class="btn btn-default" id="report_error">Báo lỗi
                                        <i class="icon iconfont icon-close "></i>
                                    </button>
                                </li>
                            </ul>
                            <h1 class="title">
                                <a href="{{ $episode->getUrl() }}">Tập {{ $episode->name }}</a>
                            </h1>
                            <p>
                                <span class="title">Đổi nguồn phát VIP #1, VIP #2 khi lỗi.</span>

                            </p>
                            <div class="col-sm-12">
                                <div id="movies-rating-star"></div>
                                ({{ $currentMovie->getRatingStar() }}
                                sao
                                /
                                {{ $currentMovie->getRatingCount() }} đánh giá)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
            <div class="stui-pannel stui-pannel-bg clearfix">
                <div class="stui-pannel-box b playlist mb">
                    <div class="stui-pannel_hd">
                        <div class="stui-pannel__head bottom-line active clearfix">
                            <span class="more text-muted pull-right"></span>
                            <h3 class="title"> Phim {{ $currentMovie->name }} - {{ $server }} </h3>
                        </div>
                    </div>
                    <div class="stui-pannel_bd col-pd clearfix">
                        <ul class="stui-content__playlist clearfix">
                            @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                <li class="@if ($item->contains($episode)) active @endif"><a
                                        href="{{ $item->sortByDesc('type')->first()->getUrl() }}">Tập
                                        {{ $name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head clearfix">
                        <h3 class="title">
                            <img src="{{ asset('themes/xingkong/img/icon_30.png') }}" /> Nội dung phim
                        </h3>
                    </div>
                </div>
                <div class="stui-pannel_bd">
                    <p class="col-pd detail">
                        <span class="detail-sketch">
                            {!! Str::limit(strip_tags($currentMovie->content), 300, '...') !!}
                        </span>
                        <span class="detail-content" style="display: none;">
                            {!! strip_tags($currentMovie->content) !!}
                        </span>
                        <a class="detail-more" href="javascript:;">Xem thêm <i class="icon iconfont icon-moreunfold"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        @include('themes::themexingkong.inc.related_movie')
        @include('themes::themexingkong.inc.comment')
    </div>
    @include('themes::themexingkong.inc.right_bar')
@endsection

@push('scripts')
    <script src="/themes/xingkong/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/xingkong/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('wrapper-video');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;

            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('btn-primary');
            })
            el.classList.add('btn-primary');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/xingkong/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }

                const resumeData = 'OPCMS-PlayerPosition-' + id;

                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
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

    <script>
        $("#report_error").click(() => {
            fetch("{{ route('episodes.report', ['movie' => $currentMovie->slug, 'episode' => $episode->slug, 'id' => $episode->id]) }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    message: ''
                })
            });
            $("#report_error").remove();
            alert("Báo lỗi thành công!")
        })
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
