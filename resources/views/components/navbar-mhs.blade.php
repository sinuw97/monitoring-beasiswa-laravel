<script src="//unpkg.com/alpinejs" defer></script>

<header class="sticky top-0 z-50">
    <nav class="flex text-[11pt] bg-[#FEFEFE] px-7 py-2 justify-between items-center">
        <img src="/icon/icon-monitoring.svg" alt="e-monitoring" class="w-[120px]">
        <ul class="hidden sm:flex items-center gap-10 text-[#09697E] font-bold">
            <li><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('mahasiswa.laporan-monev') }}">Laporan Monev</a></li>
            <li><a href="{{ route('mahasiswa.riwayat-laporan') }}">Riwayat Laporan</a></li>
        </ul>

        {{-- Dropdown disini --}}
        <div x-data="{ open: false }" x-cloak
            class="flex items-center justify-center gap-2 bg-[#f6f6f6] p-1 rounded-xl cursor-pointer">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none cursor-pointer">
                <img src="{{ $mhsAvatar }}" class="w-[25px] h-[25px] rounded-xl" alt="avatar">

                <svg class="w-4 h-4 text-[#09697E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 top-10 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 md:hidden md:invisible">
                    <div class="flex items-center gap-2">
                        <svg viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="w-[20px] h-[20px]">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.918 10.0005H7.082C6.66587 9.99708 6.26541 10.1591 5.96873 10.4509C5.67204 10.7427 5.50343 11.1404 5.5 11.5565V17.4455C5.5077 18.3117 6.21584 19.0078 7.082 19.0005H9.918C10.3341 19.004 10.7346 18.842 11.0313 18.5502C11.328 18.2584 11.4966 17.8607 11.5 17.4445V11.5565C11.4966 11.1404 11.328 10.7427 11.0313 10.4509C10.7346 10.1591 10.3341 9.99708 9.918 10.0005Z"
                                    stroke="#09697E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.918 4.0006H7.082C6.23326 3.97706 5.52559 4.64492 5.5 5.4936V6.5076C5.52559 7.35629 6.23326 8.02415 7.082 8.0006H9.918C10.7667 8.02415 11.4744 7.35629 11.5 6.5076V5.4936C11.4744 4.64492 10.7667 3.97706 9.918 4.0006Z"
                                    stroke="#09697E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.082 13.0007H17.917C18.3333 13.0044 18.734 12.8425 19.0309 12.5507C19.3278 12.2588 19.4966 11.861 19.5 11.4447V5.55666C19.4966 5.14054 19.328 4.74282 19.0313 4.45101C18.7346 4.1592 18.3341 3.9972 17.918 4.00066H15.082C14.6659 3.9972 14.2654 4.1592 13.9687 4.45101C13.672 4.74282 13.5034 5.14054 13.5 5.55666V11.4447C13.5034 11.8608 13.672 12.2585 13.9687 12.5503C14.2654 12.8421 14.6659 13.0041 15.082 13.0007Z"
                                    stroke="#09697E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.082 19.0006H17.917C18.7661 19.0247 19.4744 18.3567 19.5 17.5076V16.4936C19.4744 15.6449 18.7667 14.9771 17.918 15.0006H15.082C14.2333 14.9771 13.5256 15.6449 13.5 16.4936V17.5066C13.525 18.3557 14.2329 19.0241 15.082 19.0006Z"
                                    stroke="#09697E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                        Dashboard
                    </div>
                </a>
                <a href="{{ route('mahasiswa.laporan-monev') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 md:hidden md:invisible">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="clipboard-notes"
                            class="w-[20px] h-[20px]">
                            <path fill="#09697E"
                                d="M13,14H9a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2ZM17,4H15.82A3,3,0,0,0,13,2H11A3,3,0,0,0,8.18,4H7A3,3,0,0,0,4,7V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V7A3,3,0,0,0,17,4ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm8,14a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V7A1,1,0,0,1,7,6H8V7A1,1,0,0,0,9,8h6a1,1,0,0,0,1-1V6h1a1,1,0,0,1,1,1Zm-3-9H9a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z">
                            </path>
                        </svg>
                        Laporan Monev
                    </div>
                </a>
                <a href="{{ route('mahasiswa.riwayat-laporan') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 md:hidden md:invisible">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="history"
                            class="w-[20px] h-[20px]">
                            <path fill="#09697E"
                                d="M12,2A10,10,0,0,0,5.12,4.77V3a1,1,0,0,0-2,0V7.5a1,1,0,0,0,1,1H8.62a1,1,0,0,0,0-2H6.22A8,8,0,1,1,4,12a1,1,0,0,0-2,0A10,10,0,1,0,12,2Zm0,6a1,1,0,0,0-1,1v3a1,1,0,0,0,1,1h2a1,1,0,0,0,0-2H13V9A1,1,0,0,0,12,8Z">
                            </path>
                        </svg>
                        Riwayat Laporan
                    </div>
                </a>
                <div class="h-[1px] w-full bg-gray-300 hidden invisible"></div>

                {{-- Profile --}}
                <a href="{{ route('mahasiswa.profile') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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

                <div>
                    {{-- Ganti PW --}}
                    <button
                        @click="
                    open = false;
                    $dispatch('open-ganti-password')
                    "
                    type="button"
                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left">
                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="w-[20px] h-[20px]">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M10 14.0505C9.36474 13.4022 8.47934 13 7.5 13C5.567 13 4 14.567 4 16.5C4 18.433 5.567 20 7.5 20C9.433 20 11 18.433 11 16.5C11 15.5463 10.6186 14.6818 10 14.0505ZM10 14.0505L15.0316 9.01894M18.5 5.5L17.2689 6.75631M15.0316 9.01894L16.0379 8.01263L17.2689 6.75631M15.0316 9.01894L17.0126 11M17.2689 6.75631L20.0126 9.5"
                                        stroke="#09697E" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg>
                            Ganti Password
                        </div>
                    </button>

                    {{-- Logout --}}
                    <button @click="
                        open = false;
                        $dispatch('open-logout-confirm')
                    "
                        type="button"
                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-[#FF0303] hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="signout"
                            class="w-[20px] h-[20px]">
                            <path fill="#FF0303"
                                d="M4,12a1,1,0,0,0,1,1h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4a1,1,0,0,0,.21-.33,1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4a1,1,0,1,0-1.42,1.42L12.59,11H5A1,1,0,0,0,4,12ZM17,2H7A3,3,0,0,0,4,5V8A1,1,0,0,0,6,8V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0v3a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V5A3,3,0,0,0,17,2Z">
                            </path>
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <div class="flex">
        <div class="h-[9px] w-[27%] bg-[#E8BE00]"></div>
        <div class="h-[9px] w-[73%] bg-[#09697E]"></div>
    </div>
</header>

<x-modal-ganti-pw />
<x-modal-logout />
