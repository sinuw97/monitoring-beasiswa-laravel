<table class="min-w-full">
        <thead class="bg-white border-b">
        <tr>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                NO
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                ID LAPORAN
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                SEMESTER
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                NAMA MAHASISWA
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                STATUS
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                AKSI
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($dataLaporan as $laporan)
            <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{$loop->iteration + $dataLaporan->firstItem() - 1 }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{$laporan->laporan_id}}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{$laporan->semester_id}}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    {{$laporan->name}}
                </td>
                <td class="text-sm  font-light px-6 py-4 whitespace-nowrap {{$laporan->status == 'Draft' ? 'text-grey-500' : ($laporan->status == 'Ditolak' || $laporan->status == 'Ditolak SP-1' || $laporan->status == 'Ditolak SP-2' || $laporan->status == 'Ditolak SP-3' ? 'text-red-500' : ($laporan->status == 'Lolos' ? 'text-green-500' : 'text-yellow-500'))}}">
                    <span class="py-1 px-2 rounded-full {{$laporan->status == 'Draft' ? 'bg-grey-100 border border-gray-500' : ($laporan->status == 'Ditolak' || $laporan->status == 'Ditolak SP-1' || $laporan->status == 'Ditolak SP-2' || $laporan->status == 'Ditolak SP-3' ? 'bg-red-100 border border-red-500' : ($laporan->status == 'Lolos' ? 'bg-green-100 border border-green-500' : 'bg-yellow-100 border border-yellow-500'))}}">{{$laporan->status}}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <a href="/admin/laporan/{{ $laporan->laporan_id }}" class="text-indigo-600 hover:text-indigo-900">Lihat Laporan</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $dataLaporan->links() }}
