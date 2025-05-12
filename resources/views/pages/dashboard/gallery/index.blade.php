@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Final Submissions</h1>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="p-6 mb-8 bg-white rounded-sm shadow-lg">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="file_path" class="block text-sm font-medium text-slate-700">Upload File</label>
                        <input type="file" name="file_path" id="file_path" class="block w-full mt-1 text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        "/>
                        @error('file_path')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                            <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span class="ml-2">Upload Submission</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left border-b border-slate-200">
                                <th class="px-2 py-3 font-medium text-slate-500">User</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Lesson</th>
                                <th class="px-2 py-3 font-medium text-slate-500">File</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Preview</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Status</th>
                                <th class="px-2 py-3 font-medium text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($finalSubmissions as $submission)
                            <tr class="border-b border-slate-200">
                                <td class="px-2 py-3">
                                    <div class="font-medium text-slate-800">{{ $submission->user->name }}</div>
                                </td>
                                <td class="px-2 py-3 text-slate-500">
                                    {{ $submission->lesson->title }}
                                </td>
                                <td class="px-2 py-3 text-slate-500">
                                    @if($submission->file_path)
                                        <a href="{{ asset($submission->file_path) }}" class="text-indigo-500 hover:text-indigo-600" target="_blank">
                                            View File
                                        </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td class="px-2 py-3">
                                  @if ($submission->file_path)
                                    <img src="{{ asset($submission->file_path) }}" alt="Preview" class="w-16 h-16">
                                  @endif
                                </td>
                                <td class="px-2 py-3">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $submission->is_published ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $submission->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-2 py-3">
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('gallery.destroy', $submission->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600" title="Delete Submission" onclick="return confirm('Are you sure you want to delete this submission?')">
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
                    {{ $finalSubmissions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
