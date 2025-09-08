<table class="min-w-full rounded-xl text-sm">
    <thead>
        <tr class="bg-[#E8BE00]">
            @foreach ($headers as $header)
                <th class="px-4 py-2 text-center">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $row)
            <tr class="bg-[#E7E6E6]">
                @foreach ($row as $cell)
                    <td class="px-4 py-2 text-center">{{ $cell }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) }}" class="px-4 py-4 text-center ">
                    Tidak ada data
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
