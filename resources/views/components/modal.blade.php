<!-- Modal -->
<div x-show="{{ $show }}" x-cloak
    class="fixed inset-0 bg-[#2525252d] backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition
    @click.away="{{ $show }} = false">
    <div class="bg-white w-full max-w-[400px] p-6 rounded-xl shadow-lg" @click.stop>

        @if ($title)
            <h2 class="text-lg font-bold mb-4 text-gray-800">{{ $title }}</h2>
        @endif

        {{-- form content --}}
        <div class="space-y-3 overflow-y-auto max-h-[80vh]">
            {{ $slot }}
        </div>

    </div>
</div>