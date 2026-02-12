@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 mt-6">
    {{-- First Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed" aria-disabled="true" aria-label="First Page">&laquo;&laquo;</span>
    @else
        <a href="{{ $paginator->url(1) }}" class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700" aria-label="First Page">&laquo;&laquo;</a>
    @endif

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed" aria-disabled="true" aria-label="Previous Page">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700" rel="prev" aria-label="Previous Page">&laquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span class="px-3 py-1">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="px-3 py-1 rounded-md bg-blue-600 text-white font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700" rel="next" aria-label="Next Page">&raquo;</a>
    @else
        <span class="px-3 py-1 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed" aria-disabled="true" aria-label="Next Page">&raquo;</span>
    @endif

    {{-- Last Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700" aria-label="Last Page">&raquo;&raquo;</a>
    @else
        <span class="px-3 py-1 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed" aria-disabled="true" aria-label="Last Page">&raquo;&raquo;</span>
    @endif
</nav>
@endif
