@extends('admin.layout')

@section('content')
    <div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-t-4 border-[#09697E] my-6 sm:my-8">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md flex justify-between items-center"
                role="alert">
                <div class="flex items-center">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Error Messages --}}
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md flex justify-between items-center"
                role="alert">
                <div class="flex items-center">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                    <div>
                        <p class="font-bold">Gagal!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg shadow-md flex justify-between items-center"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg>
                        <div>
                            <p class="font-bold">Gagal!</p>
                            <p class="text-sm">{{ $error }}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            @endforeach
        @endif

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-[#09697E]">Data Mahasiswa</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data mahasiswa penerima beasiswa</p>
            </div>
            <button onclick="openModal(true)"
                class="mt-3 sm:mt-0 inline-flex items-center gap-2 bg-[#E8BE00] hover:bg-[#d4ac00] text-gray-900 font-bold px-4 py-2.5 rounded-lg text-sm transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Mahasiswa
            </button>
        </div>

        @include('components.modal-tambah-mahasiswa-admin')

        {{-- Filter & Search Section --}}
        <form method="GET" action="{{ route('admin.data-mahasiswa') }}"
            class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                {{-- Search --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Cari Mahasiswa</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIM..."
                            class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 text-sm transition">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Filter Angkatan --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Angkatan</label>
                    <select name="angkatan"
                        class="w-full py-2 px-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 cursor-pointer text-sm transition">
                        <option value="">Semua Angkatan</option>
                        @foreach ($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                                20{{ $angkatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sorting Nama --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Urutkan Nama</label>
                    <select name="sort"
                        class="w-full py-2 px-2 border-gray-300 rounded-lg shadow-sm focus:border-[#09697E] focus:ring focus:ring-[#09697E] focus:ring-opacity-20 cursor-pointer text-sm transition">
                        <option value="">Default</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">
                    <a href="{{ url('/admin/data-mahasiswa') }}"
                        class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition text-center">
                        Reset
                    </a>
                    <button type="submit"
                        class="flex-1 bg-[#09697E] hover:bg-[#075263] text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Terapkan
                    </button>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Email</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($dataMahasiswa as $index => $mhs)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                    {{ ($dataMahasiswa->currentPage() - 1) * $dataMahasiswa->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 font-semibold">{{ $mhs->nim }}</td>
                                <td class="px-6 py-4 text-gray-900">
                                    <div class="max-w-xs truncate">{{ $mhs->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">
                                    <div class="max-w-xs truncate">{{ $mhs->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ url('/admin/data-mahasiswa/edit/' . $mhs->nim) }}"
                                            class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>

                                        <button
                                            onclick="showConfirmationModal('Hapus data mahasiswa {{ $mhs->nim }}?', '{{ route('admin.data-mahasiswa.destroy', $mhs->nim) }}', 'DELETE')"
                                            class="text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 p-2 rounded-lg transition"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="font-medium">Tidak ada data mahasiswa</p>
                                        <p class="text-sm mt-1">Silakan tambah mahasiswa baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $dataMahasiswa->withQueryString()->links() }}
        </div>
    </div>
@endsection
