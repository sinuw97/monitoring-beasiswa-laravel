@props(['modalId', 'action', 'periode'])

<div id="{{ $modalId }}" class="fixed inset-0 z-50 bg-gray-900/50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full m-4 overflow-hidden transform transition-all">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Edit Periode</h3>
            <a href="#" class="text-gray-400 hover:text-gray-600 transition"
                onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); return false;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </a>
        </div>

        <form action="{{ $action }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-4 space-y-3">
                <div class="text-sm">
                    <label for="tanggal_mulai_{{ $periode->semester_id }}"
                        class="font-semibold text-gray-700 block mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai_{{ $periode->semester_id }}"
                        value="{{ $periode->tanggal_mulai ? \Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y-m-d') : '' }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="text-sm">
                    <label for="tanggal_selesai_{{ $periode->semester_id }}"
                        class="font-semibold text-gray-700 block mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai_{{ $periode->semester_id }}"
                        value="{{ $periode->tanggal_selesai ? \Carbon\Carbon::parse($periode->tanggal_selesai)->format('Y-m-d') : '' }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2">
                <button type="submit"
                    class="flex text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-md py-2 px-4 transition text-sm">
                    Simpan
                </button>
                <a href="#" class="py-2 px-4 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition"
                    onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); return false;">Batal</a>
            </div>
        </form>
    </div>
</div>
