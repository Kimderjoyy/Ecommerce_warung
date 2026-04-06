@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h2>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Metode
        </a>
    </div>

    <!-- Daftar Metode Pembayaran -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($paymentMethods as $method)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas {{ $method->icon ?? 'fa-credit-card' }} text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ $method->name }}</p>
                                <p class="text-sm text-gray-500">{{ $method->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <code class="bg-gray-100 px-2 py-1 rounded">{{ $method->code }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <span class="badge {{ $method->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $method->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $method->sort_order }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Rekening Bank -->
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Rekening Bank</h3>
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Rekening</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Atas Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bankAccounts as $bank)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $bank->bank_name }}</td>
                        <td class="px-6 py-4">{{ $bank->formatted_account }}</td>
                        <td class="px-6 py-4">{{ $bank->account_name }}</td>
                        <td class="px-6 py-4">{{ $bank->branch ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="badge {{ $bank->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $bank->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.bank-accounts.edit', $bank) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection