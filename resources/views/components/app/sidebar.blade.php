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
        <div class="flex justify-center mb-5 sm:px-2">
            <!-- Logo -->
            <a class="block bg-white rounded-full p-2">
                <img src="{{ asset('assets/logo.svg') }}" alt="logo" class="size-20">
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
                        <a href="{{ route('dashboard') }}" class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('dashboard')) {{ 'hover:text-slate-200' }} @endif">
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

                    <!-- Instructors -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('instructors.*') ? 'bg-slate-900' : '' }}">
                        <a class="block text-slate-200 hover:text-white transition duration-150 {{ request()->routeIs('instructors.*') ? 'hover:text-slate-200' : '' }}" href="{{ route('instructors.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current {{ request()->routeIs('instructors.*') ? 'text-indigo-500' : 'text-slate-400' }}" d="M18.974 8H22a2 2 0 012 2v6a2 2 0 01-2 2h-1v5l-4-5h-2a2 2 0 01-2-2V8a2 2 0 012-2h2.974zM2.82 8H6a2 2 0 012 2v6a2 2 0 01-2 2H4v5l-4-5H0a2 2 0 01-2-2V8a2 2 0 012-2h2.82z" />
                                </svg>
                                <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Instructors</span>
                            </div>
                        </a>
                    </li>

                    <!-- Courses -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('courses.*') ? 'bg-slate-900' : '' }}">
                        <a class="block text-slate-200 hover:text-white transition duration-150 {{ request()->routeIs('courses.*') ? 'hover:text-slate-200' : '' }}" href="{{ route('courses.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current {{ request()->routeIs('courses.*') ? 'text-indigo-500' : 'text-slate-400' }}" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2z" />
                                </svg>
                                <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Courses</span>
                            </div>
                        </a>
                    </li>

                    <!-- Gallery -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('gallery.*') ? 'bg-slate-900' : '' }}">
                        <a class="block text-slate-200 hover:text-white transition duration-150 {{ request()->routeIs('gallery.*') ? 'hover:text-slate-200' : '' }}" href="{{ route('gallery.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current {{ request()->routeIs('gallery.*') ? 'text-indigo-500' : 'text-slate-400' }}" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Gallery</span>
                            </div>
                        </a>
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
