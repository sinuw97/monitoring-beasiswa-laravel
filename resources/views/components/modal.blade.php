<!-- Modal -->
<div x-show="{{ $show }}" x-cloak
    class="fixed inset-0 bg-[#f5f5f566] bg-opacity-50 flex items-center justify-center z-50" x-transition
    @click.away="{{ $show }} = false">

    <div class="bg-white p-4 rounded-lg shadow-lg w-[400px]" @click.stop>
        @if ($title)
            <h2 class="text-lg font-bold mb-4">{{ $title }}</h2>
        @endif
        {{-- form --}}
        {{ $slot }}
    </div>
</div>