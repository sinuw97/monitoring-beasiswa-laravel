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
    $showActionColumn = in_array($status, ['Draft', 'Dikembalikan', 'Revisi']);
    // Draft BISA edit dan hapus, Dikembalikan dan datanya Revisi HANYA BOLEH edit
    $canEdit = $status === 'Draft' || $status === 'Dikembalikan';
    $canDelete = $status === 'Draft' && $deleteRoute;
@endphp

<div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm bg-white">
    <table class="min-w-full text-sm text-left">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                @foreach ($headers as $header)
                    <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wider text-xs">
                        {{ $header }}
                    </th>
                @endforeach

                @if ($showActionColumn)
                    <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wider text-xs text-center">Aksi</th>
                @endif
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @forelse($rows as $row)
                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                    {{-- no --}}
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $loop->iteration }}
                    </td>

                    {{-- Data kegiatan --}}
                    @foreach ($columns as $col)
                        @php
                            $value = data_get($row, $col);
                        @endphp

                        <td class="px-6 py-4 text-gray-600">
                            {{-- Lihat bukti --}}
                            @if ($col === 'bukti' && $value && $value !== 'Tidak Ada')
                                <a href="{{ $value }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>

                                {{-- Status kegiatan --}}
                            @elseif ($col === 'status')
                                @switch($value)
                                    @case('Draft')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
                                    @break

                                    @case('Pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @break

                                    @case('Valid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Valid
                                        </span>
                                    @break

                                    @case('Revisi')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Revisi
                                        </span>
                                    @break

                                    @case('Rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @break

                                    @default
                                        <span class="text-gray-500">-</span>
                                @endswitch
                            @else
                                {{ $value ?? '-' }}
                            @endif
                        </td>
                    @endforeach

                    {{-- Aksi btn  --}}
                    @if ($showActionColumn)
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit: Draft / Revisi / Pending --}}
                                @if (in_array(data_get($row, 'status'), ['Draft', 'Revisi', 'Pending']))
                                    <button type="button"
                                        class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit"
                                        @click="$dispatch('{{ $editEvent }}', {{ json_encode($row) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Delete: HANYA Draft / Pending / Revisi --}}
                                @if (in_array(data_get($row, 'status'), ['Draft', 'Pending', 'Revisi']) && $deleteRoute)
                                    <button type="button"
                                        class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus"
                                        @click="$dispatch('delete-row', {
                                            id: '{{ data_get($row, $idKey) }}',
                                            route: '{{ route($deleteRoute, data_get($row, $idKey)) }}'
                                        })">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + ($showActionColumn ? 1 : 0) }}"
                        class="px-6 py-8 text-center text-gray-400 italic">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
