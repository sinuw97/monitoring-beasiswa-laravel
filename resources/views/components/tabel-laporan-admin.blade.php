<div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-l-4 border-[#09697E] my-6 sm:my-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
        <h2 class="text-lg sm:text-xl font-semibold text-[#09697E]">Data Laporan Mahasiswa</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
            <thead class="bg-[#09697E] text-white">
                <tr>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">NIM</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">Semester</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">Status</th>
                    <th class="px-8 sm:px-16 py-3 text-center font-semibold uppercase tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($dataLaporan as $index => $laporan)
                    <tr class="hover:bg-[#f7f7f7] transition">
                        <td class="px-3 sm:px-6 py-3 text-gray-800">
                            {{ ($dataLaporan->currentPage() - 1) * $dataLaporan->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800 font-semibold break-all">{{ $laporan->nim }}</td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800">{{ $laporan->name }}</td>
                        <td class="px-3 sm:px-6 py-3 text-gray-700">{{ ucfirst($laporan->semester) }}</td>
                        <td class="px-3 sm:px-6 py-3">
                            @if ($laporan->status === 'Lolos')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $laporan->status }}
                                </span>
                            @elseif ($laporan->status === 'Pending')
                                <span class="bg-[#E8BE00] text-[#000000] px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $laporan->status }}
                                </span>
                            @else
                                <span class="bg-gray-300 text-[#000000] px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $laporan->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-3 text-center">
                            <div class="grid justify-center grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-2">
                                <div class="w-full">
                                    <a href="{{ url('/admin/laporan/'.$laporan->laporan_id) }}"
                                        class="flex w-full bg-[#09697E] hover:bg-[#075263] text-white py-2 rounded text-xs cursor-pointer">
                                            <div class="w-full flex items-center justify-center">Edit</div>
                                    </a>
                                </div>
                                <form method="POST" action="{{ url('/admin/laporan/'.$laporan->laporan_id) }}"
                                      onsubmit="return confirm('Hapus data Laporan {{$laporan->laporan_id}}?')" class="w-full">
                                    @csrf
                                    @method('delete')
                                    <button class="w-full bg-[#000000] hover:bg-gray-800 text-white px-3 py-2 rounded text-xs cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500 italic">
                            Tidak ada data laporan mahasiswa
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-4">
        {{ $dataLaporan->withQueryString()->links() }}
    </div>
</div>
