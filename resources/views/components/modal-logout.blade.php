<div x-data="{ show: false }" x-cloak @open-logout-confirm.window="show = true" @close-logout-confirm.window="show = false">
    <div x-show="show" x-transition @click.away="show = false"
        class="fixed inset-0 bg-[#2525252d] backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-[250px] p-6 rounded-xl shadow-lg" @click.stop>

            <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">
                Konfirmasi Logout
            </h2>

            <div class="text-sm text-gray-500">
                <h3 class="mb-3">Apakah anda ingin keluar?</h3>
                <!-- Action -->
                <div class="flex justify-start gap-2">
                    <button @click="show = false"
                        class="px-2 py-1.5 text-xs sm:text-sm bg-[#09697E] hover:bg-[#145f70] text-[#fefefe] rounded-md cursor-pointer">
                        Tutup
                    </button>
                    <form method="POST" action="{{ url('mahasiswa/logout') }}">
                        @csrf
                        <button type="submit" class="px-2 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm cursor-pointer">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
