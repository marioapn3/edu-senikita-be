
@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
    <!-- Header -->
    <div class="mb-8 sm:flex sm:justify-between sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ isset($lesson) ? 'Edit Lesson' : 'Create New Lesson' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Fill in the lesson details below</p>
        </div>
        <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
            <a href="{{ route('courses.show', $courseId) }}" class="text-slate-600 bg-white border-slate-200 btn hover:bg-slate-50">
                <svg class="w-4 h-4 opacity-50 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm3.5 10.5l-1.4 1.4L8 9.4l-2.1 2.1-1.4-1.4L6.6 8 4.5 5.9l1.4-1.4L8 6.6l2.1-2.1 1.4 1.4L9.4 8l2.1 2.1z" />
                </svg>
                <span class="ml-2">Back to Lessons</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-sm shadow-lg">
        <div class="p-6">
            <form action="{{ isset($lesson) ? route('courses.lessons.update', [$courseId, $lesson->id]) : route('courses.lessons.store', $courseId) }}"
                  method="POST">
                @csrf
                @if(isset($lesson))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Title -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700" for="title">Title</label>
                        <input type="text"
                               class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-rose-500 @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $lesson->title ?? '') }}"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="order">Order</label>
                        <input type="number"
                               class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('order') border-rose-500 @enderror"
                               id="order"
                               name="order"
                               value="{{ old('order', $lesson->order ?? '') }}"
                               required>
                        @error('order')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="type">Type</label>
                        <select class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-rose-500 @enderror"
                                id="type"
                                name="type"
                                required>
                            <option value="lesson" {{ (old('type', $lesson->type ?? '') == 'lesson') ? 'selected' : '' }}>Lesson</option>
                            <option value="quiz" {{ (old('type', $lesson->type ?? '') == 'quiz') ? 'selected' : '' }}>Quiz</option>
                            <option value="final" {{ (old('type', $lesson->type ?? '') == 'final') ? 'selected' : '' }}>Final</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- submission type --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="submission_type">Submission Type</label>
                        <small class="text-gray-500">Pilih jika type final</small>
                        <select class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('submission_type') border-rose-500 @enderror"
                                id="submission_type"
                                name="submission_type">


                            <option value="">Pilih jika type final</option>
                            <option value="text" {{ (old('submission_type', $lesson->submission_type ?? '') == 'text') ? 'selected' : '' }}>Text</option>
                            <option value="file" {{ (old('submission_type', $lesson->submission_type ?? '') == 'file') ? 'selected' : '' }}>File</option>
                        </select>
                        @error('submission_type')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700" for="description">Description</label>
                        <textarea class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-rose-500 @enderror"
                                  id="description"
                                  name="description"
                                  rows="3">{{ old('description', $lesson->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700" for="content">Content</label>
                        <textarea class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('content') border-rose-500 @enderror"
                                  id="content"
                                  name="content">{{ old('content', $lesson->content ?? '') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video URL -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700" for="video_url">Video URL</label>
                        <input type="url"
                               class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('video_url') border-rose-500 @enderror"
                               id="video_url"
                               name="video_url"
                               value="{{ old('video_url', $lesson->video_url ?? '') }}">
                        @error('video_url')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="duration">Duration (minutes)</label>
                        <input type="number"
                               class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-rose-500 @enderror"
                               id="duration"
                               name="duration"
                               value="{{ old('duration', $lesson->duration ?? '') }}">
                        @error('duration')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <a href="{{ route('courses.lessons.index', $courseId) }}"
                       class="text-slate-600 bg-white border-slate-200 btn hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                            class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                        {{ isset($lesson) ? 'Update Lesson' : 'Create Lesson' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    });
</script>

