@props([
    'deleteRoute' => '',
])

<div x-data="{ open: false, deleteId: null, deleteRoute: '' }"
    x-on:delete-row.window="deleteId = $event.detail.id; deleteRoute = $event.detail.route; open = true" x-cloak>
    <div x-show="open" class="fixed inset-0 bg-[#25252550] flex items-center justify-center z-50">
        <div class="w-auto h-[250px] bg-[#f9f9f9] rounded-sm px-4 py-3.5">
            <div class="flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="exclamation-circle"
                    class="w-[120px] h-[120px]">
                    <path fill="#FF0000"
                        d="M12,14a1.25,1.25,0,1,0,1.25,1.25A1.25,1.25,0,0,0,12,14Zm0-1.5a1,1,0,0,0,1-1v-3a1,1,0,0,0-2,0v3A1,1,0,0,0,12,12.5ZM12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Z">
                    </path>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-center">Konfirmasi Hapus</h2>
            <p class="mt-2 text-center">Apakah Anda yakin ingin menghapus data ini?</p>

            <div class="flex justify-center gap-2 mt-4">
                <button @click="open = false" class="px-3 py-1 rounded bg-[#dedede] hover:bg-[#d7d7d7]">
                    Batal
                </button>
                <form method="POST" :action="deleteRoute">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 rounded bg-red-500 hover:bg-red-800 text-white">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
