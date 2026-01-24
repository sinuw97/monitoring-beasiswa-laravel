@props(['deleteRoute' => ''])

<div x-data="{ open: false, deleteId: null, deleteRoute: '' }"
    x-on:delete-row.window="deleteId = $event.detail.id; deleteRoute = $event.detail.route; open = true" x-cloak>

    <div x-show="open" class="fixed inset-0 bg-[#2525252d] backdrop-blur-sm flex items-center justify-center z-50"
        x-transition>

        <div @click.stop
            class="bg-[#f9f9f9] rounded-md px-6 py-5 shadow-lg
                   w-[90%] max-w-sm md:max-w-md
                   transition-all duration-200">

            <div class="flex justify-center items-center">
                <svg class="w-20 h-20 md:w-28 md:h-28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#FF0000"
                        d="M12,14a1.25,1.25,0,1,0,1.25,1.25A1.25,1.25,0,0,0,12,14Zm0-1.5a1,1,0,0,0,1-1v-3a1,1,0,0,0-2,0v3A1,1,0,0,0,12,12.5ZM12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Z">
                    </path>
                </svg>
            </div>

            <h2 class="text-lg font-semibold text-center mt-2">Konfirmasi Hapus</h2>
            <p class="mt-1 text-center text-sm md:text-base">
                Apakah Anda yakin ingin menghapus data ini?
            </p>

            {{-- BUTTON SECTION --}}
            <div class="flex justify-center gap-3 mt-5">
                <button @click="open = false" class="px-4 py-1 rounded bg-gray-200 hover:bg-gray-300 transition">
                    Batal
                </button>

                <form method="POST" :action="deleteRoute" x-data="{ deleting: false }" x-on:submit="deleting = true" :class="deleting ? 'cursor-not-allowed' : ''">
                    @csrf
                    @method('DELETE')
                    <button type="submit" :disabled="deleting"
                        :class="deleting
                            ?
                            'cursor-not-allowed bg-gray-400' :
                            'cursor-pointer bg-red-500 hover:bg-red-700'"
                        class="px-4 py-1 transition text-white rounded">
                        <span x-show="!deleting">Hapus</span>
                        <span x-show="deleting">Menghapus...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
