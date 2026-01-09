@props(['modalId', 'pengumuman'])

<div id="{{ $modalId }}" class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full m-4 overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="{{ $modalId }}-content">
        {{-- Header --}}
        <div class="relative bg-gradient-to-r from-[#09697E] to-[#0c829c] p-6 text-white">
            <h3 class="text-2xl font-bold pr-8">{{ $pengumuman->judul }}</h3>
            <p class="text-cyan-100 text-sm mt-1">
                {{ \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('l, d F Y') }}
            </p>
            <button onclick="closeModal('{{ $modalId }}')" class="absolute top-4 right-4 text-white/70 hover:text-white transition bg-white/10 hover:bg-white/20 rounded-full p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 sm:p-8">
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-4 flex justify-end">
            <button onclick="closeModal('{{ $modalId }}')" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition shadow-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

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
