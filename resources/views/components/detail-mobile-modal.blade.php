{{-- resources/views/components/detail-mobile-modal.blade.php --}}

@props(['report', 'modalId', 'type', 'fields'])

<div id="{{ $modalId }}" class="modal-target hidden sm:hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full m-4 overflow-hidden transform transition-all">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Detail Laporan</h3>
            <a href="#" class="text-gray-400 hover:text-gray-600 transition" onclick="history.back()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>

        <div class="p-4 space-y-3">
            @foreach ($fields as $label => $value)
            <div class="text-sm">
                <p class="font-semibold text-gray-700">{{ $label }}:</p>
                @if ($label === 'Bukti')
                    @if ($value != 'Tidak Ada' && $value)
                        <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline break-words">Lihat Bukti</a>
                    @else
                        <p class="text-gray-500">Tidak Ada</p>
                    @endif
                @elseif ($label === 'Status')
                    @include('components.status-badge', ['status' => $value])
                @else
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $value }}</p>
                @endif
            </div>
            @endforeach
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2">
             {{-- Tambahkan tombol Edit di dalam modal detail juga --}}
            <a href="#editModal-{{ $report['id'] }}" class="flex text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition text-sm">
                <span class="my-auto">Edit Data</span>
            </a>
            <a href="#" class="py-2 px-4 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition" onclick="history.back()">Tutup</a>
        </div>
    </div>
</div>

<style>
    /* Hanya perlu menambahkan class `hidden sm:hidden` pada modal target untuk memastikan ia hanya muncul di mobile */
    /* Karena modal-target menggunakan :target selector, kita perlu memastikan ia di-hide secara default di sm+ */
    #{{ $modalId }}:target {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
    }
</style>
