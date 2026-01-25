@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Konten Utama --}}
    <main class="min-h-screen flex-1 p-2 sm:p-6 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    {{-- Tombol untuk menutup alert (opsional) --}}
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 1 1 1.697 1.697l-2.651 2.995 2.651 2.995a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif
            {{-- Card Info Admin --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-[#E8BE00] mb-2 sm:mb-8">
                <h2 class="text-xl font-semibold text-[#09697E] mb-4">Informasi Akun</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <p class="text-gray-500">User ID</p>
                        <p class="font-bold text-[#000000]">{{ $dataAdmin->user_id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-bold text-[#000000]">{{ $dataAdmin->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-bold text-[#000000]">{{ $dataAdmin->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal akun dibuat</p>
                        <p class="font-bold text-[#000000]">
                            {{ \Carbon\Carbon::parse($dataAdmin->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Statistik / Menu --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8">
                <!-- Card Tahun Ajaran -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md border-t-4 border-[#09697E] hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Tahun Ajaran</h3>
                        <div class="p-2 bg-teal-50 rounded-lg">
                            <svg class="w-6 h-6 text-[#09697E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">Ganjil 2025/2026</p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="text-[#09697E] font-medium">Aktif</span>
                    </div>
                </div>

                <!-- Card Jumlah Mahasiswa -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md border-t-4 border-[#E8BE00] hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Mahasiswa</h3>
                        <div class="p-2 bg-yellow-50 rounded-lg">
                            <svg class="w-6 h-6 text-[#E8BE00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $jmlMahasiswwa }}</p>
                    <a href="{{ route('admin.data-mahasiswa') }}"
                        class="mt-4 inline-flex items-center text-sm text-[#09697E] hover:text-[#075263] font-medium">
                        Lihat Detail
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Card Laporan -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md border-t-4 border-gray-800 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Laporan Masuk</h3>
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $jmlLaporan }}</p>
                    <a href="{{ route('admin.laporan') }}"
                        class="mt-4 inline-flex items-center text-sm text-[#E8BE00] hover:text-[#d4ac00] font-medium">
                        Lihat Detail
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        @include('components.tabel-periode-admin')
    </main>
@endsection
