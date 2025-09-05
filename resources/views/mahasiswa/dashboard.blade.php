<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Dashboard Mahasiswa</title>
</head>
<body>
  <h1 class="bold">
    Hallo, {{ $dataMahasiswa->name }}
  </h1>
  <h2> Selamat Datang Di Dashboard Mahasiswa</h2><br>

  {{-- <p>Data:</p>
  <p>{{ $dataMahasiswa }}</p> --}}

  <p>Nama: {{ $dataMahasiswa->name }}</p>
  <p>NIM: {{ $dataMahasiswa->nim }}</p>
  <p>Angkatan: {{ $dataMahasiswa->detailMahasiswa->angkatan }}</p>
  <p>Prodi: {{ $dataMahasiswa->detailMahasiswa->prodi }}</p>
  <p>Status: {{ $dataMahasiswa->detailMahasiswa->status }}</p>
  <p>Jenis Beasiswa: {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}</p>

  <form method="POST" action="{{ url('mahasiswa/logout') }}">
    @csrf
    <button class="bg-amber-600 px-2 py-1 cursor-pointer" type="submit">
      Logout
    </button>
  </form>
</body>
</html>