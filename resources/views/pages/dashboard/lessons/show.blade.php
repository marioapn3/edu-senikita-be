@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white py-6 px-6 sm:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-semibold tracking-tight">{{ $lesson->title }}</h3>
                        <p class="text-indigo-100 text-sm mt-1">Course Lesson</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('courses.lessons.edit', [$courseId, $lesson->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-white/10 text-white text-sm font-medium rounded-full hover:bg-white/20 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i> Edit Lesson
                        </a>
                        <a href="{{ route('courses.show', $courseId) }}"
                           class="inline-flex items-center px-4 py-2 bg-white/10 text-white text-sm font-medium rounded-full hover:bg-white/20 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Course
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Lesson Content & Video -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Lesson Content -->
                        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-book-open text-indigo-600 mr-2"></i>
                                <h5 class="text-lg font-semibold text-gray-900">Lesson Content</h5>
                            </div>
                            <div class="prose prose-gray max-w-none text-gray-600">
                                {!! $lesson->content !!}
                            </div>
                        </div>

                        <!-- Lesson Video -->
                        @if($lesson->video_url)
                        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-video text-indigo-600 mr-2"></i>
                                <h5 class="text-lg font-semibold text-gray-900">Video Lesson</h5>
                            </div>
                            <div class="relative aspect-video rounded-lg overflow-hidden">
                                <iframe
                                    class="w-full h-full"
                                    src="{{ $lesson->video_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Lesson Details -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                                <h5 class="text-lg font-semibold text-gray-900">
                                <h5 class="text-lg font-semibold text-gray-900">Lesson Details</h5>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-500">Type</span>
                                    <span class="text-sm font-medium text-gray-900">{{ ucfirst($lesson->type) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-500">Order</span>
                                    <span class="text-sm font-medium text-gray-900">#{{ $lesson->order }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-500">Duration</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        <i class="far fa-clock mr-1"></i> {{ $lesson->duration }} minutes
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-500">Status</span>
                                    <div>
                                        @if($lesson->is_completed)
                                            <span class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i> Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">
                                                <i class="fas fa-clock mr-1"></i> Not Started
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Lesson Description -->
                            <div class="mt-6">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>
                                    <h5 class="text-lg font-semibold text-gray-900">Description</h5>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600">{{ $lesson->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script>
    // Lazy load iframe for performance
    document.addEventListener('DOMContentLoaded', function () {
        const iframe = document.querySelector('iframe');
        if (iframe) {
            iframe.setAttribute('loading', 'lazy');
        }
    });
</script>
@endpush
@endsection