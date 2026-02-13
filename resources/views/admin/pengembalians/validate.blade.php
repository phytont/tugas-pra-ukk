@extends('layouts.admin')

@section('title', 'Validasi Denda')
@section('header', 'Validasi Denda Pengembalian')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Detail Peminjaman -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 pb-4 border-b">Detail Peminjaman & Pengembalian</h3>
            
            <div class="space-y-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600 text-sm">Peminjam</label>
                        <p class="font-semibold text-lg">{{ $pengembalian->peminjaman->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">Email</label>
                        <p class="font-semibold">{{ $pengembalian->peminjaman->user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600 text-sm">Alat</label>
                        <p class="font-semibold">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">Jumlah Dipinjam</label>
                        <p class="font-semibold text-blue-600">{{ $pengembalian->peminjaman->jumlah_pinjam }} unit</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600 text-sm">Tanggal Pinjam</label>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">Tanggal Kembali Rencana</label>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_kembali_rencana)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-4">
                <h4 class="font-semibold mb-3">Info Pengembalian</h4>
                <div class="space-y-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-600 text-sm">Tanggal Pengembalian</label>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-600 text-sm">Kondisi Alat</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded text-sm font-semibold
                                    {{ $pengembalian->kondisi == 'rusak' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($pengembalian->kondisi) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">Keterangan Petugas</label>
                        <p class="text-gray-700">{{ $pengembalian->keterangan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">Diverifikasi oleh</label>
                        <p class="font-semibold">{{ $pengembalian->peminjaman->verifiedByPetugas->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Box Denda -->
    <div>
        <div class="bg-red-50 border-2 border-red-300 rounded-lg p-6">
            <h3 class="font-bold text-red-800 mb-4 text-lg">PERSETUJUAN DENDA</h3>
            
            <div class="bg-white rounded p-3 mb-4">
                <p class="text-gray-600 text-sm">Nominal Denda yang Diajukan</p>
                <p class="text-3xl font-bold text-red-600">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</p>
            </div>

            @if($pengembalian->status_denda == 'menunggu_validasi')
                <p class="text-sm text-gray-700 mb-4">
                    Petugas telah mengajukan denda dengan kondisi alat: <strong>{{ ucfirst($pengembalian->kondisi) }}</strong>
                </p>

                <div class="space-y-3">
                    <form action="{{ route('admin.pengembalians.approveFine', $pengembalian) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                            <i class="fas fa-check mr-2"></i>Setujui Denda
                        </button>
                    </form>

                    <button type="button" onclick="document.getElementById('reject-form-section').style.display='block'" 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Tolak Denda
                    </button>
                </div>
            @else
                <div class="bg-gray-100 p-3 rounded">
                    <p class="text-sm text-gray-700">Status:</p>
                    <p class="font-semibold text-lg">
                        {{ $pengembalian->status_denda == 'disetujui' ? '✓ Disetujui' : '✗ Ditolak' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Form Tolak Denda (Hidden) -->
<div id="reject-form-section" class="hidden bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4 pb-4 border-b">Tolak Pengajuan Denda</h3>
    
    <form action="{{ route('admin.pengembalians.rejectFine', $pengembalian) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Alasan Penolakan Denda</label>
            <textarea name="alasan" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-red-500 @error('alasan') border-red-500 @enderror"
                      placeholder="Jelaskan mengapa denda ini ditolak...">{{ old('alasan') }}</textarea>
            @error('alasan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('reject-form-section').style.display='none'"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </button>
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                <i class="fas fa-check mr-2"></i>Tolak Denda
            </button>
        </div>
    </form>
</div>

<div class="flex gap-3">
    <a href="{{ route('admin.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>
@endsection
