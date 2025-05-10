@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Category</h1>
            </div>
            <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
                <a href="{{ route('categories.index') }}" class="text-white bg-slate-500 btn hover:bg-slate-600">
                    <span class="ml-2">Back to Categories</span>
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name" value="{{ old('name', $category->name) }}" required />
                            @error('name')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="description">Description</label>
                            <textarea id="description" class="form-textarea w-full" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="status">Status</label>
                            <select id="status" class="form-select w-full" name="status">
                                <option value="draft" {{ old('status', $category->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $category->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status', $category->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Thumbnail -->
                        @if($category->thumbnail)
                        <div>
                            <label class="block text-sm font-medium mb-1">Current Thumbnail</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $category->thumbnail) }}" alt="{{ $category->name }}" class="w-16 h-16 object-cover rounded">
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
                                Update Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
