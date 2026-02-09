@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman')
@section('header', 'Form Pengajuan Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Pengajuan Peminjaman</h3>
        <p class="text-gray-500 text-sm">Isi data berikut untuk mengajukan peminjaman alat</p>
    </div>
    
    <form action="{{ route('peminjam.peminjamans.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Alat</label>
            <select name="alat_id" id="alatSelect" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('alat_id') border-red-500 @enderror">
                <option value="">-- Pilih Alat --</option>
                @foreach($alats as $alat)
                    <option value="{{ $alat->id }}" 
                            data-tersedia="{{ $alat->jumlah_tersedia }}"
                            {{ request('alat_id') == $alat->id ? 'selected' : '' }}>
                        {{ $alat->nama_alat }} (Tersedia: {{ $alat->jumlah_tersedia }} unit)
                    </option>
                @endforeach
            </select>
            @error('alat_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Pinjam</label>
            <input type="number" name="jumlah_pinjam" id="jumlahPinjam" required min="1"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_pinjam') border-red-500 @enderror">
            <p class="text-gray-500 text-xs mt-1">Maksimal: <span id="maxJumlah">-</span> unit</p>
            @error('jumlah_pinjam')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" required min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_pinjam') border-red-500 @enderror">
                @error('tanggal_pinjam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali_rencana') border-red-500 @enderror">
                @error('tanggal_kembali_rencana')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional)</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Alasan peminjaman, keperluan, dll..."></textarea>
        </div>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-yellow-800 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                Pengajuan Anda akan diproses oleh petugas. Anda akan menerima notifikasi setelah disetujui atau ditolak.
            </p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('peminjam.alats.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('alatSelect').addEventListener('change', function() {
    const tersedia = this.options[this.selectedIndex].dataset.tersedia;
    document.getElementById('maxJumlah').textContent = tersedia;
    document.getElementById('jumlahPinjam').max = tersedia;
});
</script>
@endsection