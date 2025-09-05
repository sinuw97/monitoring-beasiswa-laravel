<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login Mahasiswa</title>
</head>

<body>
    <h2 class="text-lg text-blue-800">Login Mahasiswa</h2>

    @if ($errors->any())
        <div class="text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('mahasiswa/login') }}">
        @csrf
        <div>
            <label for="">NIM</label>
            <input type="text" name="nim" placeholder="Masukan NIM" class="border border-gray-500">
        </div>
        <div>
            <label for="">Password</label>
            <input type="password" name="password" placeholder="Masukan Password" class="border border-gray-500">
        </div>
        <button type="submit" class="bg-green-300 px-2 py-1 cursor-pointer">Login</button>
    </form>

    <a href="{{ url('admin/login') }}">
        Login Sebagai Admin
    </a>
</body>

</html>
