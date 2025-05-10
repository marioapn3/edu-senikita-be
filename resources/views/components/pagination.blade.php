<div class="flex flex-col mt-2 sm:flex-row sm:items-center sm:justify-between">
    <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
        <ul class="flex justify-center">
            @if ($paginator->onFirstPage())
                <li class="ml-3 first:ml-0">
                    <span class="bg-white cursor-not-allowed btn border-slate-200 text-slate-300">&lt;- Previous</span>
                </li>
            @else
                <li class="ml-3 first:ml-0">
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="text-indigo-500 bg-white btn border-slate-200 hover:border-slate-300">&lt;- Previous</a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li class="ml-3 first:ml-0">
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="text-indigo-500 bg-white btn border-slate-200 hover:border-slate-300">Next -&gt;</a>
                </li>
            @else
                <li class="ml-3 first:ml-0">
                    <span class="bg-white cursor-not-allowed btn border-slate-200 text-slate-300">Next -&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
    <div class="text-sm text-center text-slate-500 sm:text-left">
        Showing <span class="font-medium text-slate-600">{{ $paginator->firstItem() }}</span> to <span
            class="font-medium text-slate-600">{{ $paginator->lastItem() }}</span> of <span
            class="font-medium text-slate-600">{{ $paginator->total() }}</span> results
    </div>
</div>
