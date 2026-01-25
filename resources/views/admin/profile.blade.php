@extends('admin.layout')

@section('title', 'Profil Admin')

@section('content')
    <main class="min-h-screen flex-1 p-2 sm:p-6 bg-gray-50">
        <div class="max-w-4xl mx-auto">
             @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 1 1 1.697 1.697l-2.651 2.995 2.651 2.995a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if (session('ganti_pw_success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('ganti_pw_success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

             @if (session('ganti_pw_error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4"
                    role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('ganti_pw_error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-[#09697E] mb-6">Profil Admin</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ubah Profil -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-[#09697E]">
                    <h2 class="text-xl font-semibold text-[#09697E] mb-4">Ubah Profil</h2>
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $dataAdmin->name) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $dataAdmin->email) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                             @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="bg-[#09697E] hover:bg-[#075263] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Ganti Password -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-[#E8BE00]">
                    <h2 class="text-xl font-semibold text-[#E8BE00] mb-4">Ganti Password</h2>
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Password Saat Ini:</label>
                            <input type="password" name="current_password" id="current_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror">
                             @if(session('error'))
                                <p class="text-red-500 text-xs italic mt-1">{{ session('error') }}</p>
                             @endif
                            @error('current_password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Password Baru:</label>
                            <input type="password" name="new_password" id="new_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('new_password') border-red-500 @enderror">
                             @error('new_password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru:</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('confirm_password') border-red-500 @enderror">
                             @error('confirm_password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="bg-[#E8BE00] hover:bg-[#cfaa00] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
