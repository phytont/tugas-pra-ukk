@extends('layouts.petugas')

@section('title', 'Persetujuan Peminjaman')
@section('header', 'Peminjaman Menunggu Persetujuan')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Daftar Peminjaman yang Perlu Disetujui</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peminjamans as $index => $peminjaman)
                <tr>
                    <td class="px-6 py-4">{{ $peminjamans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->user->name }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->jumlah_pinjam }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('petugas.peminjamans.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <form action="{{ route('petugas.peminjamans.setuju', $peminjaman) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini?')">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900" title="Setujui">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        
                        <button onclick="showTolakModal({{ $peminjaman->id }})" class="text-red-600 hover:text-red-900" title="Tolak">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada peminjaman yang menunggu persetujuan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $peminjamans->links() }}
    </div>
</div>

<!-- Modal Tolak -->
<div id="tolakModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tolak Peminjaman</h3>
            <form id="tolakForm" method="POST" class="mt-4 text-left">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" required rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeTolakModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTolakModal(id) {
    document.getElementById('tolakForm').action = '/petugas/peminjamans/' + id + '/tolak';
    document.getElementById('tolakModal').classList.remove('hidden');
}

function closeTolakModal() {
    document.getElementById('tolakModal').classList.add('hidden');
}
</script>
@endsection