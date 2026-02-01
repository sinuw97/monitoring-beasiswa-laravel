@extends('mahasiswa.layout')

@section('title', 'Profile Mahasiswa')

@section('content')
    <div class="mb-6">
        <h1 class="font-bold text-3xl text-gray-800">Profile Mahasiswa</h1>
        <p class="text-gray-600 mt-1">Kelola informasi profil Anda disini.</p>
    </div>

    {{-- Main Content --}}
    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
        {{-- Header Cover (Optional visual flair) --}}
        <div class="h-32 bg-gradient-to-r from-[#09697E] to-[#1D7D94]"></div>

        <div class="px-6 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="relative">
                    <img src="{{ $dataMahasiswa->avatar }}" alt="avatar"
                        class="w-24 h-24 rounded-full border-4 border-white shadow-md object-cover bg-white">
                </div>
                <div class="mb-1">
                    <a href="{{ route('mahasiswa.profile.edit') }}"
                        class="inline-flex items-center gap-2 bg-[#E8BE00] hover:bg-[#d4ac00] text-white px-4 py-2 rounded-lg font-semibold shadow-sm transition-colors text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Data Diri --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Pribadi</h3>
                </div>

                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->name ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">NIM</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->nim ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->email ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                    <p class="text-base font-semibold text-gray-900">
                        {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Nomor HP</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->detailMahasiswa->no_hp ?? '-' }}</p>
                </div>
                <div class="space-y-1 md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->detailMahasiswa->alamat ?? '-' }}
                    </p>
                </div>

                {{-- Data Akademik --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 pb-2 mb-2 mt-4">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Akademik</h3>
                </div>

                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Program Studi</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->detailMahasiswa->prodi ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Angkatan</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->detailMahasiswa->angkatan ?? '-' }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Kelas</p>
                    <p class="text-base font-semibold text-gray-900">{{ $dataMahasiswa->detailMahasiswa->kelas ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Jenis Beasiswa</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection