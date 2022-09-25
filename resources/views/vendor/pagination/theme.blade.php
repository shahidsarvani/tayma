@if ($paginator->hasPages())
    <ul class="pagination pagination-flat pagination-rounded align-self-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">← &nbsp; Prev</a></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link">← &nbsp;
                    Prev</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">{{ $element }}</a></li>
                {{-- <li class="disabled" aria-disabled="true"><span></span></li> --}}
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a href="javascript:void(0)"
                                class="page-link">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next &nbsp; →</a></li>
        @else
            <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">Next &nbsp; →</a></li>
        @endif
    </ul>
@endif
