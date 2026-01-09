@props(['modalId', 'action'])

<div id="{{ $modalId }}" class="fixed inset-0 z-50 bg-gray-900/50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full m-4 overflow-hidden transform transition-all">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pengumuman Baru</h3>
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
            <div class="p-6 space-y-4">
                <div class="text-sm">
                    <label for="judul" class="font-semibold text-gray-700 block mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" id="judul" required placeholder="Masukkan judul..."
                        class="w-full py-2 px-3 border-gray-300 rounded-md shadow-sm focus:border-[#09697E] focus:ring focus:ring-cyan-500/50 transition">
                </div>

                <div class="text-sm">
                    <label for="isi" class="font-semibold text-gray-700 block mb-1">Isi Pengumuman</label>
                    <textarea name="isi" id="isi" rows="4" required placeholder="Masukkan isi pengumuman..."
                        class="w-full py-2 px-3 border-gray-300 rounded-md shadow-sm focus:border-[#09697E] focus:ring focus:ring-cyan-500/50 transition"></textarea>
                </div>

                <div class="flex items-center text-sm">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-[#09697E] focus:ring-[#09697E] border-gray-300 rounded" value="1" checked>
                    <label for="is_active" class="ml-2 block text-gray-900 font-medium">
                        Aktifkan Pengumuman
                    </label>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2">
                <button type="submit"
                    class="flex text-white bg-[#09697E] hover:bg-[#075263] font-medium rounded-md py-2 px-6 transition text-sm shadow-md">
                    Simpan
                </button>
                <a href="#" class="py-2 px-4 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm transition"
                    onclick="document.getElementById('{{ $modalId }}').classList.add('hidden'); return false;">Batal</a>
            </div>
        </form>
    </div>
</div>
