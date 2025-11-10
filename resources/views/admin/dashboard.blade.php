@extends('admin.layout')

@section('content')
    {{-- Konten Utama --}}
    <main class="min-h-screen flex-1 p-2 sm:p-6 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    {{-- Tombol untuk menutup alert (opsional) --}}
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 1 1 1.697 1.697l-2.651 2.995 2.651 2.995a1.2 1.2 0 0 1 0 1.697z"/></svg>
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
                        <p class="font-bold text-[#000000]">{{ \Carbon\Carbon::parse($dataAdmin->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Statistik / Menu --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 sm:gap-6">
                <div class="bg-[#09697E] text-white rounded-lg p-5 flex flex-col justify-between shadow hover:scale-[1.02] transition">
                    <div>
                        <h3 class="text-lg font-semibold">Tahun Ajaran</h3>
                        <p class="text-3xl font-bold mt-2">Ganjil 2025/2026</p>
                    </div>
                </div>
                <div class="bg-[#E8BE00] text-[#000000] rounded-lg p-5 flex flex-col justify-between shadow hover:scale-[1.02] transition">
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Mahasiswa</h3>
                        <p class="text-3xl font-bold mt-2">{{ $jmlMahasiswwa }}</p>
                    </div>
                    <a href="#" class="text-sm text-[#09697E] mt-3 hover:underline">Lihat Detail</a>
                </div>
                <div class="bg-[#000000] text-white rounded-lg p-5 flex flex-col justify-between shadow hover:scale-[1.02] transition">
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Laporan Terajukan</h3>
                        <p class="text-3xl font-bold mt-2">{{ $jmlLaporan }}</p>
                    </div>
                    <a href="#" class="text-sm text-[#E8BE00] mt-3 hover:underline">Lihat Detail</a>
                </div>
            </div>
        </div>

        @include('components.tabel-periode-admin')
    </main>
@endsection
