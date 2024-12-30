<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">
                        {{ __("Selamat datang!") }} <strong>{{ Auth::user()->name }}</strong>
                    </h3>
                    <p class="text-sm mt-2 text-gray-600">
                        Here's an overview of your dashboard.
                    </p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Barang Card -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-blue-700">Total Barang</h3>
                    @if ($totalBarang > 0)
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $totalBarang }}</p>
                    @else
                        <p class="text-gray-600 mt-4">Tidak ada barang</p>
                    @endif
                </div>

                <!-- Recent Updates Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-700">Aktivitas Terakhir</h3>
                    <ul class="mt-4">
                        @forelse ($recentUpdates as $update)
                            <li class="mb-2">
                                <div class="flex justify-between items-center text-sm my-2">
                                    <a href="{{ route('barang.show', $update->barang_id) }}" class="font-bold text-gray-800 truncate max-w-xs hover:underline">{{ optional($update->barang)->name }}</a>
                                    <div class="flex items-center">
                                        <span class="{{ $update->action == 'subtracted' ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $update->action == 'subtracted' ? '-' . $update->quantity . ' pcs.': '+' . $update->quantity . ' pcs.' }}
                                        </span>
                                        <span class="text-gray-500 text-sm ml-4">{{ $update->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-600">No recent updates available.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Total User Card -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-blue-700">Total User</h3>
                    {{-- <p class="text-3xl font-bold text-gray-900 mt-4">{{ $totalUser }}</p> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
