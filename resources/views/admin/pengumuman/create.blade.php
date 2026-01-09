@extends('admin.layout')

@section('content')
<main class="min-h-screen p-6 bg-gray-50 font-sans">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.pengumuman.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Pengumuman</h1>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman</label>
                    <input type="text" name="judul" id="judul" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#09697E] focus:border-[#09697E] transition duration-200" placeholder="Masukkan judul pengumuman" value="{{ old('judul') }}" required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">Isi Pengumuman</label>
                    <textarea name="isi" id="isi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#09697E] focus:border-[#09697E] transition duration-200" placeholder="Masukkan isi pengumuman" required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-[#09697E] focus:ring-[#09697E] border-gray-300 rounded" value="1" checked>
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan Pengumuman
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#09697E] text-white px-6 py-2 rounded-lg hover:bg-[#075263] transition duration-300 shadow-md font-semibold">
                        Simpan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
