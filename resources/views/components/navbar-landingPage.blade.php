{{-- Navbar Landing Page --}}
<script src="//unpkg.com/alpinejs" defer></script>

<header class="sticky top-0 z-50">
    <nav class="flex text-[11pt] bg-[#FEFEFE] px-7 py-2 justify-between items-center">
        <img src="/icon/icon-monitoring.svg" alt="e-monitoring" class="w-[120px]">
        <ul class="flex items-center gap-10 text-[#09697E] font-bold">
            <li><a href="">Beranda</a></li>
            <li><a href="">Tentang Beasiswa</a></li>
            <li><a href="">Alur Penggunaan Sistem</a></li>
        </ul>
        <a href="{{ url('mahasiswa/login') }}" class="bg-yellow-400 px-4 py-2 rounded font-semibold hover:bg-yellow-500">Masuk</a>
    </nav>
    <div class="flex">
        <div class="h-[9px] w-[27%] bg-[#E8BE00]"></div>
        <div class="h-[9px] w-[73%] bg-[#09697E]"></div>
    </div>
</header>