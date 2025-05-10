{{-- resources/views/components/breadcrumb.blade.php --}}
@props(['links'])

<ul class="inline-flex flex-wrap mb-4 text-sm font-medium">
    @foreach ($links as $link)
        <li class="flex items-center">
            @if (!$loop->last)
                <a class="text-slate-500 hover:text-indigo-500" href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                <svg class="w-4 h-4 mx-3 fill-current text-slate-400" viewBox="0 0 16 16">
                    <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                </svg>
            @else
                <span class="text-slate-500">{{ $link['name'] }}</span>
            @endif
        </li>
    @endforeach
</ul>
