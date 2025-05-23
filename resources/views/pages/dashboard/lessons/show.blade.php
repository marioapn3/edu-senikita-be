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
                        @if($lesson->video_url && $lesson->type == 'video')
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

                        @if($lesson->type == 'quiz')
                        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-question-circle text-indigo-600 mr-2"></i>
                                    <h5 class="text-lg font-semibold text-gray-900">Quiz</h5>
                                </div>
                                <button type="button"
                                        onclick="openCreateQuestionModal()"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i> Add Question
                                </button>
                            </div>

                            @if(isset($quiz) && isset($quiz->questions) && count($quiz->questions) > 0)
                                @foreach($quiz->questions as $q)
                                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-6">
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex-1">
                                            <h5 class="text-base font-semibold text-gray-900">{{ $q->question }}</h5>
                                            <p class="text-sm text-gray-500 mt-1">Type: {{ ucfirst($q->type) }}</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button type="button"
                                                    onclick="openCreateAnswerModal({{ $q->id }})"
                                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                <i class="fas fa-plus mr-2"></i> Add Answer
                                            </button>
                                            <form action="{{ route('courses.quiz.question.delete', [$q->id]) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h6 class="text-sm font-semibold text-gray-700 mb-3">Answers</h6>
                                        @if(count($q->answers) > 0)
                                            <div class="space-y-2">
                                                @foreach ($q->answers as $answer)
                                                    <div class="flex items-center justify-between py-3 px-4 bg-white rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                                        <div class="flex-1">
                                                            <p class="text-sm text-gray-600">{{ $answer->answer }}</p>
                                                        </div>
                                                        <div class="flex items-center gap-4">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $answer->is_correct ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                                {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
                                                            </span>
                                                            <form action="{{ route('quiz.answer.delete', [ $answer->id]) }}" method="POST" class="m-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">No answers added yet</p>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-600">No questions found</p>
                                    @if(!isset($quiz))
                                        <p class="text-sm text-gray-500 mt-2">Please create a quiz first</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Create Question Modal -->
                        <div id="createQuestionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Create New Question</h3>
                                    <form id="createQuestionForm" class="space-y-4">
                                        <div>
                                            <label for="question" class="block text-sm font-medium text-gray-700">Question</label>
                                            <textarea id="question" name="question" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                        </div>
                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-700">Question Type</label>
                                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="multiple_choice">Multiple Choice</option>
                                                <option value="true_false">True/False</option>
                                                <option value="essay">Essay</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="closeCreateQuestionModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                Create Question
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Create Answer Modal -->
                        <div id="createAnswerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Create New Answer</h3>
                                    <form id="createAnswerForm" class="space-y-4">
                                        <input type="hidden" id="questionId" name="questionId">
                                        <div>
                                            <label for="answer" class="block text-sm font-medium text-gray-700">Answer</label>
                                            <textarea id="answer" name="answer" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                        </div>
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" id="is_correct" name="is_correct" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="ml-2 text-sm text-gray-600">Mark as correct answer</span>
                                            </label>
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="closeCreateAnswerModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                Create Answer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($lesson->type == 'final')
                            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-file-alt text-indigo-600 mr-2"></i>
                                    <h5 class="text-lg font-semibold text-gray-900">Final Submission</h5>
                                </div>

                                <div class="flex items-center justify-between py-3 px-4 bg-white rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="overflow-x-auto w-full">
                                        <table class="min-w-full border-collapse border border-gray-200">
                                            <thead>
                                                <tr>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">Submission</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">File Path</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">Status</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">Score</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">User</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">Tanggal Submit</th>
                                                    <th class="border border-gray-200 p-2 bg-gray-50 text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lesson->submissions as $submission)
                                                <tr>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap"><a href="{{ $submission->submission }}" class="text-indigo-500 hover:text-indigo-600" target="_blank">Link Submission</a></td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap"><a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">View File</a></td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap">{{ $submission->status }}</td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap">{{ $submission->score }}</td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap">{{ $submission->user->name }}</td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap">{{ $submission->created_at->format('d-m-Y H:i:s') }}</td>
                                                    <td class="border border-gray-200 p-2 whitespace-nowrap">
                                                        <button onclick="openScoreModal({{ $submission->id }})"
                                                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                            <i class="fas fa-star mr-2"></i> Score
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Score Modal -->
                                <div id="scoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                        <div class="mt-3">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Score Submission</h3>
                                            <form method="POST" id="scoreForm" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="submissionId" name="submissionId">
                                                <div>
                                                    <label for="score" class="block text-sm font-medium text-gray-700">Score (0-100)</label>
                                                    <input type="number" id="score" name="score" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                                    <textarea id="feedback" name="feedback" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                                </div>
                                                <div>
                                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        <option value="reviewed">Reviewed</option>
                                                        <option value="approved">Approved</option>
                                                        <option value="rejected">Rejected</option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end space-x-3">
                                                    <button type="button" onclick="closeScoreModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                        Submit Score
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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


<script>
    // Lazy load iframe for performance
    document.addEventListener('DOMContentLoaded', function () {
        const iframe = document.querySelector('iframe');
        if (iframe) {
            iframe.setAttribute('loading', 'lazy');
        }
    });

    // Modal functions
    function openCreateQuestionModal() {
        document.getElementById('createQuestionModal').classList.remove('hidden');
    }

    function closeCreateQuestionModal() {
        document.getElementById('createQuestionModal').classList.add('hidden');
    }

    function openCreateAnswerModal(questionId) {
        document.getElementById('questionId').value = questionId;
        document.getElementById('createAnswerModal').classList.remove('hidden');
    }

    function closeCreateAnswerModal() {
        document.getElementById('createAnswerModal').classList.add('hidden');
        document.getElementById('createAnswerForm').reset();
    }

    // Question form submission
    document.getElementById('createQuestionForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            question: document.getElementById('question').value,
            type: document.getElementById('type').value,
        };

        try {
            @if(isset($quiz))
            const response = await fetch(`{{ route('courses.quiz.question.create', ['quizId' => $quiz->id]) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to create question. Please try again.');
            }
            @else
            alert('Quiz not found. Please create a quiz first.');
            @endif
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });

    // Answer form submission
    document.getElementById('createAnswerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const questionId = document.getElementById('questionId').value;
        const formData = {
            answer: document.getElementById('answer').value,
            is_correct: document.getElementById('is_correct').checked,
        };

        try {
            const response = await fetch(`/courses/quiz/question/${questionId}/answer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to create answer. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });

    // Score Modal functions
    function openScoreModal(submissionId) {
        document.getElementById('submissionId').value = submissionId;
        const form = document.getElementById('scoreForm');
        form.action = `/courses/final-submission/${submissionId}`;
        document.getElementById('scoreModal').classList.remove('hidden');
    }

    function closeScoreModal() {
        document.getElementById('scoreModal').classList.add('hidden');
        document.getElementById('scoreForm').reset();
    }
</script>

@endsection
