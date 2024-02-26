@php
    $pageRange = 3;
@endphp
@if ($paginator->hasPages())
    <ul class="stui-page text-center clearfix">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        @else
            <li><a title="Trang trước" href="{{ $paginator->previousPageUrl() }}"> &lt;&lt; </a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="hidden-xs active"><a title="Trang {{ $page }}"
                                href="#">{{ $page }}</a></li>
                        <li class="active visible-xs">
                            <span class="num">{{ $page }}/{{ $paginator->total() }}</span>
                        </li>
                    @else
                        @if (
                            ($page > $paginator->currentPage() && $page < $paginator->currentPage() + $pageRange) ||
                                ($page < $paginator->currentPage() && $page > $paginator->currentPage() - $pageRange))
                            <li class="hidden-xs">
                                <a title="Trang {{ $page }}" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a title="Trang tiếp" href="{{ $paginator->nextPageUrl() }}">&gt;&gt;</a></li>
        @else
        @endif
    </ul>
@endif
