@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header class="stui-header__top clearfix">
    <div class="stui-header__bar clearfix">
        <div class="container">
            <div class="row">
                <div class="stui-header__logo">
                    <a href="/">
                        @if ($logo)
                            {!! $logo !!}
                        @else
                            {!! $brand !!}
                        @endif
                    </a>
                </div>
                <div class="stui-header__search">
                    <form action="/" method="GET">
                        <input type="text" name="search" class="mac_wd form-control" value="{{ request('search') }}"
                            placeholder="Tìm kiếm phim..." />
                        <button class="submit" type="submit">
                            <i class="icon iconfont icon-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="stui-header__menu clearfix">
        <div class="container">
            <div class="row">
                <ul class="">
                    @foreach ($menu as $key => $item)
                        @if (count($item['children']))
                            <li class="dropdown">
                                <a href="{{ $item['link'] }}">{{ $item['name'] }} <i
                                        class="icon iconfont icon-moreunfold"></i></a>
                                <ul class="submenu">
                                    @foreach ($item['children'] as $children)
                                        <li class="">
                                            <a href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ $item['link'] }}">{{ $item['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>
