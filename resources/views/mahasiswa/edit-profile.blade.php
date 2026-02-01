@extends('mahasiswa.layout')

@section('title', 'Edit Profil')

@section('content')
    <div class="mb-6">
        <h1 class="font-bold text-3xl text-gray-800">Edit Profil</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi kontak dan alamat Anda.</p>
    </div>

    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100 max-w-4xl">
        <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="p-6">
            @csrf
            {{-- Header with Back Button --}}
            <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-gray-800">Form Edit Profil</h2>
                <a href="{{ route('mahasiswa.profile') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Read Only Fields --}}
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap (Tidak dapat diubah)</label>
                    <input type="text" value="{{ $dataMahasiswa->name }}" disabled
                        class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed">
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">NIM (Tidak dapat diubah)</label>
                    <input type="text" value="{{ $dataMahasiswa->nim }}" disabled
                        class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed">
                </div>

                {{-- Editable Fields --}}
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $dataMahasiswa->email) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-[#09697E] focus:border-[#09697E] transition-colors">
                </div>
                <div class="space-y-1">
                    <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" id="no_hp"
                        value="{{ old('no_hp', $dataMahasiswa->detailMahasiswa->no_hp) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-[#09697E] focus:border-[#09697E] transition-colors">
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat <span
                            class="text-red-500">*</span></label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-[#09697E] focus:border-[#09697E] transition-colors">{{ old('alamat', $dataMahasiswa->detailMahasiswa->alamat) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('mahasiswa.profile') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-[#09697E] text-white font-semibold rounded-lg hover:bg-[#075363] transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection