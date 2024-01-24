<ul class="d-flex justify-content-center">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li aria-disabled="true" aria-label="@lang('pagination.previous')">
            <a class="prev" aria-hidden="true"><i class="sli sli-arrow-left"></i></a>
        </li>
    @else
        <li>
            <a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="sli sli-arrow-left"></i></a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
        <li aria-disabled="true"><a>{{ $element }}</a></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
        @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
                <li aria-current="page"><a class="active">{{ $page }}</a></li>
            @else
                <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li>
            <a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="sli sli-arrow-right"></i></a>
        </li>
    @else
        <li aria-disabled="true" aria-label="@lang('pagination.next')">
            <a class="next" aria-hidden="true"><i class="sli sli-arrow-right"></i></a>
        </li>
    @endif
</ul>
