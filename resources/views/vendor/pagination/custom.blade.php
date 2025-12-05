@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center gap-1">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-pill px-3">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill px-3" href="{{ $paginator->previousPageUrl() }}">‹</a>
                </li>
            @endif

            {{-- Numbers --}}
            @foreach ($elements as $element)

                {{-- "..." --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link rounded-pill px-3">{{ $element }}</span></li>
                @endif

                {{-- Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link rounded-pill px-3">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-pill px-3" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill px-3" href="{{ $paginator->nextPageUrl() }}">›</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link rounded-pill px-3">›</span></li>
            @endif

        </ul>
    </nav>
@endif
