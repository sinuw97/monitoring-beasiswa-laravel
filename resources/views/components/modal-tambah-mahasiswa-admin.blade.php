<div id="modalTambah" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-scroll pt-16 pb-1">
    <div class="bg-white rounded-xl shadow-xl w-[90%] sm:w-[500px] p-6 relative">

        <button type="button" onclick="openModal(false)"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

        <h2 class="text-lg font-semibold text-[#09697E] mb-4 text-center">Tambah Mahasiswa</h2>
        
        {{-- Import Section --}}
        <div class="mb-6 p-4 bg-gray-50 border border-gray-100 rounded-lg">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Import Data (Excel)</h3>
            <form action="{{ route('admin.data-mahasiswa.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
                @csrf
                <input type="file" name="file" required class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-cyan-50 file:text-[#09697E]
                    hover:file:bg-cyan-100 transition
                "/>
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm whitespace-nowrap">
                    Import
                </button>
            </form>
            <div class="flex flex-col mt-2 gap-1">
                <p class="text-xs text-gray-500">Password default adalah NIM. Kolom: NIM, Nama, Email, Prodi, Kelas, No HP, Jenis Beasiswa, Jenis Kelamin, Angkatan, Status, Alamat.</p>
                <a href="{{ route('admin.data-mahasiswa.template') }}" class="text-xs text-[#09697E] hover:underline font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Template Excel
                </a>
            </div>
        </div>

        <div class="relative flex py-2 items-center mb-4">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-gray-400 text-xs uppercase">Atau tambah manual</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form method="POST" action="{{ url('/admin/data-mahasiswa') }}" class="w-full">
            @csrf
            <div class="flex w-full flex-row gap-2">
            <div class="flex w-full flex-col gap-2">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" name="nim" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Nomor Induk Mahasiswa">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Nama Lengkap Mahasiswa">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Email Mahasiswa">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select name="prodi" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Program Studi</option>
                    @php
                        $prodiList = ['S1 Informatika', 'S1 Sistem Informasi', 'D3 Teknik Komputer', 'D3 Manajemen Akuntansi'];
                    @endphp
                    @foreach($prodiList as $prodi)
                        <option value="{{ $prodi }}">{{ $prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="kelas" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Kelas</option>
                    @php
                        $classList = ['Pagi', 'Malam', 'Karyawan'];
                    @endphp
                    @foreach($classList as $class)
                        <option value="{{$class}}">{{ $class }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                <input type="text" name="angkatan" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Tahun masuk">
            </div>
            </div>
            <div class="flex w-full flex-col gap-2">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Beasiswa</label>
                <select name="jenis_beasiswa" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Jenis Beasiswa</option>
                    @php
                        $beasiswaList = ['Tidak Ada', 'Bidikmisi', 'PPA', 'Lainnya'];
                    @endphp
                    @foreach($beasiswaList as $beasiswa)
                        <option value="{{ strtolower(str_replace(' ', '_', $beasiswa)) }}">{{ $beasiswa }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                <input type="tel" name="no_hp" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Nomor Handphone">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" required rows="2"
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm" placeholder="Alamat Lengkap Mahasiswa"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Status</option>
                    @php
                        $statusList = ['Aktif', 'Cuti', 'Lulus', 'Keluar'];
                    @endphp
                    @foreach($statusList as $status)
                        <option value="{{ strtolower($status) }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            </div>


            <div class="pt-3 flex justify-end gap-3">
                <button type="button" onclick="openModal(false)"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="bg-[#09697E] hover:bg-[#075263] text-white px-4 py-2 rounded-lg text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(show) {
        const modal = document.getElementById('modalTambah');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
