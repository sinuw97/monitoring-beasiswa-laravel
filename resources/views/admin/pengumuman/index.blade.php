@extends('admin.layout')

@section('content')
<main class="min-h-screen p-2 sm:p-6 bg-gray-50 font-sans">
    <div class="bg-white w-full max-w-5xl mx-auto shadow-lg rounded-xl p-2 sm:p-6 border-t-4 border-[#09697E] my-6 sm:my-8 text-sm">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md flex justify-between items-center" role="alert">
                <div class="flex items-center">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-[#09697E]">Manajemen Pengumuman</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi dan berita untuk mahasiswa</p>
            </div>
            
            <button onclick="document.getElementById('addPengumumanModal').classList.remove('hidden')"
                class="mt-3 sm:mt-0 inline-flex items-center gap-2 bg-[#E8BE00] hover:bg-[#d4ac00] text-gray-900 font-bold px-4 py-2.5 rounded-lg text-sm transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Pengumuman
            </button>
        </div>

        @include('components.modal-add-pengumuman', [
            'modalId' => 'addPengumumanModal',
            'action' => route('admin.pengumuman.store'),
        ])
        @include('components.modal-delete')


        {{-- Table --}}
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Isi</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($pengumuman as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                {{ ($pengumuman->currentPage() - 1) * $pengumuman->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ $item->judul }}</td>
                            <td class="px-6 py-4 text-gray-600 hidden sm:table-cell">
                                <div class="max-w-xs truncate" title="{{ $item->isi }}">{{ Str::limit($item->isi, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs hidden md:table-cell">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <button 
                                        onclick="document.getElementById('editModal-{{ $item->id }}').classList.remove('hidden')"
                                        class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition" 
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>

                                    {{-- Delete Button (Alpine Dispatch) --}}
                                    <button 
                                        x-data
                                        x-on:click="$dispatch('delete-row', { id: {{ $item->id }}, route: '{{ route('admin.pengumuman.destroy', $item->id) }}' })"
                                        class="text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 p-2 rounded-lg transition" 
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                {{-- Edit Modal (Rendered per row) --}}
                                @include('components.modal-edit-pengumuman', [
                                    'modalId' => 'editModal-' . $item->id,
                                    'action' => route('admin.pengumuman.update', $item->id),
                                    'pengumuman' => $item,
                                ])
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="font-medium">Belum ada pengumuman.</p>
                                    <p class="text-sm mt-1">Silakan tambah pengumuman baru.</p>
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
            {{ $pengumuman->links() }}
        </div>
    </div>
</main>
@endsection
