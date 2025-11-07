@extends('admin.layout')

@section('content')
<div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-l-4 border-[#09697E] my-2 sm:my-8">
    {{-- Header --}}
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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
        <h2 class="text-lg sm:text-xl font-semibold text-[#09697E]">Data Mahasiswa</h2>
        <a href="#" onclick="openModal(true)" class="bg-[#E8BE00] hover:bg-[#d4ac00] text-[#000000] font-semibold px-3 sm:px-4 py-2 rounded-lg text-sm transition w-full sm:w-auto text-center">
            + Tambah Mahasiswa
        </a>
    </div>

    @include('components.modal-tambah-mahasiswa-admin')

    {{-- Filter & Sorting --}}
    <form method="GET" action="{{ route('admin.data-mahasiswa') }}"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 mb-4">

        {{-- Search --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Mahasiswa</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau NIM..."
                class="w-full border-gray-300 p-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
        </div>

        {{-- Filter Angkatan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Angkatan</label>
            <select name="angkatan" class="w-full border-gray-300 px-2 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] cursor-pointer text-sm">
                <option value="">Semua</option>
                @foreach($angkatanList as $angkatan)
                    <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                        20{{ $angkatan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sorting Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan Nama</label>
            <select name="sort" class="w-full border-gray-300 px-2 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] cursor-pointer text-sm">
                <option value="">Default</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
            </select>
        </div>

        {{-- Button --}}
        <div class="flex items-end gap-2">
            <button type="submit"
                class="w-full bg-[#09697E] hover:bg-[#075263] text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Filter
            </button>
            <a href="{{ url('/admin/data-mahasiswa') }}"
                class="w-full bg-gray-400 hover:bg-gray-500 text-center text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Reset
            </a>
        </div>
    </form>

    {{-- Table Wrapper --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
            <thead class="bg-[#09697E] text-white">
                <tr>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                    <th class="px-8 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">NIM</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama</th>
                    {{-- Hidden on mobile --}}
                    <th class="px-3 sm:px-6 py-3 text-left font-semibold uppercase tracking-wider hidden sm:table-cell">Email</th>
                    <th class="px-8 sm:px-16 py-3 text-center font-semibold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($dataMahasiswa as $index => $mhs)
                    <tr class="hover:bg-[#f7f7f7] transition">
                        <td class="px-3 sm:px-6 py-3 text-gray-800">
                            {{ ($dataMahasiswa->currentPage() - 1) * $dataMahasiswa->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800 font-semibold break-all">{{ $mhs->nim }}</td>
                        <td class="px-3 sm:px-6 py-3 text-gray-800"><div class="line-clamp-2 md:line-clamp-1">{{ $mhs->name }}</div></td>
                        {{-- Hidden on mobile --}}
                        <td class="px-3 sm:px-6 py-3 text-gray-700 break-all hidden sm:table-cell">{{ $mhs->email }}</td>
                        <td class="px-3 sm:px-6 py-3 text-center">
                            <div class="grid justify-center grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-2">
                                <div class="w-full">
                                    <a href="{{ url('/admin/data-mahasiswa/edit/'.$mhs->nim) }}" type="submit"
                                        class="flex w-full bg-[#09697E] hover:bg-[#075263] text-white py-2 rounded text-xs cursor-pointer">
                                            <div class="w-full flex items-center justify-center">Edit</div>
                                    </a>
                                </div>
                                <form method="POST" action="{{ url('/admin/data-mahasiswa/'.$mhs->nim) }}"
                                      onsubmit="return confirm('Hapus data mahasiswa {{$mhs->nim}}?')" class="w-full">
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
                        <td colspan="5" class="text-center py-6 text-gray-500 italic">
                            Tidak ada data mahasiswa
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $dataMahasiswa->withQueryString()->links() }}
    </div>
</div>
@endsection
