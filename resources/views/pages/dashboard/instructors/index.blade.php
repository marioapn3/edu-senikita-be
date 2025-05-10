@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Instructors</h1>
            </div>
            <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
                <a href="{{ route('instructors.create') }}" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                    <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="ml-2">Add Instructor</span>
                </a>
            </div>
        </div>

        <!-- Instructors Table -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left border-b border-slate-200">
                                <th class="px-2 py-3 font-medium text-slate-500">Name</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Email</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Phone</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Expertise</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instructors as $instructor)
                            <tr class="border-b border-slate-200">
                                <td class="px-2 py-3">
                                    <div class="flex items-center">
                                        @if($instructor->photo)
                                            <img class="w-8 h-8 rounded-full mr-3" src="{{ $instructor->photo }}" alt="{{ $instructor->name }}">
                                        @endif
                                        <div class="font-medium text-slate-800">{{ $instructor->name }}</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 text-slate-500">{{ $instructor->email }}</td>
                                <td class="px-2 py-3 text-slate-500">{{ $instructor->phone }}</td>
                                <td class="px-2 py-3 text-slate-500">{{ $instructor->expertise }}</td>
                                <td class="px-2 py-3">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('instructors.edit', $instructor->id) }}" class="text-indigo-500 hover:text-indigo-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600" onclick="return confirm('Are you sure you want to delete this instructor?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $instructors->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
