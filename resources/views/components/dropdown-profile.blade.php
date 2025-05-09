@props([
    'align' => 'right',
])

<div class="relative inline-flex" x-data="{ open: false }">
    <button class="inline-flex items-center justify-center group" aria-haspopup="true" @click.prevent="open = !open"
        :aria-expanded="open">
        <img class="w-8 h-8 rounded-full"
            src="{{ Auth::user()->profile_photo_url ? asset(Auth::user()->profile_photo_url) : asset('images/default_pp.jpg') }}"
            width="32" height="32" alt="{{ Auth::user()->name }}" />
        <div class="flex items-center truncate">
            <span class="ml-2 text-sm font-medium truncate group-hover:text-slate-800">{{ Auth::user()->name }}</span>
            <svg class="w-3 h-3 ml-1 fill-current shrink-0 text-slate-400" viewBox="0 0 12 12">
                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
            </svg>
        </div>
    </button>
    <div class="origin-top-right z-10 absolute top-full min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1 {{ $align === 'right' ? 'right-0' : 'left-0' }}"
        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-cloak>
        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
            <div class="font-medium text-slate-800">{{ Auth::user()->name }}</div>
            <div class="text-xs italic text-slate-500">Adminw</div>
        </div>
        <ul>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="flex items-center px-3 py-1 text-sm font-medium text-indigo-500 hover:text-indigo-600"
                        type="submit">
                        Keluar
                    </button>

                </form>



            </li>
        </ul>
    </div>
</div>
