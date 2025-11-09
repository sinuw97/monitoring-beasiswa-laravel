<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login Admin - Monitoring Beasiswa</title>
</head>

<body class="min-h-screen flex antialiased bg-gray-100 font-sans">

    <div class="w-full flex flex-col lg:flex-row shadow-2xl overflow-hidden bg-white">

        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center bg-cyan-700 p-12">
            <div class="absolute inset-0 bg-cover bg-center opacity-40"
                 style="background-image: url('{{ asset('img/bckg1.png') }}');">
            </div>

            <div class="relative text-white text-center z-10">
                <h1 class="text-5xl font-extrabold mb-4 tracking-wider">TSU Beasiswa</h1>
                <p class="text-xl font-light">
                    Portal Administrasi Sistem Monitoring
                </p>
                <div class="mt-8 border-t border-white/50 pt-4">
                     <p class="text-sm">Hanya untuk Pengelola Sistem Tiga Serangkai University.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-16 my-auto">
            <div class="w-full max-w-sm md:max-w-md bg-white rounded-xl">

                <div class="flex flex-col items-center text-center mb-8">
                    <img src="{{ asset('icon/logo.svg') }}" alt="Logo TSU" class="h-12 w-auto mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Masuk Admin / Dosen</h2>
                    <p class="text-sm text-gray-500 mt-1">Gunakan Email dan Password akun Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                        <strong class="font-bold">Gagal Login!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('admin/login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            placeholder="Masukan email admin/dosen"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 transition duration-150 ease-in-out">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan kata sandi Anda"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 transition duration-150 ease-in-out">
                    </div>

                    <div class="text-left pt-2">
                        <a href="{{ url('mahasiswa/login') }}" class="text-sm text-gray-600 hover:text-cyan-800 hover:underline transition">
                            <span class="mr-1">&larr;</span> Login Sebagai Mahasiswa
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full bg-cyan-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-cyan-700 transition duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-cyan-500/50">
                        Masuk ke Dashboard Admin
                    </button>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
