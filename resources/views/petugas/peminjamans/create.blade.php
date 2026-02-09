@extends('layouts.petugas')

@section('title', 'Input Pengembalian')
@section('header', 'Input Pengembalian & Hitung Denda')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Pengembalian</h3>
        <p class="text-gray-500 text-sm">Denda akan dihitung otomatis berdasarkan keterlambatan dan kondisi alat</p>
    </div>
    
    <form action="{{ route('petugas.pengembalians.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Peminjaman</label>
            <select name="peminjaman_id" id="peminjamanSelect" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('peminjaman_id') border-red-500 @enderror">
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $p)
                    <option value="{{ $p->id }}" 
                            data-tgl-rencana="{{ $p->tanggal_kembali_rencana->format('Y-m-d') }}"
                            data-jumlah="{{ $p->jumlah_pinjam }}">
                        {{ $p->user->name }} - {{ $p->alat->nama_alat }} 
                        ({{ $p->jumlah_pinjam }} unit, Kembali: {{ $p->tanggal_kembali_rencana->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            @error('peminjaman_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali Aktual</label>
                <input type="date" name="tanggal_kembali" id="tglKembali" required
                       value="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali') border-red-500 @enderror">
                @error('tanggal_kembali')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kembali</label>
                <input type="number" name="jumlah_kembali" id="jumlahKembali" required min="1"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_kembali') border-red-500 @enderror">
                @error('jumlah_kembali')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Alat</label>
            <select name="kondisi" id="kondisiSelect" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('kondisi') border-red-500 @enderror">
                <option value="baik">Baik (Tidak ada denda)</option>
                <option value="rusak_ringan">Rusak Ringan (+Rp 50.000)</option>
                <option value="rusak_berat">Rusak Berat (+Rp 150.000)</option>
            </select>
            @error('kondisi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Preview Denda -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
            <h4 class="font-semibold text-yellow-800 mb-2">Estimasi Denda:</h4>
            <div class="space-y-1 text-sm">
                <p>Denda Keterlambatan: <span id="dendaTelat" class="font-mono">Rp 0</span></p>
                <p>Denda Kerusakan: <span id="dendaRusak" class="font-mono">Rp 0</span></p>
                <p class="text-lg font-bold text-yellow-800 pt-2 border-t">
                    Total Denda: <span id="totalDenda">Rp 0</span>
                </p>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Catatan tambahan tentang kondisi alat..."></textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Simpan Pengembalian
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('peminjamanSelect').addEventListener('change', hitungDenda);
document.getElementById('tglKembali').addEventListener('change', hitungDenda);
document.getElementById('kondisiSelect').addEventListener('change', hitungDenda);

function hitungDenda() {
    const peminjaman = document.getElementById('peminjamanSelect');
    const tglKembali = document.getElementById('tglKembali').value;
    const kondisi = document.getElementById('kondisiSelect').value;
    
    if (!peminjaman.value || !tglKembali) return;
    
    const tglRencana = peminjaman.options[peminjaman.selectedIndex].dataset.tglRencana;
    
    // Hitung denda telat
    const tgl1 = new Date(tglRencana);
    const tgl2 = new Date(tglKembali);
    const diffTime = tgl2 - tgl1;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    let dendaTelat = 0;
    if (diffDays > 0) {
        dendaTelat = diffDays * 10000;
    }
    
    // Hitung denda rusak
    let dendaRusak = 0;
    if (kondisi === 'rusak_ringan') dendaRusak = 50000;
    if (kondisi === 'rusak_berat') dendaRusak = 150000;
    
    // Update tampilan
    document.getElementById('dendaTelat').textContent = 'Rp ' + dendaTelat.toLocaleString('id-ID');
    document.getElementById('dendaRusak').textContent = 'Rp ' + dendaRusak.toLocaleString('id-ID');
    document.getElementById('totalDenda').textContent = 'Rp ' + (dendaTelat + dendaRusak).toLocaleString('id-ID');
}

// Set jumlah kembali default saat pilih peminjaman
document.getElementById('peminjamanSelect').addEventListener('change', function() {
    const jumlah = this.options[this.selectedIndex].dataset.jumlah;
    document.getElementById('jumlahKembali').value = jumlah;
});
</script>
@endsection