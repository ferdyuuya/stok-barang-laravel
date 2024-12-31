<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Barang Table -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold text-gray-800">Daftar Barang</h3>
                    <div class="flex justify-between items-center mt-6 mb-4">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Cari Barang..." 
                            class="px-4 py-2 border-gray-400 rounded-md w-64 text-sm"
                            onkeyup="filterTable()" 
                        />
                        <button data-modal-target="add_barang" data-modal-toggle="add_barang" class="text-base bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none">
                            Tambah Barang
                        </button>            
                    </div>

                    <div class="overflow-x-auto mt-6 mb-8 rounded-lg border border-gray-300 shadow-sm">
                        <table id="barangTable" class="min-w-full table-auto text-base text-gray-800">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No.</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                <tr onclick="window.location.href='{{ route('barang.show', $barang->id) }}'" class="hover:bg-gray-100 cursor-pointer text-sm">
                                    <td class="px-6 py-3 text-center">{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-3">{{ $barang->name }}</td>
                                    <td class="px-6 py-3">{{ $barang->description }}</td>
                                    <td class="px-6 py-3">{{ $barang->quantity }} pcs.</td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center space-x-2">
                                            <button data-barang-id="{{ $barang->id }}" onclick="openAddModal(this)" data-modal-target="add_quantity_barang" data-modal-toggle="add_quantity_barang" class="bg-green-500 text-white px-3 py-2 rounded-md hover:bg-green-600 text-sm flex items-center">
                                                <i class="fa fa-plus mr-2"></i> Tambah
                                            </button>
                                            <button data-barang-id="{{ $barang->id }}" onclick="openSubtractModal(this)" data-modal-target="substract_quantity_barang" data-modal-toggle="substract_quantity_barang" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 text-sm flex items-center">
                                                <i class="fa fa-minus mr-2"></i> Kurangi
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="my-4 mx-4 text-center">
                            {{ $barangs->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal For Add Quantity Barang-->
    <div id="add_quantity_barang" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Tambah Barang <span class="font-bold" id="barangName"></span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add_quantity_barang">
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <form action="{{ route('stoklog.add') }}" method="POST" class="px-4 md:py-4 md:px-5">
                    @csrf
                    <div class="grid gap-4 mb-2 grid-cols-2">
                        <input type="hidden" name="barang_id" id="barangId">
                        <div class="col-span-2">
                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="bg-gray-50 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="70" required>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <input type="text" name="description" id="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" required>
                        </div>
                    </div>
                    <button type="submit" class="text-white items-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-xs rounded-lg text-sm px-5 py-2.5 text-center ml-auto">
                        Tambahkan Jumlah Barang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal For Substract Quantity Barang-->
    <div id="substract_quantity_barang" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Kurangi Barang <span class="font-bold" id="barangNameSubtract"></span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="substract_quantity_barang">
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <form action="{{ route('stoklog.subtract') }}" method="POST" class="px-4 md:py-4 md:px-5">
                    @csrf
                    <div class="grid gap-4 mb-2 grid-cols-2">
                        <input type="hidden" name="barang_id" id="barangIdSubtract">
                        <div class="col-span-2">
                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                            <input type="number" name="quantity" id="quantitySubtract" class="bg-gray-50 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="70" required>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <input type="text" name="description" id="descriptionSubtract" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" required>
                        </div>
                    </div>
                    <button type="submit" class="text-white items-right bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-xs rounded-lg text-sm px-5 py-2.5 text-center ml-auto">
                        Kurangi Jumlah Barang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal For Add  Barang-->
    <div id="add_barang" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Tambah Barang <span class="font-bold" id="barangName"></span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add_quantity_barang">
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <form action="{{ route('barang.store') }}" method="POST" class="px-4 md:py-4 md:px-5">
                    @csrf
                    <div class="grid gap-4 mb-2 grid-cols-2">
                        {{-- <input type="hidden" name="barang_id" id="barangId"> --}}
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="70" required>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <input type="text" name="description" id="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" required>
                        </div>
                    </div>
                    <button type="submit" class="text-white items-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-xs rounded-lg text-sm px-5 py-2.5 text-center ml-auto">
                        Tambahkan Jumlah Barang
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function filterTable() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase(); 
    const tableRows = document.querySelectorAll("#barangTable tbody tr"); 
    tableRows.forEach(row => {
        const rowText = row.innerText.toLowerCase();
        if (rowText.includes(searchInput)) {
            row.style.display = ""; 
        } else {
            row.style.display = "none"; 
        }
    });
}

function openAddModal(button) {
    event.stopPropagation();
    const barangId = button.getAttribute('data-barang-id');
    document.getElementById('barangId').value = barangId;

    const barangName = button.closest('tr').querySelector('td:nth-child(2)').textContent; 
    document.getElementById('barangName').textContent = barangName;

    const modal = document.getElementById('add_quantity_barang');
    modal.classList.remove('hidden');
    modal.classList.add('block');
}

function openSubtractModal(button) {
    event.stopPropagation();
    const barangId = button.getAttribute('data-barang-id');
    document.getElementById('barangIdSubtract').value = barangId;

    const barangName = button.closest('tr').querySelector('td:nth-child(2)').textContent; 
    document.getElementById('barangNameSubtract').textContent = barangName;

    const modal = document.getElementById('substract_quantity_barang');
    modal.classList.remove('hidden');
    modal.classList.add('block');
}

function openAddBarangModal(button) {
    event.stopPropagation();
    const modal = document.getElementById('add_barang');
    modal.classList.remove('hidden');
    modal.classList.add('block');
}
</script>
