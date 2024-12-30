<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Barang Table -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold text-gray-800">Barang List</h3>
                    <div class="flex justify-between items-center mt-6">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search Barang..." 
                            class="px-4 py-2 border-gray-400 rounded-md w-64"
                            onkeyup="filterTable()" 
                        />
                        <button data-modal-target="add_barang" data-modal-toggle="add_barang" class="text-base bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none">
                            Tambah Barang
                        </button>            
                    </div>

                    <div class="overflow-x-auto mt-6 mb-8 rounded-lg border">
                        <table id="barangTable" class="min-w-full table-auto text-base text-black-1000">
                            <thead class="bg-gray-200 my-8">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Description</th>
                                    <th class="px-4 py-2 text-left">Quantity</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                <tr class="hover:bg-gray-100 cursor-pointer" onclick="window.location.href='{{ route('barang.show', $barang->id) }}'">
                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $barang->name }}</td>
                                    <td class="px-4 py-3">{{ $barang->description }}</td>
                                    <td class="px-4 py-3">{{ $barang->quantity }} pcs.</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <button class="bg-green-500 text-white px-3 py-2 rounded-md hover:bg-green-600">+</button>
                                            <button class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600">-</button>
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

    <!-- Modal -->
    <div id="add_barang" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        Tambah Barang
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add_barang">
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('barang.store') }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <input type="text" name="description" id="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="UPS 600VA Merek A" required="">
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Tambahkan Barang
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
</script>