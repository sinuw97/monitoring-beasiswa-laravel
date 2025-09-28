@props([
    'headers' => [], // Untuk nama headers pd tiap tabel ["No", "semester", 'ips', ...]
    'columns' => [], // Untuk nama kolomnya ['semester', 'ips', ...]
    'rows' => [], // collection atau array of arrays/objects
    'idKey' => 'id', // nama key untuk id tiap row
    // 'rawColumns' => [],
    'editEvent' => 'edit-row', // default
    'deleteRoute' => '', // default value
    'status' => 'Draft',
])

<table class="min-w-full text-sm shadow-lg bg-white border-separate border-spacing-0 m-4">
    <thead>
        <tr class="bg-[#E8BE00]">
            @foreach ($headers as $header)
                <th class="px-4 py-2 text-center">{{ $header }}</th>
            @endforeach
            @if ($status === 'Draft')
                <th class="px-4 py-2 text-center">Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse(($rows ?? []) as $row)
            <tr class="bg-[#f8f8f8]">
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
                            <span class="bg-green-400 px-2 py-1 rounded-md">
                                {{ $value }}
                            </span>
                        @elseif ($col === 'status' && $value && $value === 'Pending')
                            <span class="bg-[#ffdd44] px-1.5 py-1 rounded-md">
                                {{ $value }}
                            </span>
                        @else
                            {{ $value ?? '-' }}
                        @endif
                    </td>
                @endforeach

                @if ($status === 'Draft')
                    {{-- Aksi: dispatch event supaya parent yang pegang modal bisa nangani --}}
                    <td class="px-4 py-2 flex justify-center items-center gap-3">
                        <button type="button" class="cursor-pointer px-3 py-0.5 text-white bg-[#013F4E] rounded-xl" if
                            @click="$dispatch('{{ $editEvent }}', {{ json_encode($row) }})">
                            Edit
                        </button>

                        <button type="button" class="cursor-pointer px-3 py-0.5 bg-red-500 text-white rounded-sm"
                            @click="$dispatch('{{ 'delete-row' }}', {
                                id: '{{ data_get($row, $idKey) }}',
                                route: '{{ route($deleteRoute, data_get($row, $idKey)) }}'})">
                            Hapus
                        </button>
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
