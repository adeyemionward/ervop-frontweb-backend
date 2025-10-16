@extends('layout.master2')

@section('title', 'Client Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Website Not Found</h1>
            <p class="text-lg text-gray-600">
                {{ isset($exception) ? $exception->getMessage() : ($message ?? 'The client website you are looking for does not exist.') }}
            </p>
        </div>

        <div class="space-y-4">
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('admin.users') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Manage Users
                </a>
            @endif

            <a href="{{ config('app.url') }}" class="inline-block text-blue-600 hover:text-blue-800 underline">
                Return to Main Site
            </a>
        </div>
    </div>
</div>
@endsection
