{{-- Navbar Mahasiswa --}}
<script src="//unpkg.com/alpinejs" defer></script>

<header class="sticky top-0 z-50">
    <nav class="flex text-[11pt] bg-[#FEFEFE] px-7 py-2 justify-between items-center">
        <img src="/icon/icon-monitoring.svg" alt="e-monitoring" class="w-[120px]">
        <ul class="flex items-center gap-10 text-[#09697E] font-bold">
            <li><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('mahasiswa.isi-monev') }}">Laporan Monev</a></li>
            <li><a href="">Riwayat Laporan</a></li>
        </ul>
        {{-- Dropdown disini --}}
        <div x-data="{ open: false }"
            class="flex items-center justify-center gap-2 bg-[#f6f6f6] p-1 rounded-xl cursor-pointer">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none cursor-pointer">
                <img src="{{ $mhsAvatar }}" class="w-[25px] h-[25px] rounded-xl" alt="avatar">
                {{-- <p class="text-[9pt] text-[#09697E] font-bold">{{ $mhsName ?? 'Mahasiswa' }}</p> --}}
                <svg class="w-4 h-4 text-[#09697E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 top-10 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="user"
                            class="w-[20px] h-[20px]">
                            <path fill="#09697E"
                                d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z">
                            </path>
                        </svg>
                        Profil Saya
                    </div>
                </a>
                <form method="POST" action="{{ url('mahasiswa/logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-[#FF0303] hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="signout"
                            class="w-[20px] h-[20px]">
                            <path fill="#FF0303"
                                d="M4,12a1,1,0,0,0,1,1h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4a1,1,0,0,0,.21-.33,1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4a1,1,0,1,0-1.42,1.42L12.59,11H5A1,1,0,0,0,4,12ZM17,2H7A3,3,0,0,0,4,5V8A1,1,0,0,0,6,8V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0v3a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V5A3,3,0,0,0,17,2Z">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="flex">
        <div class="h-[9px] w-[27%] bg-[#E8BE00]"></div>
        <div class="h-[9px] w-[73%] bg-[#09697E]"></div>
    </div>
</header>