<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
        {{-- Navbar --}}
        <x-navbar-mhs mhsName='{{ $dataMahasiswa->name }}' mhsAvatar='{{ $dataMahasiswa->avatar }}' />

        {{-- Main Content --}}
        <main class="flex flex-1 px-10 py-6 gap-6">
            {{-- Sidebar --}}
            <aside class="w-1/4 bg-white shadow rounded-md p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div
                        class="flex items-center justify-center w-20 h-20 bg-gray-300 rounded-full text-xl font-bold text-white">
                        {{ strtoupper(substr($dataMahasiswa->name,0,2)) }}
                    </div>
                    <h2 class="mt-3 font-semibold">{{ $dataMahasiswa->name }}</h2>
                </div>
                <div class="text-sm text-gray-700">
                    <p class="font-bold">{{ $dataMahasiswa->nim }}</p>
                    <p>{{ $dataMahasiswa->detailMahasiswa->prodi }}</p>
                    <p>Angkatan {{ $dataMahasiswa->detailMahasiswa->angkatan }}</p>
                    <p>Beasiswa : {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}</p>
                    <p>Kelas : {{ $dataMahasiswa->detailMahasiswa->kelas }}</p>
                    <p>Jenis Kelamin : {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin }}</p>
                </div>

                <div class="mt-6">
                    <p class="text-sm font-semibold mb-2">Laporan terajukan</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-500 h-2.5 rounded-full" style="width: 12.5%"></div>
                    </div>
                    <p class="text-xs mt-1">1/8</p>
                </div>
            </aside>

            {{-- Form Edit Data Mahasiswa --}}
            <section class="flex-1 bg-white shadow rounded-md p-6">
                <h2 class="font-bold text-lg mb-4">Edit Data Mahasiswa</h2>

                {{-- Tampilkan pesan sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="grid grid-cols-2 gap-4 text-sm">
                    @csrf

                    <div>
                        <label class="block text-gray-600">Nama</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->name }}" disabled>
                    </div>

                    <div>
                        <label class="block text-gray-600">Email</label>
                        <input type="email" name="email" class="w-full border rounded-md px-3 py-2"
                            value="{{ old('email', $dataMahasiswa->email) }}">
                        @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-600">NIM</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->nim }}" disabled>
                    </div>

                    <div>
                        <label class="block text-gray-600">Program Studi</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->prodi }}" disabled>
                    </div>

                    <div>
                        <label class="block text-gray-600">Jenis Beasiswa</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}" disabled>
                    </div>

                    <div>
                        <label class="block text-gray-600">Angkatan</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->angkatan }}" disabled>
                    </div>

                    <div>
                        <label class="block text-gray-600">Kelas</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->kelas }}" disabled>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-600">Jenis Kelamin</label>
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center gap-2">
                                <input type="radio" disabled
                                    {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                Laki-laki
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" disabled
                                    {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                Perempuan
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

                    <div class="col-span-2 mt-4 flex justify-between">
                        <a href="{{ route('mahasiswa.profile') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Batal</a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>
