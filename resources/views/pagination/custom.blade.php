@if ($paginator->hasPages())
    <nav class="wt-pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="wt-prevpage"><a href="javascript:void"><i class="lnr lnr-chevron-left"></i></a></li>
            @else
                <li class="wt-prevpage"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"> <i class="lnr lnr-chevron-left"></i></a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="wt-active"><span>0{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">0{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="wt-nextpage"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="lnr lnr-chevron-right"></i></a></li>
            @else
                <li class="disabled wt-nextpage"><a href="javascript:void"><i class="lnr lnr-chevron-right"></i></a></li>
            @endif
        </ul>
    </nav>
@endif