@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
    <!-- Header -->
    <div class="mb-8 sm:flex sm:justify-between sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $course->title }}</h1>
            <p class="mt-2 text-sm text-slate-500">Manage your course lessons</p>
        </div>
        <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
            <a href="{{ route('courses.lessons.create', $course->id) }}" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="ml-2">Add Lesson</span>
            </a>
            <a href="{{ route('courses.index') }}" class="text-slate-600 bg-white border-slate-200 btn hover:bg-slate-50">
                <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm3.5 10.5l-1.4 1.4L8 9.4l-2.1 2.1-1.4-1.4L6.6 8 4.5 5.9l1.4-1.4L8 6.6l2.1-2.1 1.4 1.4L9.4 8l2.1 2.1z" />
                </svg>
                <span class="ml-2">Back to Courses</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Course Overview -->
    <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2">
        <!-- Course Stats -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <h2 class="mb-4 text-lg font-semibold text-slate-800">Course Overview</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-200">
                        <span class="text-sm font-medium text-slate-500">Total Lessons</span>
                        <span class="text-sm font-medium text-slate-800">{{ count($lessons) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-200">
                        <span class="text-sm font-medium text-slate-500">Course Type</span>
                        <span class="text-sm font-medium text-slate-800">{{ $course->type }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-slate-500">Status</span>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $course->status === 'published' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Description -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <h2 class="mb-4 text-lg font-semibold text-slate-800">Course Description</h2>
                <p class="text-sm text-slate-600">{{ $course->description }}</p>
            </div>
        </div>
    </div>

    <!-- Lessons List -->
    <div class="bg-white rounded-sm shadow-lg mb-8">
        <div class="p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800">Lessons</h2>
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left border-b border-slate-200">
                            <th class="px-2 py-3 font-medium text-slate-500">Order</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Title</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Type</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Duration</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Status</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lessons as $lesson)
                        <tr class="border-b border-slate-200">
                            <td class="px-2 py-3 text-sm text-slate-500">{{ $lesson['order'] }}</td>
                            <td class="px-2 py-3">
                                <div class="font-medium text-slate-800">{{ $lesson['title'] }}</div>
                            </td>
                            <td class="px-2 py-3 text-sm text-slate-500">{{ ucfirst($lesson['type']) }}</td>
                            <td class="px-2 py-3 text-sm text-slate-500">{{ $lesson['duration'] }} minutes</td>
                            <td class="px-2 py-3">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $lesson['is_completed'] ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ $lesson['is_completed'] ? 'Completed' : 'Not Started' }}
                                </span>
                            </td>
                            <td class="px-2 py-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('courses.lessons.show', [$course->id, $lesson['slug']]) }}"
                                       class="text-emerald-500 hover:text-emerald-600"
                                       title="View Lesson">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('courses.lessons.edit', [$course->id, $lesson['id']]) }}"
                                       class="text-indigo-500 hover:text-indigo-600"
                                       title="Edit Lesson">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('courses.lessons.destroy', [$course->id, $lesson['id']]) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-rose-500 hover:text-rose-600"
                                                title="Delete Lesson"
                                                onclick="return confirm('Are you sure you want to delete this lesson?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-2 py-3 text-sm text-center text-slate-500">
                                No lessons found. Create your first lesson!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SneakPeek and Requirements --}}
    <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2">
        <!-- SneakPeek Section -->
        <div class="bg-white rounded-sm shadow-lg h-full">
            <div class="p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-800">SneakPeek</h2>
                    <button onclick="openSneakPeekModal()" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                        <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="ml-2">Add SneakPeek</span>
                    </button>
                </div>
                <div id="sneakpeek-list" class="space-y-3 flex-grow">
                    @forelse($course->sneakpeeks as $sneakpeek)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600">{{ $sneakpeek->text }}</p>
                        <div class="flex items-center space-x-2">
                            <button onclick="editSneakPeek({{ $sneakpeek->id }}, '{{ $sneakpeek->text }}')" class="text-indigo-500 hover:text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('courses.sneakpeek.delete', $sneakpeek->id) }}" method="POST" class="inline-flex items-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-600" onclick="return confirm('Are you sure you want to delete this sneakpeek?')">
                                    <svg class="w-4 h-4 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500">No sneakpeeks added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Requirements Section -->
        <div class="bg-white rounded-sm shadow-lg h-full">
            <div class="p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-800">Requirements</h2>
                    <button onclick="openRequirementModal()" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                        <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="ml-2">Add Requirement</span>
                    </button>
                </div>
                <div id="requirements-list" class="space-y-3 flex-grow">
                    @forelse($course->requirements as $requirement)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600">{{ $requirement->text }}</p>
                        <div class="flex items-center space-x-2">
                            <button onclick="editRequirement({{ $requirement->id }}, '{{ $requirement->text }}')" class="text-indigo-500 hover:text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('courses.requirement.delete', $requirement->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-600" onclick="return confirm('Are you sure you want to delete this requirement?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500">No requirements added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Materials Section -->
    <div class="bg-white rounded-sm shadow-lg mb-8">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-800">Additional Materials</h2>
                <button onclick="openAdditionalMaterialModal()" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                    <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="ml-2">Add Material</span>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left border-b border-slate-200">
                            <th class="px-2 py-3 font-medium text-slate-500">Title</th>
                            <th class="px-2 py-3 font-medium text-slate-500">File</th>
                            <th class="px-2 py-3 font-medium text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->additionalMaterials as $material)
                        <tr class="border-b border-slate-200">
                            <td class="px-2 py-3">
                                <div class="font-medium text-slate-800">{{ $material->title }}</div>
                            </td>
                            <td class="px-2 py-3 text-sm text-slate-500">
                                @if($material->file_path)
                                    <a href="{{ $material->file_path }}" target="_blank" class="text-indigo-500 hover:text-indigo-600">
                                        View File
                                    </a>
                                @else
                                    No file attached
                                @endif
                            </td>
                            <td class="px-2 py-3">
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('courses.additional-material.delete', $material->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-600" onclick="return confirm('Are you sure you want to delete this material?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-2 py-3 text-sm text-center text-slate-500">
                                No additional materials found. Add your first material!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SneakPeek Modal -->
<div id="sneakpeek-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form id="sneakpeek-form" method="POST">
                @csrf
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="sneakpeek-modal-title">Add SneakPeek</h3>
                    <div class="mt-4">
                        <label for="sneakpeek-text" class="block text-sm font-medium text-gray-700">Text</label>
                        <textarea id="sneakpeek-text" name="text" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">Save</button>
                    <button type="button" onclick="closeSneakPeekModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Requirement Modal -->
<div id="requirement-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form id="requirement-form" method="POST">
                @csrf
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="requirement-modal-title">Add Requirement</h3>
                    <div class="mt-4">
                        <label for="requirement-text" class="block text-sm font-medium text-gray-700">Text</label>
                        <textarea id="requirement-text" name="text" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">Save</button>
                    <button type="button" onclick="closeRequirementModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Additional Material Modal -->
<div id="additional-material-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form id="additional-material-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="additional-material-modal-title">Add Material</h3>
                    <input type="text" name="course_id" value="{{ $course->id }}">
                    <div class="mt-4">
                        <label for="material-title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="material-title" name="title" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mt-4">
                        <label for="material-file" class="block text-sm font-medium text-gray-700">File</label>
                        <input type="file" id="material-file" name="file" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">Save</button>
                    <button type="button" onclick="closeAdditionalMaterialModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


<script>
    // SneakPeek Modal Functions
    function openSneakPeekModal() {
        document.getElementById('sneakpeek-modal').classList.remove('hidden');
        document.getElementById('sneakpeek-form').action = "{{ route('courses.sneakpeek.create', $course->id) }}";
        document.getElementById('sneakpeek-modal-title').textContent = 'Add SneakPeek';
        document.getElementById('sneakpeek-text').value = '';
    }

    function closeSneakPeekModal() {
        document.getElementById('sneakpeek-modal').classList.add('hidden');
    }

    function editSneakPeek(id, text) {
        document.getElementById('sneakpeek-modal').classList.remove('hidden');
        document.getElementById('sneakpeek-form').action = `/courses/sneakpeek/${id}`;
        document.getElementById('sneakpeek-modal-title').textContent = 'Edit SneakPeek';
        document.getElementById('sneakpeek-text').value = text;
        document.getElementById('sneakpeek-form').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
    }

    // Requirement Modal Functions
    function openRequirementModal() {
        document.getElementById('requirement-modal').classList.remove('hidden');
        document.getElementById('requirement-form').action = "{{ route('courses.requirement.create', $course->id) }}";
        document.getElementById('requirement-modal-title').textContent = 'Add Requirement';
        document.getElementById('requirement-text').value = '';
    }

    function closeRequirementModal() {
        document.getElementById('requirement-modal').classList.add('hidden');
    }

    function editRequirement(id, text) {
        document.getElementById('requirement-modal').classList.remove('hidden');
        document.getElementById('requirement-form').action = `/courses/requirement/${id}`;
        document.getElementById('requirement-modal-title').textContent = 'Edit Requirement';
        document.getElementById('requirement-text').value = text;
        document.getElementById('requirement-form').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
    }

    // Additional Material Modal Functions
    function openAdditionalMaterialModal() {
        document.getElementById('additional-material-modal').classList.remove('hidden');
        document.getElementById('additional-material-form').action = "{{ route('courses.additional-material.create', $course->id) }}";
        document.getElementById('additional-material-modal-title').textContent = 'Add Material';
        document.getElementById('material-title').value = '';
        document.getElementById('material-file').value = '';
    }

    function closeAdditionalMaterialModal() {
        document.getElementById('additional-material-modal').classList.add('hidden');
    }
</script>
