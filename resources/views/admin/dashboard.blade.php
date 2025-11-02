@extends('admin.layout')

@section('content')
    {{-- Konten Utama --}}
    <main class="min-h-screen flex-1 p-2 sm:p-6 bg-gray-50">
        <div class="max-w-5xl mx-auto">
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

        @if(session('success'))
            <div class="bg-fff text-black shadow-lg rounded-xl max-w-5xl mx-auto p-6 border-l-4 border-[#09697E] mt-2 sm:mt-8">
                {{ session('success') }}
            </div>
        @endif

        @include('components.tabel-periode-admin')
    </main>
@endsection
