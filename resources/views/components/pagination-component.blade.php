@props(['paginator'])

@if (isset($paginator) && $paginator->hasPages())
    <div class="pagination-footer">
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="page-link disabled" disabled aria-label="Previous page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" aria-label="Previous page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                </a>
            @endif

            {{-- Numeric Page Links --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($i == $paginator->currentPage())
                    <button class="page-link active">{{ $i }}</button>
                @else
                    <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" aria-label="Next page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            @else
                <button class="page-link disabled" disabled aria-label="Next page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            @endif
        </div>
    </div>
@endif
