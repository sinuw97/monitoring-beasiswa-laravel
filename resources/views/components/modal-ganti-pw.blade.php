<div x-data="{ show: {{ session()->has('ganti_pw_error') || session()->has('ganti_pw_success') ? 'true' : 'false' }} }" x-cloak @open-ganti-password.window="show = true" @close-ganti-password.window="show = false">
    <div x-show="show" x-transition @click.away="show = false"
        class="fixed inset-0 bg-[#2525252d] backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-[400px] p-6 rounded-xl shadow-lg" @click.stop>

            <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">
                Ganti Password
            </h2>

            <div class="text-sm text-gray-500">
                @if ($errors->any())
                    <div class="mb-3 text-xs text-red-600 bg-red-50 p-2 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3 text-xs text-red-600 bg-red-50 p-2 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-3 text-xs text-green-600 bg-green-50 p-2 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.ganti-pw') }}">
                    @csrf
                    <!-- Password Saat Ini -->
                    <div class="mb-3" x-data="{ show: false }">
                        <label class="block text-xs sm:text-sm text-gray-600 mb-1">Password Saat Ini</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="current_password" required
                                placeholder="Masukan password lama Anda..."
                                class="w-full text-sm border rounded-md px-2.5 py-2 pr-9 focus:ring focus:ring-blue-300 outline-none">

                            <!-- Eye Button -->
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-800">
                                <span x-show="!show">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="eye"
                                        class="w-[20px] h-[20px]">
                                        <path fill="#4F4F4F"
                                            d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z">
                                        </path>
                                    </svg>
                                </span>
                                <span x-show="show">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="eye-slash"
                                        class="w-[20px] h-[20px]">
                                        <path fill="#4F4F4F"
                                            d="M10.94,6.08A6.93,6.93,0,0,1,12,6c3.18,0,6.17,2.29,7.91,6a15.23,15.23,0,0,1-.9,1.64,1,1,0,0,0-.16.55,1,1,0,0,0,1.86.5,15.77,15.77,0,0,0,1.21-2.3,1,1,0,0,0,0-.79C19.9,6.91,16.1,4,12,4a7.77,7.77,0,0,0-1.4.12,1,1,0,1,0,.34,2ZM3.71,2.29A1,1,0,0,0,2.29,3.71L5.39,6.8a14.62,14.62,0,0,0-3.31,4.8,1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20a9.26,9.26,0,0,0,5.05-1.54l3.24,3.25a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Zm6.36,9.19,2.45,2.45A1.81,1.81,0,0,1,12,14a2,2,0,0,1-2-2A1.81,1.81,0,0,1,10.07,11.48ZM12,18c-3.18,0-6.17-2.29-7.9-6A12.09,12.09,0,0,1,6.8,8.21L8.57,10A4,4,0,0,0,14,15.43L15.59,17A7.24,7.24,0,0,1,12,18Z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4" x-data="{ show: false }">
                        <label class="block text-xs sm:text-sm text-gray-600">Password Baru</label>
                        <span class="italic text-sm mb-1 text-red-500">Minimal 8 karakter dengan 1 angka dan 1 simbol</span>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="new_password" required
                                placeholder="Masukan password baru Anda..."
                                class="w-full text-sm border rounded-md px-2.5 py-2 pr-9 focus:ring focus:ring-blue-300 outline-none">

                            <!-- Eye Button -->
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                <span x-show="!show">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="eye"
                                        class="w-[20px] h-[20px]">
                                        <path fill="#4F4F4F"
                                            d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z">
                                        </path>
                                    </svg>
                                </span>
                                <span x-show="show">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="eye-slash"
                                        class="w-[20px] h-[20px]">
                                        <path fill="#4F4F4F"
                                            d="M10.94,6.08A6.93,6.93,0,0,1,12,6c3.18,0,6.17,2.29,7.91,6a15.23,15.23,0,0,1-.9,1.64,1,1,0,0,0-.16.55,1,1,0,0,0,1.86.5,15.77,15.77,0,0,0,1.21-2.3,1,1,0,0,0,0-.79C19.9,6.91,16.1,4,12,4a7.77,7.77,0,0,0-1.4.12,1,1,0,1,0,.34,2ZM3.71,2.29A1,1,0,0,0,2.29,3.71L5.39,6.8a14.62,14.62,0,0,0-3.31,4.8,1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20a9.26,9.26,0,0,0,5.05-1.54l3.24,3.25a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Zm6.36,9.19,2.45,2.45A1.81,1.81,0,0,1,12,14a2,2,0,0,1-2-2A1.81,1.81,0,0,1,10.07,11.48ZM12,18c-3.18,0-6.17-2.29-7.9-6A12.09,12.09,0,0,1,6.8,8.21L8.57,10A4,4,0,0,0,14,15.43L15.59,17A7.24,7.24,0,0,1,12,18Z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="flex justify-end gap-2">
                        <button @click="show = false"
                            class="px-3 py-1.5 text-xs sm:text-sm bg-[#09697E] hover:bg-[#167b92] text-[#fefefe] rounded-md">
                            Tutup
                        </button>
                        <button type="submit"
                            class="px-3 py-1.5 text-xs sm:text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($errors->any() || session('error'))
    <script>
        document.addEventListener('alpine:init', () => {
            window.dispatchEvent(new CustomEvent('open-ganti-password'))
        })
    </script>
@endif
