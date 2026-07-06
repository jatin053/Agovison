@if ($paginator->hasPages())
    <nav class="admin-pagination" role="navigation" aria-label="Pagination">
        <p class="admin-pagination__summary">
            Showing <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
            of <strong>{{ $paginator->total() }}</strong>
        </p>

        <div class="admin-pagination__links">
            @if ($paginator->onFirstPage())
                <span class="admin-pagination__button is-disabled" aria-disabled="true">Previous</span>
            @else
                <a class="admin-pagination__button" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="admin-pagination__ellipsis">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <span class="admin-pagination__page is-current" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="admin-pagination__page" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="admin-pagination__button" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            @else
                <span class="admin-pagination__button is-disabled" aria-disabled="true">Next</span>
            @endif
        </div>
    </nav>
@endif
