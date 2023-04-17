<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    <style>
        .pagination-btn-container {
            margin-right: 1px;
        }
    </style>
</head>
<body>
  
</body>
</html>

@if ($paginator->onFirstPage())
    <span class="pagination-previous disabled">Previous</span>
    @else
    <div class="pagination-btn-container">
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous" rel="prev">Previous</a>
    </div>
    @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" rel="next">Next</a>
@else
    <span class="pagination-next disabled">Next</span>
@endif
        </ul>
    </nav>
