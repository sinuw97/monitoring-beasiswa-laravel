<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        #nprogress .bar {
            background: #09697E;
            height: 5px;
        }

        #nprogress .peg {
            box-shadow: 0 0 15px #09697E, 0 0 9px #09697E;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/nprogress/nprogress.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
        {{-- Navbar --}}
        <x-navbar-mhs mhsName='{{ $dataMahasiswa->name }}' mhsAvatar='{{ $dataMahasiswa->avatar }}' />

        {{-- Main Content --}}
        <main class="flex flex-col lg:flex-row flex-1 px-4 sm:px-6 lg:px-10 py-6 gap-6">
            {{-- Sidebar --}}
            <aside class="w-full lg:w-[20%] bg-[#FEFEFE] flex-shrink-0 flex flex-col lg:sticky lg:top-0 lg:h-screen">
                <div class="mx-6 my-6 lg:my-10">
                    <div
                        class="flex flex-col justify-center gap-3 items-center pb-6 lg:pb-10 border-b border-[#909090]">
                        <img src="{{ $dataMahasiswa->avatar }}" alt="avatar-mhs"
                            class="w-12 h-12 lg:w-[50px] lg:h-[50px] rounded-full object-cover">
                        <h1 class="text-sm lg:text-base text-center">{{ $dataMahasiswa->name }}</h1>
                    </div>

                    <div class="mt-4 space-y-3 text-sm lg:text-base">
                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" class="w-[20px] h-[20px]"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 5C2.44772 5 2 5.44771 2 6V18C2 18.5523 2.44772 19 3 19H21C21.5523 19 22 18.5523 22 18V6C22 5.44772 21.5523 5 21 5H3ZM0 6C0 4.34315 1.34314 3 3 3H21C22.6569 3 24 4.34315 24 6V18C24 19.6569 22.6569 21 21 21H3C1.34315 21 0 19.6569 0 18V6ZM6 10.5C6 9.67157 6.67157 9 7.5 9C8.32843 9 9 9.67157 9 10.5C9 11.3284 8.32843 12 7.5 12C6.67157 12 6 11.3284 6 10.5ZM10.1756 12.7565C10.69 12.1472 11 11.3598 11 10.5C11 8.567 9.433 7 7.5 7C5.567 7 4 8.567 4 10.5C4 11.3598 4.31002 12.1472 4.82438 12.7565C3.68235 13.4994 3 14.7069 3 16C3 16.5523 3.44772 17 4 17C4.55228 17 5 16.5523 5 16C5 15.1145 5.80048 14 7.5 14C9.19952 14 10 15.1145 10 16C10 16.5523 10.4477 17 11 17C11.5523 17 12 16.5523 12 16C12 14.7069 11.3177 13.4994 10.1756 12.7565ZM13 8C12.4477 8 12 8.44772 12 9C12 9.55228 12.4477 10 13 10H19C19.5523 10 20 9.55228 20 9C20 8.44772 19.5523 8 19 8H13ZM14 12C13.4477 12 13 12.4477 13 13C13 13.5523 13.4477 14 14 14H18C18.5523 14 19 13.5523 19 13C19 12.4477 18.5523 12 18 12H14Z"
                                        fill="#09697E"></path>
                                </g>
                            </svg>
                            <p class="mr-2">NIM</p>
                            <span class="truncate">: {{ $dataMahasiswa->nim }}</span>
                        </div>

                        <div class="flex items-center gap-2 border-b border-[#909090] pb-2">
                            <svg viewBox="0 0 24 24" version="1.1" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title></title>
                                    <g fill="none" fill-rule="evenodd" id="页面-1" stroke="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                                        <g id="导航图标" stroke="#09697E" stroke-width="1.5"
                                            transform="translate(-28.000000, -272.000000)">
                                            <g id="学术" transform="translate(28.000000, 272.000000)">
                                                <g id="编组" transform="translate(1.000000, 4.000000)">
                                                    <polygon id="路径" points="0 2.75 11 0 22 2.75 11 5.5">
                                                    </polygon>
                                                    <path
                                                        d="M4.95,4.4 L4.95,9.88383 C4.95,9.88383 7.7,11.55 11,11.55 C14.3,11.55 17.05,9.88383 17.05,9.88383 L17.05,4.4"
                                                        id="路径"></path>
                                                    <line id="路径" x1="1.65" x2="1.65" y1="3.3"
                                                        y2="15.4"></line>
                                                    <rect height="3.3" id="矩形" width="3.3" x="0" y="14.3">
                                                    </rect>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <p class="mr-2">Angkatan</p>
                            <span class="truncate">: {{ $dataMahasiswa->detailMahasiswa->angkatan }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="w-[20px] h-[20px]">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M4 8C4 5.17157 4 3.75736 4.87868 2.87868C5.75736 2 7.17157 2 10 2H14C16.8284 2 18.2426 2 19.1213 2.87868C20 3.75736 20 5.17157 20 8V16C20 18.8284 20 20.2426 19.1213 21.1213C18.2426 22 16.8284 22 14 22H10C7.17157 22 5.75736 22 4.87868 21.1213C4 20.2426 4 18.8284 4 16V8Z"
                                        stroke="#09697E" stroke-width="1.5"></path>
                                    <path
                                        d="M19.8978 16H7.89778C6.96781 16 6.50282 16 6.12132 16.1022C5.08604 16.3796 4.2774 17.1883 4 18.2235"
                                        stroke="#09697E" stroke-width="1.5"></path>
                                    <path d="M8 7H16" stroke="#09697E" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M8 10.5H13" stroke="#09697E" stroke-width="1.5" stroke-linecap="round">
                                    </path>
                                    <path
                                        d="M13 16V19.5309C13 19.8065 13 19.9443 12.9051 20C12.8103 20.0557 12.6806 19.9941 12.4211 19.8708L11.1789 19.2808C11.0911 19.2391 11.0472 19.2182 11 19.2182C10.9528 19.2182 10.9089 19.2391 10.8211 19.2808L9.57889 19.8708C9.31943 19.9941 9.18971 20.0557 9.09485 20C9 19.9443 9 19.8065 9 19.5309V16.45"
                                        stroke="#09697E" stroke-width="1.5" stroke-linecap="round"></path>
                                </g>
                            </svg>
                            <p class="mr-2">Prodi</p>
                            <span class="truncate">: {{ $dataMahasiswa->detailMahasiswa->prodi }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M17.5291 7.77C17.4591 7.76 17.3891 7.76 17.3191 7.77C15.7691 7.72 14.5391 6.45 14.5391 4.89C14.5391 3.3 15.8291 2 17.4291 2C19.0191 2 20.3191 3.29 20.3191 4.89C20.3091 6.45 19.0791 7.72 17.5291 7.77Z"
                                        fill="#09697E"></path>
                                    <path
                                        d="M20.7916 14.7004C19.6716 15.4504 18.1016 15.7304 16.6516 15.5404C17.0316 14.7204 17.2316 13.8104 17.2416 12.8504C17.2416 11.8504 17.0216 10.9004 16.6016 10.0704C18.0816 9.8704 19.6516 10.1504 20.7816 10.9004C22.3616 11.9404 22.3616 13.6504 20.7916 14.7004Z"
                                        fill="#09697E"></path>
                                    <path
                                        d="M6.44016 7.77C6.51016 7.76 6.58016 7.76 6.65016 7.77C8.20016 7.72 9.43016 6.45 9.43016 4.89C9.43016 3.29 8.14016 2 6.54016 2C4.95016 2 3.66016 3.29 3.66016 4.89C3.66016 6.45 4.89016 7.72 6.44016 7.77Z"
                                        fill="#09697E"></path>
                                    <path
                                        d="M6.55109 12.8506C6.55109 13.8206 6.76109 14.7406 7.14109 15.5706C5.73109 15.7206 4.26109 15.4206 3.18109 14.7106C1.60109 13.6606 1.60109 11.9506 3.18109 10.9006C4.25109 10.1806 5.76109 9.89059 7.18109 10.0506C6.77109 10.8906 6.55109 11.8406 6.55109 12.8506Z"
                                        fill="#09697E"></path>
                                    <path
                                        d="M12.1208 15.87C12.0408 15.86 11.9508 15.86 11.8608 15.87C10.0208 15.81 8.55078 14.3 8.55078 12.44C8.56078 10.54 10.0908 9 12.0008 9C13.9008 9 15.4408 10.54 15.4408 12.44C15.4308 14.3 13.9708 15.81 12.1208 15.87Z"
                                        fill="#09697E"></path>
                                    <path
                                        d="M8.87078 17.9406C7.36078 18.9506 7.36078 20.6106 8.87078 21.6106C10.5908 22.7606 13.4108 22.7606 15.1308 21.6106C16.6408 20.6006 16.6408 18.9406 15.1308 17.9406C13.4208 16.7906 10.6008 16.7906 8.87078 17.9406Z"
                                        fill="#09697E"></path>
                                </g>
                            </svg>
                            <p class="mr-2">Kelas</p>
                            <span class="truncate">: {{ $dataMahasiswa->detailMahasiswa->kelas }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path fill="#09697E"
                                    d="M21.38,5.76a1,1,0,0,0-.47-.61l-5.2-3a1,1,0,0,0-1.37.36L12,6.57,9.66,2.51a1,1,0,0,0-1.37-.36l-5.2,3a1,1,0,0,0-.47.61,1,1,0,0,0,.1.75l4,6.83A5.91,5.91,0,0,0,6,16a6,6,0,1,0,11.34-2.72l3.9-6.76A1,1,0,0,0,21.38,5.76ZM5,6.38l3.46-2L11.68,10A5.94,5.94,0,0,0,8,11.58ZM12,20a4,4,0,0,1-4-4,4,4,0,0,1,4-4,4,4,0,1,1,0,8Zm4-8.45a5.9,5.9,0,0,0-1.86-1.15L13.16,8.57l2.42-4.19,3.46,2Z">
                                </path>
                            </svg>
                            <p class="mr-2">Beasiswa</p>
                            <span class="truncate">: {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}</span>
                        </div>

                        <div class="flex items-center gap-2 border-b border-[#909090] pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path fill="#09697E"
                                    d="M14.72,8.79l-4.29,4.3L8.78,11.44a1,1,0,1,0-1.41,1.41l2.35,2.36a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.29l5-5a1,1,0,0,0,0-1.42A1,1,0,0,0,14.72,8.79ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z">
                                </path>
                            </svg>
                            <p class="mr-2">Status</p>
                            <span class="truncate">: {{ $dataMahasiswa->detailMahasiswa->status }}</span>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-6">
                        <p class="text-sm font-semibold mb-2">Laporan terajukan</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full"
                                style="width: {{ min($presentaseLaporan, 100) }}%">
                            </div>
                        </div>
                        <p class="text-xs mt-1">
                            {{ $jumlahLaporanTerkirim }}/{{ $totalLaporan }}
                        </p>
                    </div>
                </div>
            </aside>

            {{-- Data Mahasiswa Form --}}
            <section class="flex-1 bg-white shadow rounded-md p-6">
                <h2 class="font-bold text-lg mb-4">Data Mahasiswa</h2>

                {{-- Tampilkan pesan sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-700 text-green-600 p-2 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="block text-gray-600">Nama</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->name ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Email</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->email ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">NIM</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->nim ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Role</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100" value="student"
                            disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Program Studi</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->prodi ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Jenis Beasiswa</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Angkatan</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->angkatan ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Kelas</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->kelas ?? '-' }}" disabled>
                    </div>
                    <div class="col-span-1 sm:col-span-2">
                        <label class="block text-gray-600">Jenis Kelamin</label>
                        <div class="flex gap-4 mt-1 flex-wrap">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Laki-Laki" readonly
                                    onclick="return false;"
                                    {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Laki-Laki' ? 'checked' : '' }}>
                                Laki-laki
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" readonly
                                    onclick="return false;"
                                    {{ $dataMahasiswa->detailMahasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600">No HP</label>
                        <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-100"
                            value="{{ $dataMahasiswa->detailMahasiswa->no_hp ?? '-' }}" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-600">Alamat</label>
                        <textarea class="resize-none h-[120px] overflow-auto w-full border rounded-md px-3 py-2 bg-gray-100" disabled>{{ $dataMahasiswa->detailMahasiswa->alamat ?? '-' }}</textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('mahasiswa.profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Edit Profil
                    </a>
                </div>
            </section>
        </main>
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
