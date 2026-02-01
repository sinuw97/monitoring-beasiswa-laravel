<div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-t-4 border-[#09697E] my-6 sm:my-8">

    {{-- Info periode aktif --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-[#09697E]">Data Laporan Mahasiswa</h2>
            <div class="text-sm text-gray-500 mt-1">
                <span class="font-medium">Periode Aktif:</span>
                @if ($periode !== [])
                    <span
                        class="bg-teal-50 text-[#09697E] px-2 py-0.5 rounded-md font-semibold">{{ $periode->tahun_akademik }}
                        - {{ $periode->semester }}</span>
                @else
                    <span class="text-gray-400 italic">Tidak ada periode aktif</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ url('/admin/laporan') }}"
        class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            {{-- Filter angkatan --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Angkatan</label>
                <select name="angkatan"
                    class="w-full py-2 px-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 cursor-pointer text-sm transition">
                    <option value="">Semua Angkatan</option>
                    @foreach ($daftarAngkatan as $a)
                        <option value="{{ $a->angkatan }}" {{ request('angkatan') == $a->angkatan ? 'selected' : '' }}>
                            20{{ $a->angkatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter status --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Status Laporan</label>
                <select name="status"
                    class="w-full py-2 px-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 cursor-pointer text-sm transition">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Lolos" {{ request('status') == 'Lolos' ? 'selected' : '' }}>Lolos</option>
                    <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Ditolak SP-1" {{ request('status') == 'Ditolak SP-1' ? 'selected' : '' }}>Ditolak
                        SP-1</option>
                    <option value="Ditolak SP-2" {{ request('status') == 'Ditolak SP-2' ? 'selected' : '' }}>Ditolak
                        SP-2</option>
                    <option value="Ditolak SP-3" {{ request('status') == 'Ditolak SP-3' ? 'selected' : '' }}>Ditolak
                        SP-3</option>
                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="Lolos dengan penugasan"
                        {{ request('status') == 'Lolos dengan penugasan' ? 'selected' : '' }}>Lolos dengan penugasan
                    </option>
                </select>
            </div>

            {{-- Filter periode --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Periode</label>
                <select name="periode"
                    class="w-full py-2 px-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 cursor-pointer text-sm transition">
                    @if ($periode !== [])
                        <option value="">Periode Aktif ({{ $periode->tahun_akademik }} -
                            {{ $periode->semester }})</option>
                    @endif
                    @foreach ($daftarPeriode as $p)
                        @php
                            $tahun = substr($p->tahun_akademik, 0, 4);
                            $kode = $p->semester == 'Ganjil' ? '01' : '02';
                            $periodeId = 'SM' . $tahun . $kode;
                        @endphp
                        <option value="{{ $periodeId }}" {{ request('periode') == $periodeId ? 'selected' : '' }}>
                            {{ $p->tahun_akademik }} - {{ $p->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari NIM atau Nama..."
                        class="w-full border-gray-300 pl-10 p-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 text-sm transition">
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-2 border-t border-gray-200">
            <a href="{{ url('/admin/laporan') }}"
                class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#09697E] transition">
                Reset
            </a>
            <button type="submit"
                class="px-4 py-2 bg-[#09697E] border border-transparent rounded-lg text-sm font-medium text-white hover:bg-[#075263] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#09697E] shadow-sm hover:shadow transition">
                Terapkan
            </button>
            <a href="{{ route('admin.laporan.export', request()->query()) }}"
                class="px-4 py-2 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm hover:shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('admin.laporan.export-pdf-zip', request()->query()) }}"
                class="px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export PDF Zip
            </a>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NIM
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Nama</th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Semester</th>
                    <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-8 sm:px-16 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($dataLaporan as $index => $laporan)
                    @php
                        $status = $laporan->status;
                        $colorClass = '';

                        if (in_array($status, ['Lolos', 'Lolos dengan penugasan'])) {
                            $colorClass = 'bg-green-100 text-green-800 border border-green-200';
                        } elseif ($status === 'Pending') {
                            $colorClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                        } elseif ($status === 'Draft') {
                            $colorClass = 'bg-gray-100 text-gray-600 border border-gray-200';
                        } elseif (Str::contains($status, 'Ditolak')) {
                            $colorClass = 'bg-red-100 text-red-800 border border-red-200';
                        } elseif (Str::contains($status, 'Dikembalikan')) {
                            $colorClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                        } else {
                            $colorClass = 'bg-gray-100 text-gray-700 border border-gray-200';
                        }
                    @endphp

                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-3 sm:px-6 py-4 text-gray-500">
                            {{ ($dataLaporan->currentPage() - 1) * $dataLaporan->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 text-gray-900 font-medium break-all">{{ $laporan->nim }}</td>
                        <td class="px-3 sm:px-6 py-4 text-gray-900 font-medium">{{ $laporan->name }}</td>
                        <td class="px-3 sm:px-6 py-4 text-gray-600">{{ ucfirst($laporan->semester) }}</td>
                        <td class="px-3 sm:px-6 py-4">
                            <span
                                class="{{ $colorClass }} px-2.5 py-0.5 rounded-full text-xs font-medium inline-block">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ url('/admin/laporan/' . $laporan->laporan_id) }}"
                                    class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition"
                                    title="Edit / Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>

                                <a href="{{ url('/admin/laporan/' . $laporan->laporan_id . '/export-pdf') }}"
                                   class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                   title="Export PDF">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>

                                <form method="POST" action="{{ url('/admin/laporan/' . $laporan->laporan_id) }}"
                                    onsubmit="return showConfirmationModal(event, 'Hapus data Laporan {{ $laporan->laporan_id }}?')">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 p-2 rounded-lg transition"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium">Tidak ada data laporan mahasiswa</p>
                                <p class="text-sm mt-1">Coba ubah filter pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($dataLaporan !== [])
        <div class="pt-6 border-t border-gray-100 mt-4">
            {{ $dataLaporan->withQueryString()->links() }}
        </div>
    @endif
</div>
