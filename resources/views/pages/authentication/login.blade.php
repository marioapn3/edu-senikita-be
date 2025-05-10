@extends('layouts.authentication')

@section('content')
    <h1 class="mb-6 text-3xl font-bold text-slate-800">{{ __('Welcome back!') }} ✨</h1>
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('authenticate') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="email" class="block mb-1 text-sm font-medium">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full form-input" />
            </div>
            <div>
                <label for="password" class="block mb-1 text-sm font-medium">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full form-input" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <div class="mr-1">
                    <a class="text-sm underline hover:no-underline" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                </div>
            @endif
            <button type="submit" class="px-4 py-2 text-white bg-primary rounded hover:bg-primary/90">
                {{ __('Sign in') }}
            </button>
        </div>
    </form>

    @if ($errors->any())
        <div class="px-4 py-2 mt-2 text-sm border rounded-sm bg-rose-100 border-rose-200 text-rose-600">
            <div class="font-medium">{{ __('Whoops! Something went wrong.') }}</div>
            <ul class="mt-1 text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


@endsection
