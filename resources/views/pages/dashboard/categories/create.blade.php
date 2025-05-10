@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create Category</h1>
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
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name" value="{{ old('name') }}" required />
                            @error('name')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="description">Description</label>
                            <textarea id="description" class="form-textarea w-full" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="status">Status</label>
                            <select id="status" class="form-select w-full" name="status">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thumbnail -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="thumbnail">Thumbnail</label>
                            <input id="thumbnail" class="form-input w-full" type="file" name="thumbnail" accept="image/*" />
                            @error('thumbnail')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                                Create Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
