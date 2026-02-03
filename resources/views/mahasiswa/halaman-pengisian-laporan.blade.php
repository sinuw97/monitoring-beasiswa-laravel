@extends('mahasiswa.layout')

@section('title', 'Pengisian Monev')

@section('content')
    <div class="mb-6">
        <h1 class="font-bold text-3xl text-gray-800">Pengisian Laporan Monev</h1>
    </div>

    <div class="bg-white w-full rounded-xl shadow-md p-6 border border-gray-100">
        {{-- Banner Card --}}
        @if ($periodeAktifBanner)
            <div class="bg-[#EAF6F8] border-[#1D7D94] rounded-lg shadow-sm border-l-4 p-4 mb-6">
                <p class="font-semibold text-gray-800">
                    Periode {{ $periodeAktifBanner->tahun_akademik }} {{ $periodeAktifBanner->semester }} sedang Dibuka
                </p>
                <p class="font-bold text-lg text-[#09697E] mt-1">
                    Waktu periode:
                    @if ($periodeAktifBanner->tanggal_mulai && $periodeAktifBanner->tanggal_selesai)
                        {{ \Carbon\Carbon::parse($periodeAktifBanner->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                        -
                        {{ \Carbon\Carbon::parse($periodeAktifBanner->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                    @else
                        <span class="italic text-gray-500">Belum ditentukan</span>
                    @endif
                </p>
            </div>
        @endif

        {{-- ================= Mobile View ================= --}}
        <div class="block sm:hidden space-y-4">
            @forelse ($timeline as $row)
                <div
                    class="bg-white rounded-lg shadow-sm p-4 border-l-4 {{ $row['status'] === 'Dibuka' ? 'border-[#1D7D94]' : 'border-red-400' }}">
                    {{-- Status --}}
                    <span
                        class="inline-block mb-2 text-[10px] font-semibold tracking-wide uppercase px-2 py-1 rounded
                                {{ $row['status'] === 'Dibuka' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $row['status'] }}
                    </span>

                    {{-- Semester (Judul) --}}
                    <h3 class="text-md font-bold text-gray-800 mb-1">
                        {{ $row['semester'] }}
                    </h3>

                    {{-- Periode --}}
                    <p class="text-xs italic text-gray-500 mb-4">
                        Periode: {{ $row['periode'] }}
                    </p>

                    {{-- Aksi Btn --}}
                    <div class="flex justify-end">
                        @if ($row['status'] === 'Ditutup')
                            <button disabled
                                class="px-3 py-1.5 text-xs bg-red-500 text-white font-semibold rounded-md opacity-70 cursor-not-allowed">
                                Tutup
                            </button>
                        @elseif ($row['aksi'] === 'Buat')
                            <form
                                action="{{ route('mahasiswa.buat-laporan', ['semesterId' => $row['semester_id'], 'semesterSekarang' => $row['semester']]) }}"
                                method="POST">
                                @csrf
                                <button
                                    class="px-3.5 py-1.5 text-xs bg-[#2B6EE3] text-white font-semibold rounded-md hover:bg-[#1a5bb8] transition">
                                    Buat
                                </button>
                            </form>
                        @elseif ($row['aksi'] === 'Lihat')
                            <a href="{{ route('mahasiswa.lihat-laporan', $row['laporan_id']) }}"
                                class="px-3 py-1.5 text-xs bg-[#1D7D94] text-white font-semibold rounded-md hover:bg-[#0f4d5c] transition">
                                Lihat
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-500 py-4">
                    Tidak ada data
                </div>
            @endforelse
        </div>

        {{-- ================= Desktop View ================= --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#ffdc3f] text-gray-600 font-medium border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-center">Semester</th>
                        <th class="px-6 py-3 text-center">Periode</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($timeline as $row)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-center">{{ $row['no'] }}</td>
                            <td class="px-6 py-3 text-center font-medium text-gray-800">{{ $row['semester'] }}</td>
                            <td class="px-6 py-3 text-center">{{ $row['periode'] }}</td>
                            <td class="px-6 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold {{ $row['status'] === 'Dibuka' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if ($row['status'] === 'Ditutup')
                                    <button disabled
                                        class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded opacity-60 cursor-not-allowed">
                                        Tutup
                                    </button>
                                @elseif ($row['aksi'] === 'Buat')
                                    <form
                                        action="{{ route('mahasiswa.buat-laporan', ['semesterId' => $row['semester_id'], 'semesterSekarang' => $row['semester']]) }}"
                                        method="POST" x-data="{ submitting: false }" x-on:submit="submitting = true">
                                        @csrf
                                        <button x-bind:disabled="submitting" x-text="submitting ? 'Membuat...' : 'Buat'"
                                            :class="submitting
                                                ?
                                                'cursor-not-allowed bg-gray-400' :
                                                'cursor-pointer bg-[#1298FF] hover:bg-[#0b6bcb]'"
                                            class="px-3 py-1 text-white text-xs font-bold rounded transition shadow-sm">
                                        </button>
                                    </form>
                                @elseif ($row['aksi'] === 'Lihat')
                                    <a href="{{ route('mahasiswa.lihat-laporan', $row['laporan_id']) }}"
                                        class="px-3 py-1 bg-[#1D7D94] text-white text-xs font-bold rounded hover:bg-[#0f4d5c] transition shadow-sm">
                                        Lihat
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                                Tidak ada data periode.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
