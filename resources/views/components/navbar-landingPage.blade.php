{{-- Navbar Landing Page --}}
<script src="//unpkg.com/alpinejs" defer></script>

<header class="sticky top-0 z-50">
    <nav 
        x-data="{ open: false }" 
        class="bg-[#FEFEFE] text-[11pt] px-5 sm:px-7 py-2 flex justify-between items-center shadow-sm"
    >
        <!-- Logo -->
        <img src="/icon/icon-monitoring.svg" alt="e-monitoring" class="w-[100px] sm:w-[120px]">

        <!-- Menu (Desktop) -->
        <ul class="hidden md:flex items-center gap-8 text-[#09697E] font-bold">
            <li><a href="#beranda" class="hover:text-[#E8BE00]">Beranda</a></li>
            <li><a href="#tentang-beasiswa" class="hover:text-[#E8BE00]">Tentang Beasiswa</a></li>
            <li><a href="#alur" class="hover:text-[#E8BE00]">Alur Penggunaan Sistem</a></li>
        </ul>

        <!-- Tombol Masuk (Desktop) -->
        <a 
            href="{{ url('mahasiswa/login') }}" 
            class="hidden md:inline bg-yellow-400 px-4 py-2 rounded font-semibold hover:bg-yellow-500"
        >
            Masuk
        </a>

        <!-- Hamburger Menu (Mobile) -->
        <button 
            @click="open = !open" 
            class="md:hidden text-[#09697E] focus:outline-none"
        >
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Dropdown Menu (Mobile) -->
        <div 
            x-show="open"
            x-transition
            class="absolute top-full left-0 w-full bg-[#FEFEFE] shadow-md md:hidden"
        >
            <ul class="flex flex-col items-center gap-4 py-4 text-[#09697E] font-bold">
                <li><a href="#beranda" class="hover:text-[#E8BE00]" @click="open=false">Beranda</a></li>
                <li><a href="#tentang-beasiswa" class="hover:text-[#E8BE00]" @click="open=false">Tentang Beasiswa</a></li>
                <li><a href="#alur" class="hover:text-[#E8BE00]" @click="open=false">Alur Penggunaan Sistem</a></li>
                <li>
                    <a 
                        href="{{ url('mahasiswa/login') }}" 
                        class="bg-yellow-400 px-4 py-2 rounded font-semibold hover:bg-yellow-500"
                        @click="open=false"
                    >
                        Masuk
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Garis bawah -->
    <div class="flex">
        <div class="h-[9px] w-[27%] bg-[#E8BE00]"></div>
        <div class="h-[9px] w-[73%] bg-[#09697E]"></div>
    </div>
</header>
