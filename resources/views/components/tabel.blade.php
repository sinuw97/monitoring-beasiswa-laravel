@props([
    'headers' => [], // Untuk nama headers pd tiap tabel ["No", "semester", 'ips', ...]
    'columns' => [], // Untuk nama kolomnya ['semester', 'ips', ...]
    'rows' => [], // collection atau array of arrays/objects
    'idKey' => 'id', // nama key untuk id tiap row
    'editEvent' => 'edit-row', // default
    'deleteRoute' => '', // default value
    'status' => 'Draft',
    'style' => '',
])

@php
    // Kolom aksi akan muncul di tabel yg memiliki status Draft dan Dikembalikan
    $showActionColumn = in_array($status, ['Draft', 'Dikembalikan']);
    // Draft BISA edit dan hapus, Dikembalikan dan datanya Revisi HANYA BOLEH edit
    $canEdit = $status === 'Draft' || $status === 'Dikembalikan';
    $canDelete = $status === 'Draft' && $deleteRoute;
@endphp

<table class="min-w-full table-fixed text-sm shadow-lg bg-white border-separate border-spacing-0 m-4">
    <thead>
        {{-- Style Detail laporan --}}
        @if ($style === 'riwayat')
            <tr class="bg-[#09697E]">
                @foreach ($headers as $header)
                    <th class="px-4 py-2 text-center text-white">
                        {{ $header }}
                    </th>
                @endforeach

                @if ($showActionColumn)
                    <th class="px-4 py-2 text-center text-white">Aksi</th>
                @endif
            </tr>

            {{-- Style Draft Laporan --}}
        @elseif ($style === 'draft')
            <tr class="bg-[#E8BE00]">
                @foreach ($headers as $header)
                    <th class="px-4 py-2 text-center">
                        {{ $header }}
                    </th>
                @endforeach

                @if ($showActionColumn)
                    <th class="px-4 py-2 text-center">Aksi</th>
                @endif
            </tr>
        @endif
    </thead>

    <tbody>
        @forelse($rows as $row)
            <tr class="odd:bg-[#f8f8f8] even:bg-[#f2f2f2] hover:bg-[#f1f1f1]">
                {{-- no --}}
                <td class="px-4 py-2 text-center">
                    {{ $loop->iteration }}
                </td>

                {{-- Data kegiatan --}}
                @foreach ($columns as $col)
                    @php
                        $value = data_get($row, $col);
                    @endphp

                    <td class="px-4 py-2 text-center">
                        {{-- Lihat bukti --}}
                        @if ($col === 'bukti' && $value && $value !== 'Tidak Ada')
                            <a href="{{ $value }}" target="_blank" class="text-blue-600 underline">
                                Lihat Bukti
                            </a>

                            {{-- Status kegiatan --}}
                        @elseif ($col === 'status')
                            @switch($value)
                                @case('Draft')
                                    <span class="bg-gray-300 px-2 py-1 rounded-xl">
                                        Draft
                                    </span>
                                @break

                                @case('Pending')
                                    <span class="bg-yellow-300 px-2 py-1 rounded-xl">
                                        Pending
                                    </span>
                                @break

                                @case('Valid')
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-xl">
                                        Valid
                                    </span>
                                @break

                                @case('Revisi')
                                    <span class="bg-blue-600 text-white px-2 py-1 rounded-xl">
                                        Revisi
                                    </span>
                                @break

                                @case('Rejected')
                                    <span class="bg-red-600 text-white px-2 py-1 rounded-xl">
                                        Rejected
                                    </span>
                                @break

                                @default
                                    {{ $value ?? '-' }}
                            @endswitch
                        @else
                            {{ $value ?? '-' }}
                        @endif
                    </td>
                @endforeach

                {{-- Aksi btn  --}}
                @if ($showActionColumn)
                    <td class="px-2 py-2 w-[72px] sm:w-auto">
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-3">
                            {{-- Edit: Draft / Revisi --}}
                            @if (data_get($row, 'status') === 'Draft' || data_get($row, 'status') === 'Revisi')
                                <button type="button"
                                    class="
                                        flex items-center justify-center
                                        p-2 sm:px-3 sm:py-0.5
                                        bg-[#2179ca] hover:bg-[#1c6bb4]
                                        text-white rounded
                                        gap-0 sm:gap-2
                                    "
                                    @click="$dispatch('{{ $editEvent }}', {{ json_encode($row) }})">
                                    <img src="/icon/edit.svg" class="w-[15px] h-[15px]">
                                    <span class="hidden sm:inline">
                                        Edit
                                    </span>
                                </button>
                            @endif

                            {{-- Delete: HANYA Draft --}}
                            @if (data_get($row, 'status') === 'Draft' && $deleteRoute)
                                <button type="button"
                                    class=" flex items-center justify-center
                                        p-2 sm:px-3 sm:py-0.5
                                        bg-red-500 hover:bg-red-600 text-white rounded-sm gap-0 sm:gap-2"
                                    @click="$dispatch('delete-row', {
                                        id: '{{ data_get($row, $idKey) }}',
                                        route: '{{ route($deleteRoute, data_get($row, $idKey)) }}'
                                    })">
                                    <img src="/icon/delete.svg" class="w-[15px] h-[15px]">
                                    <span class="hidden sm:inline">
                                        Hapus
                                    </span>
                                </button>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + ($showActionColumn ? 1 : 0) }}"
                        class="px-4 py-4 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
