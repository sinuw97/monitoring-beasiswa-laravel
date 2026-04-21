@props(['modalId', 'pengumuman'])

<div id="{{ $modalId }}" class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full flex flex-col max-h-[90vh] overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="{{ $modalId }}-content">
        {{-- Header --}}
        <div class="relative flex-shrink-0 bg-gradient-to-r from-[#09697E] to-[#0c829c] p-6 text-white border-b border-white/10">
            <h3 class="text-xl sm:text-2xl font-bold pr-8">{{ $pengumuman->judul }}</h3>
            <p class="text-cyan-100 text-xs sm:text-sm mt-1">
                {{ \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('l, d F Y') }}
            </p>
            <button onclick="closeModal('{{ $modalId }}')" class="absolute top-4 right-4 text-white/70 hover:text-white transition bg-white/10 hover:bg-white/20 rounded-full p-1.5 sm:p-2">
                <svg class="w-5 h-5 sm:w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 sm:p-8 overflow-y-auto flex-grow custom-scrollbar">
            <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-4 flex justify-end flex-shrink-0 border-t border-gray-100">
            <button onclick="closeModal('{{ $modalId }}')" class="px-5 py-2 sm:px-6 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition shadow-sm text-sm sm:text-base">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #09697E;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #0c829c;
    }
</style>

<script>
    if (typeof openModal !== 'function') {
        function openModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById(id + '-content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById(id + '-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }
</script>
