@if ($pagination->hasPages)
  <nav class="d-flex justify-items-center justify-content-between">
    <div class="d-flex justify-content-center flex-fill d-sm-none">
      <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($pagination->onFirstPage)
          <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">&lsaquo;</span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $pagination->previousPageUrl }}"
              rel="prev">&lsaquo;</a>
          </li>
        @endif

        {{-- Next Page Link --}}
        @if ($pagination->hasMorePages)
          <li class="page-item">
            <a class="page-link" href="{{ $pagination->nextPageUrl }}" rel="next">&rsaquo;</a>
          </li>
        @else
          <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">&rsaquo;</span>
          </li>
        @endif
      </ul>
    </div>

    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
      <div>
        <p class="small text-muted">
          {!! __('Showing') !!}
          <span class="fw-semibold">{{ $pagination->firstItem }}</span>
          {!! __('to') !!}
          <span class="fw-semibold">{{ $pagination->lastItem }}</span>
          {!! __('of') !!}
          <span class="fw-semibold">{{ $pagination->total }}</span>
          {!! __('results') !!}
        </p>
      </div>

      <div>
        <ul class="pagination">
          {{-- Previous Page Link --}}
          @if ($pagination->onFirstPage)
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
              <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $pagination->previousPageUrl }}" rel="prev"
                aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
          @endif

          {{-- Pagination Elements --}}
          @foreach ($pagination->links as $page => $url)
            @if ($page + 1 == $pagination->currentPage)
              <li class="page-item active" aria-current="page"><span class="page-link">{{ $page + 1 }}</span>
              </li>
            @else
              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page + 1 }}</a>
              </li>
            @endif
          @endforeach

          {{-- Next Page Link --}}
          @if ($pagination->hasMorePages)
            <li class="page-item">
              <a class="page-link" href="{{ $pagination->nextPageUrl }}" rel="next"
                aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
          @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
              <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
@endif
