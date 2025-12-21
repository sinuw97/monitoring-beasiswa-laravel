<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #nprogress .bar {
            background: #09697E;
            height: 5px;
        }

        #nprogress .peg {
            box-shadow: 0 0 15px #09697E, 0 0 9px #09697E;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/nprogress/nprogress.css">
    <title>Login Mahasiswa - Monitoring Beasiswa</title>
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
                    Sistem Monitoring & Evaluasi
                </p>
                <div class="mt-8 border-t border-white/50 pt-4">
                     <p class="text-sm">Selamat datang, Mahasiswa Tiga Serangkai University.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center my-auto p-6 sm:p-12 lg:p-16">
            <div class="w-full max-w-sm md:max-w-md bg-white rounded-xl">

                <div class="flex flex-col items-center text-center mb-8">
                    <img src="{{ asset('icon/logo.svg') }}" alt="Logo TSU" class="h-12 w-auto mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Masuk Mahasiswa</h2>
                    <p class="text-sm text-gray-500 mt-1">Gunakan akun NIM dan Password Anda.</p>
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

                <form method="POST" action="{{ url('mahasiswa/login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required autofocus
                            placeholder="Contoh: 2021001"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 transition duration-150 ease-in-out">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan kata sandi Anda"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 transition duration-150 ease-in-out">
                    </div>

                    <button type="submit"
                        class="w-full bg-cyan-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-cyan-700 transition duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-cyan-500/50">
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/nprogress/nprogress.js"></script>

    <script>
        // load / submit form
        document.addEventListener('DOMContentLoaded', () => {
            NProgress.start()
        });

        // selesai load
        window.addEventListener('load', () => {
            NProgress.done()
        });

        // submit form
        document.addEventListener('submit', function() {
            NProgress.start()
        });
    </script>
</body>

</html>
