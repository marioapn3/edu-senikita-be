@extends('layouts.app')



@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Course</h1>
            </div>
            <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
                <a href="{{ route('courses.index') }}" class="text-white bg-late-500 btn hover:bg-slate-600">
                    <span class="ml-2">Back to Courses</span>
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Title <span class="text-rose-500">*</span></label>
                            <input id="title" class="form-input w-full" type="text" name="title" value="{{ old('title', $course->title) }}" required />
                            @error('title')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="description">Description <span class="text-rose-500">*</span></label>
                            <textarea id="description" class="form-textarea w-full" name="description" rows="4" required>{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                      <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="categories">Category <span class="text-rose-500">*</span></label>
                            <select multiple="" data-hs-select='{
                                "placeholder": "Select categories...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }' class="hidden" name="categories[]" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $course->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Level -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="level">Level <span class="text-rose-500">*</span></label>
                            <select id="level" class="form-select w-full" name="level" required>
                                <option value="">Select a level</option>
                                <option value="pemula" {{ old('level', $course->level) == 'pemula' ? 'selected' : '' }}>Pemula</option>
                                <option value="menengah" {{ old('level', $course->level) == 'menengah' ? 'selected' : '' }}>Menengah</option>
                                <option value="lanjutan" {{ old('level', $course->level) == 'lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                            </select>
                            @error('level')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="status">Status <span class="text-rose-500">*</span></label>
                            <select id="status" class="form-select w-full" name="status" required>
                                <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Certificate Available -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="certificate_available">Certificate Available</label>
                            <div class="flex items-center">
                                <input id="certificate_available" class="form-checkbox" type="checkbox" name="certificate_available" value="1" {{ old('certificate_available', $course->certificate_available) ? 'checked' : '' }} />
                                <span class="ml-2">Yes, this course provides a certificate upon completion</span>
                            </div>
                            @error('certificate_available')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Video -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="preview_video">Preview Video URL</label>
                            <input id="preview_video" class="form-input w-full" type="url" name="preview_video" value="{{ old('preview_video', $course->preview_video) }}" />
                            @error('preview_video')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Thumbnail -->
                        @if($course->thumbnail)
                        <div>
                            <label class="block text-sm font-medium mb-1">Current Thumbnail</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-16 h-16 object-cover rounded">
                                <div class="text-sm text-slate-500">Current thumbnail</div>
                            </div>
                        </div>
                        @endif

                        <!-- New Thumbnail -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="thumbnail">New Thumbnail</label>
                            <input id="thumbnail" class="form-input w-full" type="file" name="thumbnail" accept="image/*" />
                            @error('thumbnail')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                                Update Course
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
