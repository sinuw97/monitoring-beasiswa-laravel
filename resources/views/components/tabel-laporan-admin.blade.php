<div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-l-4 border-[#09697E] my-6 sm:my-8">

    {{-- Info periode aktif --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <h2 class="text-lg sm:text-xl font-semibold text-[#09697E]">Data Laporan Mahasiswa</h2>
        <div class="text-sm text-gray-600 mt-2 sm:mt-0">
            <span class="font-medium">Periode Aktif:</span>
            {{ $periode->tahun_akademik }} - {{ $periode->semester }}
        </div>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ url('/admin/laporan') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-2 sm:gap-3 mb-4 text-sm">
        {{-- Filter angkatan --}}
        <select name="angkatan" class="w-full border-gray-300 px-2 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] cursor-pointer text-sm">
            <option value="">Semua Angkatan</option>
            @foreach ($daftarAngkatan as $a)
                <option value="{{ $a->angkatan }}" {{ request('angkatan') == $a->angkatan ? 'selected' : '' }}>
                    20{{ $a->angkatan }}
                </option>
            @endforeach
        </select>

        {{-- Filter status --}}
        <select name="status" class="w-full border-gray-300 px-2 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] cursor-pointer text-sm">
            <option value="">Semua Status</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Lolos" {{ request('status') == 'Lolos' ? 'selected' : '' }}>Lolos</option>
            <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
            <option value="Ditolak SP-1" {{ request('status') == 'Ditolak SP-1' ? 'selected' : '' }}>Ditolak SP-1</option>
            <option value="Ditolak SP-2" {{ request('status') == 'Ditolak SP-2' ? 'selected' : '' }}>Ditolak SP-2</option>
            <option value="Ditolak SP-3" {{ request('status') == 'Ditolak SP-3' ? 'selected' : '' }}>Ditolak SP-3</option>
            <option value="Lolos dengan penugasan" {{ request('status') == 'Lolos dengan penugasan' ? 'selected' : '' }}>Lolos dengan penugasan</option>
        </select>

        {{-- Filter periode --}}
        <select name="periode" class="w-full border-gray-300 px-2 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] cursor-pointer text-sm">
            <option value="">Periode Aktif ({{ $periode->tahun_akademik }} - {{ $periode->semester }})</option>
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

        {{-- Search --}}
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM atau Nama..."
               class="w-full border-gray-300 p-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">

        {{-- Tombol --}}
        <div class="flex gap-2">
            <button type="submit"
                    class="bg-[#09697E] hover:bg-[#075263] text-white rounded-lg px-4 py-2 w-full">
                Filter
            </button>
            <a href="{{ url('/admin/laporan') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white rounded-lg px-4 py-2 w-full text-center">
                Reset
            </a>
        </div>
    </form>

    {{-- Tabel --}}
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
                    @php
                        $status = $laporan->status;
                        $colorClass = '';

                        if (in_array($status, ['Lolos', 'Lolos dengan penugasan'])) {
                            $colorClass = 'bg-green-100 text-green-800';
                        } elseif ($status === 'Pending') {
                            $colorClass = 'bg-gray-200 text-gray-800';
                        } elseif ($status === 'Draft') {
                            $colorClass = 'bg-yellow-100 text-yellow-800';
                        } elseif (Str::contains($status, 'Ditolak')) {
                            $colorClass = 'bg-red-100 text-red-700';
                        } else {
                            $colorClass = 'bg-gray-100 text-gray-700';
                        }
                    @endphp

                    <tr class="hover:bg-[#f7f7f7] transition">
                        <td class="px-3 sm:px-6 py-3 text-gray-800">
                            {{ ($dataLaporan->currentPage() - 1) * $dataLaporan->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800 font-semibold break-all">{{ $laporan->nim }}</td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800">{{ $laporan->name }}</td>
                        <td class="px-3 sm:px-6 py-3 text-gray-700">{{ ucfirst($laporan->semester) }}</td>
                        <td class="px-3 sm:px-6 py-3">
                            <span class="{{ $colorClass }} px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $status }}
                            </span>
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
                        <td colspan="6" class="text-center py-6 text-gray-500 italic">
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
