<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 z-40 transition-opacity duration-200 bg-slate-900 bg-opacity-30 lg:hidden lg:z-auto"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Sidebar header -->
        <div class="flex justify-between pr-3 mb-10 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block">
                <svg width="32" height="32" viewBox="0 0 32 32">
                    <defs>
                        <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                            <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                            <stop stop-color="#A5B4FC" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                            <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                            <stop stop-color="#38BDF8" offset="100%" />
                        </linearGradient>
                    </defs>
                    <rect fill="#6366F1" width="32" height="32" rx="16" />
                    <path
                        d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z"
                        fill="#4F46E5" />
                    <path
                        d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z"
                        fill="url(#logo-a)" />
                    <path
                        d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z"
                        fill="url(#logo-b)" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="pl-3 text-xs font-semibold uppercase text-slate-500">
                    <span class="hidden w-6 text-center lg:block lg:sidebar-expanded:hidden 2xl:hidden"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('dashboard')) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard')) {{ 'hover:text-slate-200' }} @endif">
                            <div class="flex items-center">
                                <i class="fa-solid fa-chart-pie text-2xl text-slate-400 @if (Request::is('dashboard')) {{ 'text-slate-200' }} @endif"></i>
                                <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <!-- Categories -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('categories*')) {{ 'bg-slate-900' }} @endif">
                        <a href="{{ route('categories.index') }}" class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('categories*')) {{ 'hover:text-slate-200' }} @endif">
                            <div class="flex items-center">
                                <i class="fa-solid fa-tags text-2xl text-slate-400 @if (Request::is('categories*')) {{ 'text-slate-200' }} @endif"></i>
                                <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Categories</span>
                            </div>
                        </a>
                    </li>

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('dashboard/hsk-groups*')) {{ 'bg-slate-900' }} @endif"
                        x-data="{ open: {{ Request::is('dashboard/hsk-groups*') ? 'true' : 'false' }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard/hsk-groups*')) {{ 'hover:text-slate-200' }} @endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="pl-[2px] text-2xl fa-solid fa-database text-slate-400 @if (Request::is('dashboard/hsk-groups*')) {{ 'text-slate-200' }} @endif"></i>
                                    <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Data Kelompok HSK</span>
                                </div>
                                <div class="flex ml-2 duration-200 shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if (Request::is('dashboard/hsk-groups*')) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if (!Request::is('dashboard/hsk-groups*')) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Route::is('hsk-groups.sipil.index')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Kelompok HSK Sipil</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Route::is('hsk-groups.pipa.index')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Kelompok HSK Pipa</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('dashboard/hsk/*')) {{ 'bg-slate-900' }} @endif"
                        x-data="{ open: {{ Request::is('dashboard/hsk/*') ? 'true' : 'false' }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard/hsk/*')) {{ 'hover:text-slate-200' }} @endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-file pl-[2px] text-2xl text-slate-400 @if (Request::is('dashboard/hsk/*')) {{ 'text-slate-200' }} @endif"></i>
                                    <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Data HSK</span>
                                </div>
                                <div class="flex ml-2 duration-200 shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if (Request::is('dashboard/hsk/*')) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if (!in_array(Request::segment(1), ['hsk'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Route::is('hsk.sipil.index')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">HSK Sipil</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Route::is('hsk.pipa.index')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">HSK Pipa</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('dashboard/rab/*')) {{ 'bg-slate-900' }} @endif"
                        x-data="{ open: {{ Request::is('dashboard/rab/*') ? 'true' : 'false' }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard/rab/*')) {{ 'hover:text-slate-200' }} @endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-calculator pl-[2px] text-2xl text-slate-400 @if (Request::is('dashboard/rab/*')) {{ 'text-white' }} @endif"></i>
                                    <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Data RAB</span>
                                </div>
                                <div class="flex ml-2 duration-200 shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if (Request::is('dashboard/rab/*')) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if (!in_array(Request::segment(1), ['rab'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Request::is('dashboard/rab/sipil*')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">RAB Sipil</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Request::is('dashboard/rab/pipa*')) {{ '!text-indigo-500' }} @endif">
                                        <span class="text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">RAB Pipa</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- More group -->
            <div>
                <h3 class="pl-3 text-xs font-semibold uppercase text-slate-500">
                    <span class="hidden w-6 text-center lg:block lg:sidebar-expanded:hidden 2xl:hidden" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                </h3>
                <ul class="mt-3">
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('dashboard/roles*') || Request::is('dashboard/users')) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard/roles*') || Request::is('dashboard/users')) {{ 'hover:text-slate-200' }} @endif">
                            <div class="flex items-center">
                                <i class="text-2xl fa-solid fa-gear pl-[2px] text-slate-400 @if (Request::is('dashboard/roles*') || Request::is('dashboard/users*')) {{ 'text-white' }} @endif"></i>
                                <span class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">Settings</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="justify-end hidden pt-3 mt-auto lg:inline-flex 2xl:hidden">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
