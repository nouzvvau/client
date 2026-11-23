@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="admin-pagination" aria-label="Navigasi halaman">
        <span class="admin-pagination__info">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </span>

        <div class="admin-pagination__links">
            @if ($paginator->onFirstPage())
                <span class="admin-pagination__link is-disabled" aria-disabled="true">
                    <x-admin.icon name="chevron-left" /> Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="admin-pagination__link">
                    <x-admin.icon name="chevron-left" /> Sebelumnya
                </a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="admin-pagination__link is-current" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="admin-pagination__link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="admin-pagination__link">
                    Selanjutnya <x-admin.icon name="chevron-right" />
                </a>
            @else
                <span class="admin-pagination__link is-disabled" aria-disabled="true">
                    Selanjutnya <x-admin.icon name="chevron-right" />
                </span>
            @endif
        </div>
    </nav>
@endif
