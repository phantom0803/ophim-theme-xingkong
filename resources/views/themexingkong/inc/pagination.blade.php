@php
    $pageRange = 3;
@endphp
@if ($paginator->hasPages())
    <div class="text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        @else
            <a class="btn btn-light" title="Trang trước" href="{{ $paginator->previousPageUrl() }}"> &lt;&lt; </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="btn btn-light disabled" href="#">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="btn btn-custom disabled" title="Trang {{$page}}" href="#">{{$page}}</a>
                    @else
                        @if (($page > $paginator->currentPage() && $page < ($paginator->currentPage() + $pageRange)) || $page < $paginator->currentPage() && $page > ($paginator->currentPage() - $pageRange))
                            <a class="btn btn-light" title="Trang {{$page}}" href="{{$url}}"> {{$page}}</a>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-light" title="Trang tiếp" href="{{ $paginator->nextPageUrl() }}">&gt;&gt;</a>
        @else
        @endif
    </div>
@endif
