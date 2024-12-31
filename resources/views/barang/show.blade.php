<x-app-layout>
    <div class="container mx-auto py-8">
        <!-- Card for Barang Details -->
        <div class="bg-white overflow-hidden shadow-md rounded-lg mx-auto max-w-7xl text-base">
            <!-- Header -->
            <div class="px-6 py-8 bg-blue-500 text-white">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold">Detail Barang</h1>
                    <button data-modal-target="edit_barang" data-modal-toggle="edit_barang" class="bg-transparent border border-white text-white py-1 px-2 rounded hover:bg-white hover:text-blue-800 text-sm" title="Edit Barang">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
                <a href="{{ route('barang.index') }}" class="flex items-center space-x-2 text-white-600 hover:text-white-800 mt-2 text-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Barang Information -->
            <div class="mx-8 my-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nama</p>
                        <p class="text-m text-gray-800 my-2">{{ $barang->name }}</p>
                    </div>
                    <!-- Description -->
                    <div>
                        <p class="text-sm font-medium text-gray-600">Deskripsi</p>
                        <p class="text-m text-gray-800 my-2">{{ $barang->description }}</p>
                    </div>
                    <!-- Quantity -->
                    <div>
                        <p class="text-sm font-medium text-gray-600">Jumlah</p>
                        <p class="text-m text-gray-800 my-2">{{ $barang->quantity }} pcs</p>
                    </div>
                    <!-- Last Updated -->
                    <div>
                        <p class="text-sm font-medium text-gray-600">Aktivitas Terakhir</p>
                        <p class="text-m text-gray-800 my-2">{{ $barang->updated_at->format('l, d F Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-t border-gray-300" />

            <!-- Stok Log Table -->
            <div class="px-6 py-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Log Stok</h2>
                <div class="overflow-x-auto">
                    <table id="stokLogTable" class="min-w-full text-m text-gray-600">
                        <thead class="text-gray-700 uppercase text-m font-semibold text-center">
                            <tr>
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Deskripsi</th>
                                <th class="px-4 py-2">Aktivitas</th>
                                <th class="px-4 py-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokLogs->sortByDesc('created_at') as $log)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $log->description }}</td>
                                    <td class="px-4 py-3 capitalize">
                                        @if($log->action == 'added')
                                            Barang Masuk
                                        @elseif($log->action == 'subtracted')
                                            Barang Keluar
                                        @else
                                            {{ ucfirst($log->action) }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if($log->action == 'added')
                                            <span class="text-green-500">+{{ $log->quantity }}</span>
                                        @elseif($log->action == 'subtracted')
                                            <span class="text-red-500">-{{ $log->quantity }}</span>
                                        @else
                                            {{ $log->quantity }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada aktivitas terkait '{{ $barang->name }}'</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $stokLogs->links() }}
                    </div>
                </div>
            </div>

            <!-- Edit Barang Modal -->
            <div id="edit_barang" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Barang</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="edit_barang" data-modal-target="edit_barang">
                                <span class="sr-only">Tutup modal</span>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="p-4 md:p-5">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                                    <input type="text" name="name" id="name" class="bg-gray-50 w-full text-sm text-gray-900 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" value="{{ $barang->name }}" required>
                                </div>
                                <div class="col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                    <input type="text" name="description" id="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" value="{{ $barang->description }}" required>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                                    <p class="p-1 text-sm"> Perbarui Barang</p>
                                </button>
                            </form>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                                    <p class="p-1 text-sm"> Hapus Barang</p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#stokLogTable').DataTable({
                        paging: true,
                        searching: true,
                        info: true,
                        lengthChange: true,
                        pageLength: 5,
                    });
                });
            </script>
        @endpush
    </div>
</x-app-layout>
