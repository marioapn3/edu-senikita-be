<div
    class="flex px-3 py-6 overflow-x-scroll border-b flex-nowrap no-scrollbar md:block md:overflow-auto md:border-b-0 md:border-r border-slate-200 min-w-60 md:space-y-3">
    <!-- Group 1 -->
    <div>
        <div class="mb-3 text-xs font-semibold uppercase text-slate-400">System Settings</div>
        <ul class="flex mr-3 flex-nowrap md:block md:mr-0">
            @can('View Role')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap @if (Route::is('roles.index')) {{ 'bg-indigo-50' }} @endif"
                        href="{{ route('roles.index') }}">

                        <i
                            class="fa-solid fa-user-gear fill-current text-slate-400 mr-1 @if (Route::is('roles.index')) {{ 'text-indigo-400' }} @endif"></i>
                        <span
                            class="text-sm font-medium @if (Route::is('roles.index')) {{ 'text-indigo-500' }}@else{{ 'text-slate-600 hover:text-slate-700' }} @endif">Roles</span>
                    </a>
                </li>
            @endcan
            @can('View User')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap @if (Route::is('users.index')) {{ 'bg-indigo-50' }} @endif"
                        href="{{ route('users.index') }}">
                        <i
                            class="fa-solid fa-user fill-current text-slate-400 mr-2 @if (Route::is('users.index')) {{ 'text-indigo-400' }} @endif"></i>
                        <span
                            class="text-sm font-medium @if (Route::is('users.index')) {{ 'text-indigo-500' }}@else{{ 'text-slate-600 hover:text-slate-700' }} @endif">
                            Users</span>
                    </a>
                </li>
            @endcan


        </ul>
    </div>

</div>
