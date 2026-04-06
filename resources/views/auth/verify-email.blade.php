@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Verifikasi Email</h2>
    <p class="text-sm text-gray-600 mt-1">Terima kasih telah mendaftar!</p>
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-400 rounded-lg p-3">
        Link verifikasi baru telah dikirim ke email Anda.
    </div>
@endif

<div class="mb-4 text-sm text-gray-600">
    Sebelum memulai, silakan verifikasi email Anda dengan mengklik link yang telah kami kirim. 
    Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan link lain.
</div>

<div class="mt-4 flex items-center justify-between">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium">
            <i class="fas fa-paper-plane mr-1"></i>Kirim Ulang Email Verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-gray-600 hover:text-gray-800 font-medium">
            <i class="fas fa-sign-out-alt mr-1"></i>Logout
        </button>
    </form>
</div>
@endsection