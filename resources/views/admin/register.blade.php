<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login Admin</title>
</head>
<body class="min-h-screen flex flex-col lg:flex-row">
    <!-- Bagian kiri (gradient background) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-t from-[#09697E] to-white"></div>

    <!-- Bagian kanan (form login) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white p-6 sm:p-8 ">
            <!-- Logo -->
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('icon/logo.svg') }}" alt="Logo TSU" class="h-30 mb-2">
            </div>

            <!-- Error -->
            @if ($errors->any())
                <div class="text-red-500 mb-4 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ url('admin/register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700">User_Id</label>
                    <input type="text" name="user_id" placeholder="Masukan user_id anda"
                        class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" name="name" placeholder="Masukan nama anda"
                        class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="text" name="email" placeholder="Masukan email anda"
                        class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password anda"
                        class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Avatar</label>
                    <input type="password" name="avatar" placeholder="Masukkan avatar anda"
                        class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <!-- Tombol Login Admin -->
                <div class="flex justify-between items-center text-sm">
                    <a href="{{ url('mahasiswa/login') }}" class="text-gray-500 hover:text-[#176578]">Login Sebagai Mahasiswa</a>
                </div>

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full bg-[#1D7D94] text-white py-2 rounded-md hover:bg-[#176578] transition">Register</button>
            </form>
        </div>
    </div>
</body>

</html>
