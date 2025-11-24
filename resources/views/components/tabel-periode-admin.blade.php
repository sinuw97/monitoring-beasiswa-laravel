<div class="bg-white shadow-lg rounded-xl max-w-5xl mx-auto p-2 sm:p-6 border-l-4 border-[#09697E] mt-2 sm:mt-8">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 gap-3">
        <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-[#09697E] text-center sm:text-left">
            Data Periode Akademik
        </h2>
        <div class="flex justify-center sm:justify-end">
            <button onclick="document.getElementById('addPeriodeModal').classList.remove('hidden')"
                class="bg-[#E8BE00] hover:bg-[#d4ac00] text-[#000000] font-semibold px-3 sm:px-4 py-2 rounded-lg transition cursor-pointer text-sm sm:text-base w-full sm:w-auto">
                + Tambah Periode
            </button>
        </div>
    </div>

    @include('components.modal-add-periode', [
        'modalId' => 'addPeriodeModal',
        'action' => url('/admin/dashboard'),
    ])

    {{-- Table Wrapper --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm md:text-base">
            <thead class="bg-[#09697E] text-white">
                <tr>
                    <th
                        class="px-3 sm:px-4 py-2 sm:py-3 text-left font-semibold uppercase tracking-wider whitespace-nowrap">
                        Tahun Akademik</th>
                    <th
                        class="px-3 sm:px-4 py-2 sm:py-3 text-left font-semibold uppercase tracking-wider whitespace-nowrap">
                        Semester</th>
                    <th
                        class="px-3 sm:px-4 py-2 sm:py-3 text-left font-semibold uppercase tracking-wider whitespace-nowrap">
                        Tanggal Mulai</th>
                    <th
                        class="px-3 sm:px-4 py-2 sm:py-3 text-left font-semibold uppercase tracking-wider whitespace-nowrap">
                        Tanggal Selesai</th>
                    <th
                        class="px-3 sm:px-4 py-2 sm:py-3 text-left font-semibold uppercase tracking-wider whitespace-nowrap">
                        Status</th>
                    <th class="px-8 sm:px-16 py-3 text-center font-semibold uppercase tracking-wider whitespace-nowrap">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($dataPeriode as $periode)
                    <tr class="hover:bg-[#f7f7f7] transition">
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-gray-800 font-semibold truncate">
                            {{ $periode->tahun_akademik }}</td>
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-gray-800 truncate">{{ ucfirst($periode->semester) }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-gray-700 truncate">
                            {{ $periode->tanggal_mulai ? \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-gray-700 truncate">
                            {{ $periode->tanggal_selesai ? \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 sm:py-3">
                            @if ($periode->status === 'Aktif')
                                <span
                                    class="bg-[#E8BE00] text-[#000000] px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs md:text-sm font-semibold whitespace-nowrap">
                                    {{ $periode->status }}
                                </span>
                            @elseif ($periode->status === 'Aktif Sementara')
                                <span
                                    class="bg-blue-200 text-blue-800 px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs md:text-sm font-semibold whitespace-nowrap">
                                    {{ $periode->status }}
                                </span>
                            @else
                                <span
                                    class="bg-gray-300 text-[#000000] px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs md:text-sm font-semibold whitespace-nowrap">
                                    {{ $periode->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-center">
                            <div class="flex justify-center gap-1 sm:gap-2">
                                @if ($periode->status == 'Non-Aktif')
                                    <form method="POST" class="w-full"
                                        action="{{ route('admin.dashboard.activatePeriode', $periode->semester_id) }}"
                                        onsubmit="return showConfirmationModal(event, 'Aktifkan periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                        @csrf
                                        @method('put')
                                        <button
                                            class="w-full bg-[#09697E] hover:bg-[#075263] text-white px-3 py-2 rounded text-xs cursor-pointer">
                                            {{ $anyActivePeriod ? 'Aktifkan Sementara' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" class="w-full"
                                        action="{{ route('admin.dashboard.deactivatePeriode', $periode->semester_id) }}"
                                        onsubmit="return showConfirmationModal(event, 'Nonaktifkan periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                        @csrf
                                        @method('put')
                                        <button
                                            class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs cursor-pointer">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                @endif

                                <button
                                    onclick="document.getElementById('editModal-{{ $periode->semester_id }}').classList.remove('hidden')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded text-xs cursor-pointer">
                                    Edit
                                </button>

                                <form method="POST" class="w-full"
                                    action="{{ url('/admin/dashboard/' . $periode->semester_id) }}"
                                    onsubmit="return showConfirmationModal(event, 'Hapus periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="w-full bg-[#000000] hover:bg-gray-800 text-white px-3 py-2 rounded text-xs cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            @include('components.modal-edit-periode', [
                                'modalId' => 'editModal-' . $periode->semester_id,
                                'action' => route('admin.dashboard.editPeriode', $periode->semester_id),
                                'periode' => $periode,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500 italic text-sm sm:text-base">
                            Tidak ada data periode akademik
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $dataPeriode->links() }}
    </div>
</div>
