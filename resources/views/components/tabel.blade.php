@props([
    'headers' => [], // Untuk nama headers pd tiap tabel ["No", "semester", 'ips', ...]
    'columns' => [], // Untuk nama kolomnya ['semester', 'ips', ...]
    'rows' => [], // collection atau array of arrays/objects
    'idKey' => 'id', // nama key untuk id tiap row
    'editEvent' => 'edit-row', // default
    'deleteRoute' => '', // default value
    'status' => 'Draft',
    'style' => ''
])

<table class="min-w-full text-sm shadow-lg bg-white border-separate border-spacing-0 m-4">
    <thead>
        @if ($style === 'riwayat')
        <tr class="bg-[#09697E]">
            @foreach ($headers as $header)
                <th class="px-4 py-2 text-center text-white">{{ $header }}</th>
            @endforeach
        </tr>
        @elseif ($style === 'draft')
        <tr class="bg-[#E8BE00]">
            @foreach ($headers as $header)
                <th class="px-4 py-2 text-center">{{ $header }}</th>
            @endforeach
            @if ($status === 'Draft')
                <th class="px-4 py-2 text-center">Aksi</th>
            @endif
        </tr>
        @endif
    </thead>
    <tbody>
        @forelse(($rows ?? []) as $row)
            <tr class="odd:bg-[#f8f8f8] even:bg-[#f2f2f2] hover:bg-[#f1f1f1]">
                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                @foreach ($columns as $col)
                    <td class="px-4 py-2 text-center">
                        @php
                            $value = data_get($row, $col);
                        @endphp

                        @if ($col === 'bukti' && $value && $value !== 'Tidak Ada')
                            <a href="{{ $value }}" target="_blank" class="text-blue-600 underline">
                                Lihat Bukti
                            </a>
                        @elseif ($col === 'status' && $value && $value === 'Draft')
                            <span class="bg-[#cecece] px-2 py-1 rounded-xl">
                                {{ $value }}
                            </span>
                        @elseif ($col === 'status' && $value && $value === 'Pending')
                            <span class="bg-[#ffdd44] px-2 py-1 rounded-xl">
                                {{ $value }}
                            </span>
                        @elseif ($col === 'status' && $value && $value === 'Valid')
                            <span class="bg-[#44c96a] px-2 py-1 rounded-xl text-[#fbfbfb]">
                                {{ $value }}
                            </span>
                        @elseif ($col === 'status' && $value && $value === 'Rejected')
                            <span class="bg-[#e73424] px-2 py-1 rounded-xl">
                                {{ $value }}
                            </span>
                        @else
                            {{ $value ?? '-' }}
                        @endif
                    </td>
                @endforeach

                @if ($status === 'Draft')
                    {{-- Aksi: dispatch event supaya parent yang pegang modal bisa nangani --}}
                    <td class="px-4 py-2">
                        <div class="flex justify-center items-center gap-3">
                            <button type="button" class="flex justify-center items-center gap-2 cursor-pointer px-3 py-0.5 text-white bg-[#2179ca] hover:bg-[#1c6bb4] rounded-sm"
                                if @click="$dispatch('{{ $editEvent }}', {{ json_encode($row) }})">
                                <img src="/icon/edit.png" alt="edit-icon" class="w-[15px] h-[15px]"> Edit
                            </button>

                            <button type="button" class="flex justify-center items-center gap-2 cursor-pointer px-3 py-0.5 bg-red-500 hover:bg-red-600 text-white rounded-sm"
                                @click="$dispatch('{{ 'delete-row' }}', {
                                id: '{{ data_get($row, $idKey) }}',
                                route: '{{ route($deleteRoute, data_get($row, $idKey)) }}'})">
                                <img src="/icon/delete.png" alt="edit-icon" class="w-[15px] h-[15px]"> Hapus
                            </button>
                        </div>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) + 1 }}" class="px-4 py-4 text-center">
                    Tidak ada data
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

