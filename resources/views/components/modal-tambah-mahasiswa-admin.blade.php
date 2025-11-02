<div id="modalTambah" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-scroll">
    <div class="bg-white rounded-xl shadow-xl w-[90%] sm:w-[500px] p-6 relative">

        <button type="button" onclick="openModal(false)"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

        <h2 class="text-lg font-semibold text-[#09697E] mb-4 text-center">Tambah Mahasiswa</h2>

        <form method="POST" action="{{ url('/admin/data-mahasiswa') }}" class="w-full">
            @csrf
            <div class="flex w-full flex-row gap-2">
            <div class="w-full">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" name="nim" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select name="prodi" required
                        class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Program Studi</option>
                    @php
                        $prodiList = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi'];
                    @endphp
                    @foreach($prodiList as $prodi)
                        <option value="{{ strtolower(str_replace(' ', '_', $prodi)) }}">{{ $prodi }}</option>
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
                        <option value="{{ strtolower($class) }}">{{ $class }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                <select name="angkatan" required
                         class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
                    <option value="">Pilih Angkatan</option>
                    @foreach($angkatanList as $angkatan)
                        <option value="{{ $angkatan }}">20{{ $angkatan }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="w-full">
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
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" required rows="2"
                       class="w-full border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:border-[#09697E] focus:ring-[#09697E] text-sm"></textarea>
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
