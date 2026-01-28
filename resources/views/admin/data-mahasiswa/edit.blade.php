@extends('admin.layout')

@section('title', 'Edit Data Mahasiswa')

@section('content')
    <main class="block bg-white max-w-5xl mx-auto shadow-lg rounded-xl p-6 border-l-4 border-[#09697E] my-2 sm:my-8">
        {{-- Form Edit Data Mahasiswa --}}
            <h2 class="font-bold text-lg mb-4">Edit Data Mahasiswa</h2>

            {{-- Tampilkan pesan sukses --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ url('/admin/data-mahasiswa/edit/'.$dataMahasiswa->nim) }}" method="POST" class="flex flex-col sm:grid sm:grid-cols-2 gap-2 sm:gap-4 text-sm">
                @csrf
                @method('put')
                <div>
                    <label class="block text-gray-600">Nama</label>
                    <input type="text" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->name }}" name="name">
                </div>

                <div>
                    <label class="block text-gray-600">Email</label>
                    <input type="email" name="email" class="w-full border rounded-md px-3 py-2"
                        value="{{ old('email', $dataMahasiswa->email) }}">
                    @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block text-gray-600">NIM</label>
                    <input type="text" name="nim" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->nim }}">
                </div>

                <div>
                    <label class="block text-gray-600">Program Studi</label>
                    <input type="text" name="prodi" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->detailMahasiswa->prodi ?? '' }}">
                </div>

                <div>
                    <label class="block text-gray-600">Jenis Beasiswa</label>
                    <input type="text" name="jenis_beasiswa" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa ?? '' }}">
                </div>

                <div>
                    <label class="block text-gray-600">Angkatan</label>
                    <input type="text" name="angkatan" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->detailMahasiswa->angkatan ?? '' }}">
                </div>

                <div>
                    <label class="block text-gray-600">Kelas</label>
                    <input type="text" name="kelas" class="w-full border rounded-md px-3 py-2"
                        value="{{ $dataMahasiswa->detailMahasiswa->kelas ?? ''}}">
                </div>

                <div>
                    <label class="block text-gray-600">Status</label>
                    <select name="status" class="w-full border rounded-md px-3 py-2">
                        @if ($dataMahasiswa?->detailMahasiswa->status)
                            <option value="" {{ $dataMahasiswa->detailMahasiswa->status != 'Aktif' && $dataMahasiswa->detailMahasiswa->status != 'Non-Aktif' ? 'selected' : ''}}>
                            Pilih Keaktifan
                        </option>
                        <option value="Aktif" {{ $dataMahasiswa->detailMahasiswa->status == 'Aktif' ? 'selected' : ''}}>
                            Aktif
                        </option>
                        <option value="Non-Aktif" {{ $dataMahasiswa->detailMahasiswa->status == 'Non-Aktif' ? 'selected' : ''}}>
                            Non-Aktif
                        </option>
                        @endif
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-600">Jenis Kelamin</label>
                    <div class="flex gap-4 mt-1">
                        <label class="flex items-center gap-2">
                            @if ($dataMahasiswa->detailMahasiswa->jenis_kelamin)
                                <input type="radio" name="jenis_kelamin"
                                {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Laki-Laki' ? 'checked' : '' }} value="Laki-Laki">
                            Laki-laki
                            @endif
                        </label>
                        <label class="flex items-center gap-2">
                            @if ($dataMahasiswa->detailMahasiswa->jenis_kelamin)
                            <input type="radio" name="jenis_kelamin"
                                {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }} value="Perempuan">
                            Perempuan
                            @endif
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-600">No HP</label>
                    <input type="text" name="no_hp" class="w-full border rounded-md px-3 py-2"
                        value="{{ old('no_hp', $dataMahasiswa->detailMahasiswa->no_hp ?? '') }}">
                    @error('no_hp') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block text-gray-600">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded-md px-3 py-2">{{ old('alamat', $dataMahasiswa->detailMahasiswa->alamat ?? '') }}</textarea>
                    @error('alamat') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div class="relative">
                    <label class="block text-gray-600">Password</label>
                    <input type="password" id="password" name="password" placeholder="Kosongi jika tidak ingin mengubah password" class="w-full border rounded-md px-3 py-2">
                    <span id="togglePassword" class="absolute right-3 top-2/3 transform -translate-y-1/2 cursor-pointer">
                        👁️
                    </span>
                    @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div class="col-span-2 mt-4 flex justify-between">
                    <a href="{{ url('/admin/data-mahasiswa') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Kembali</a>
                    <button type="submit"
                        class="bg-blue-600 cursor-pointer hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                        Simpan
                    </button>
                </div>
            </form>

    </main>
@endsection

<script>
    window.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");

        togglePassword.addEventListener("click", function (e) {
            // toggle the type attribute
            togglePassword.innerHTML = passwordInput.getAttribute("type") === "password" ? "❌" : "👁️";
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            // Optional: toggle the eye icon (if using an icon library)
            this.classList.toggle("bi-eye"); 
        });
    });
</script>