{{-- Parameter yang diharapkan: $report (data baris), $modalId (ID unik modal) --}}

{{-- Overlay Modal: Menggunakan ID unik yang akan dipanggil oleh Anchor Tag --}}
<div id="{{ $modalId }}" class="modal-target fixed inset-0 z-50 bg-gray-500 bg-opacity-50 flex items-center justify-center p-4">

    {{-- Container Modal --}}
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-auto">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-xl font-semibold text-gray-900">
                Edit Laporan {{ $type }}
            </h3>
            {{-- Tombol Tutup: Kembali ke URL tanpa fragment (#) --}}
            <a href="#" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>

        {{-- Body Modal (Form Edit) --}}
        <div class="p-6 space-y-4">
            {{-- Form, sesuaikan action dan method dengan route Laravel Anda --}}
            <form action="/admin/laporan/{{$report['laporan_id']}}/{{ $type }}/{{$report['id']}}" method="POST">
                @csrf
                @method('PUT') {{-- Atau PATCH --}}

                {{-- Input Status --}}
                <div>
                    <label for="status-{{ $report['id'] }}" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <select id="status-{{ $report['id'] }}" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="Draft" @if ($report['status'] == 'Draft') selected @endif>Draft</option>
                        <option value="Pending" @if ($report['status'] == 'Pending') selected @endif>Pending</option>
                        <option value="Valid" @if ($report['status'] == 'Valid') selected @endif>Valid</option>
                        <option value="Rejected" @if ($report['status'] == 'Rejected') selected @endif>Rejected</option>
                    </select>
                </div>

                {{-- Input Komentar --}}
                <div class="{{$type == 'target-independent' || $type == 'target-achievements' || $type == 'target-activities' || $type == 'target-reports' || $type == 'evaluations' ? 'hidden invisible' : ''}}">
                    <label for="komentar-{{ $report['id'] }}" class="block mb-2 text-sm font-medium text-gray-900">Komentar/Catatan</label>
                    <textarea id="komentar-{{ $report['id'] }}" name="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan komentar atau catatan...">{{ $report['comment'] ?? '' }}</textarea>
                </div>

                {{-- Footer Modal (Tombol Simpan) --}}
                <div class="flex justify-end pt-4 border-t mt-6">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Simpan Perubahan
                    </button>
                    {{-- Tombol Batal --}}
                    <a href="#" class="ml-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
