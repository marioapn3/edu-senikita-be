@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Header -->
        <div class="mb-8 sm:flex sm:justify-between sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create Instructor</h1>
            </div>
            <div class="grid justify-start grid-flow-col gap-2 sm:auto-cols-max sm:justify-end">
                <a href="{{ route('instructors.index') }}" class="text-white bg-slate-500 btn hover:bg-slate-600">
                    <span class="ml-2">Back to Instructors</span>
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-sm shadow-lg">
            <div class="p-6">
                <form action="{{ route('instructors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name" value="{{ old('name') }}" required />
                            @error('name')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-rose-500">*</span></label>
                            <input id="email" class="form-input w-full" type="email" name="email" value="{{ old('email') }}" required />
                            @error('email')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="phone">Phone</label>
                            <input id="phone" class="form-input w-full" type="text" name="phone" value="{{ old('phone') }}" />
                            @error('phone')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Expertise -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="expertise">Expertise</label>
                            <textarea id="expertise" class="form-textarea w-full" name="expertise" rows="4">{{ old('expertise') }}</textarea>
                            @error('expertise')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="photo">Photo</label>
                            <input id="photo" class="form-input w-full" type="file" name="photo" accept="image/*" />
                            @error('photo')
                                <div class="text-rose-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-indigo-500 btn hover:bg-indigo-600">
                                Create Instructor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
