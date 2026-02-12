@php
    $allPeriode = \App\Models\semester\Periode::all();
    $hasAktif = $allPeriode->contains('status', 'Aktif');
    $hasAktifKhusus = $allPeriode->contains('status', 'Aktif-Khusus');
@endphp

{{-- Warning Banner: Aktif-Khusus ada tapi tidak ada Aktif --}}
@if (!$hasAktif && $hasAktifKhusus)
    @php
        // Auto-promosikan satu periode Aktif-Khusus menjadi Aktif
        $toPromote = \App\Models\semester\Periode::where('status', 'Aktif-Khusus')
            ->orderBy('semester_id', 'desc')
            ->first();
        if ($toPromote) {
            $toPromote->update(['status' => 'Aktif']);
        }
    @endphp
    <div class="max-w-5xl mx-auto mt-2 sm:mt-4 mb-2 px-4 py-3 rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 flex items-center gap-3">
        <svg class="w-6 h-6 flex-shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-medium">
            Tidak ada periode berstatus <strong>Aktif</strong>. Periode
            <strong>{{ $toPromote->tahun_akademik }} {{ $toPromote->semester }}</strong>
            (sebelumnya Aktif-Khusus) telah otomatis diubah menjadi <strong>Aktif</strong>.
        </span>
    </div>
@endif

<div class="bg-white shadow-lg rounded-xl max-w-5xl mx-auto p-2 sm:p-6 border-t-4 border-[#09697E] mt-2 sm:mt-8">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
        <div>
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 text-center sm:text-left">
                Data Periode Akademik
            </h2>
            <p class="text-sm text-gray-500 mt-1 text-center sm:text-left">Kelola periode akademik aktif dan non-aktif
            </p>
        </div>
        <div class="flex justify-center sm:justify-end">
            <button onclick="document.getElementById('addPeriodeModal').classList.remove('hidden')"
                class="bg-[#E8BE00] hover:bg-[#d4ac00] text-gray-900 font-bold px-4 py-2 rounded-lg shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5 text-sm sm:text-base w-full sm:w-auto flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Periode
            </button>
        </div>
    </div>

    @include('components.modal-add-periode', [
        'modalId' => 'addPeriodeModal',
        'action' => url('/admin/dashboard'),
    ])

    {{-- Table Wrapper --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm md:text-base">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        class="px-3 sm:px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Tahun Akademik</th>
                    <th
                        class="px-3 sm:px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Semester</th>
                    <th
                        class="px-3 sm:px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Mulai</th>
                    <th
                        class="px-3 sm:px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Selesai</th>
                    <th
                        class="px-3 sm:px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Status</th>
                    <th
                        class="px-8 sm:px-16 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($dataPeriode as $periode)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-3 sm:px-4 py-4 text-gray-900 font-semibold truncate">
                            {{ $periode->tahun_akademik }}
                        </td>
                        <td class="px-3 sm:px-4 py-4 text-gray-700 truncate">
                            <span
                                class="px-2 py-1 rounded-md text-xs font-medium {{ $periode->semester == 'Ganjil' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ ucfirst($periode->semester) }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-4 py-4 text-gray-600 truncate">
                            {{ $periode->tanggal_mulai ? \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 sm:px-4 py-4 text-gray-600 truncate">
                            {{ $periode->tanggal_selesai ? \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 sm:px-4 py-4">
                            @if ($periode->status === 'Aktif')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                                    Aktif
                                </span>
                            @elseif ($periode->status === 'Aktif-Khusus')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-1.5"></span>
                                    Aktif-Khusus
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Non-Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-4 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                @if ($periode->status == 'Non-Aktif')
                                    <form method="POST"
                                        action="{{ route('admin.dashboard.activatePeriode', $periode->semester_id) }}"
                                        onsubmit="return showConfirmationModal(event, 'Aktifkan periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                        @csrf
                                        @method('put')
                                        <button
                                            class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded-lg transition"
                                            title="Aktifkan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                        action="{{ route('admin.dashboard.deactivatePeriode', $periode->semester_id) }}"
                                        onsubmit="return showConfirmationModal(event, 'Nonaktifkan periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                        @csrf
                                        @method('put')
                                        <button
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                            title="Nonaktifkan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <button
                                    onclick="document.getElementById('editModal-{{ $periode->semester_id }}').classList.remove('hidden')"
                                    class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>

                                <form method="POST" action="{{ url('/admin/dashboard/' . $periode->semester_id) }}"
                                    onsubmit="return showConfirmationModal(event, 'Hapus periode akademik {{ $periode->tahun_akademik . ' ' . $periode->semester }}?')">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
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
                        <td colspan="6" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium">Belum ada data periode akademik</p>
                                <p class="text-sm mt-1">Silakan tambahkan periode baru untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pt-6 border-t border-gray-100 mt-4">
        {{ $dataPeriode->links() }}
    </div>
</div>
