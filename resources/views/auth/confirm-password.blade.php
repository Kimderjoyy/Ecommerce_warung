@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

@section('content')
<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Konfirmasi Password</h2>
    <p class="text-sm text-gray-600 mt-1">Ini adalah area aman. Harap konfirmasi password Anda sebelum melanjutkan.</p>
</div>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input id="password" type="password" name="password" required autofocus
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">
            <i class="fas fa-check mr-2"></i>Konfirmasi
        </button>
    </div>
</form>
@endsection