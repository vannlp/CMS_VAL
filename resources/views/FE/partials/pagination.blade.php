@if ($paginator->hasPages())
    <nav>
        <ul>
            {{-- Link về trang trước --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__arrow pagination__item" style="display: none">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="pagination__arrow pagination__item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}#list-chapters" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Các số trang --}}
            @foreach ($elements as $element)
                {{-- Dấu "..." --}}
                @if (is_string($element))
                    <li class="pagination__item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Danh sách số trang --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            
                            <li class="pagination__item  page-current" aria-current="page">
                                <a class="page-link"
                                    href="{{ $url }}#list-chapters"
                                    style="cursor: pointer;">{{ $page }}</a>
                            </li>
                        @else
                            <li class="pagination__item">
                                <a class="page-link"
                                    href="{{ $url }}#list-chapters"
                                    style="cursor: pointer;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Link tới trang tiếp theo --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__arrow pagination__item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}#list-chapters" rel="next"> &raquo;</a>
                </li>
            @else
                <li class="pagination__arrow pagination__item" style="display: none">
                    <span class="page-link"> &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif