<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

    <title>@yield('title', 'Dashboard Mahasiswa') - Monitoring Beasiswa</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    {{-- Navbar --}}
    <x-navbar-mhs mhsName='{{ $dataMahasiswa->name }}' mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <div class="flex flex-col lg:flex-row relative">

        {{-- Sidebar Component --}}
        <x-sidebar-mhs :dataMahasiswa="$dataMahasiswa" :presentaseLaporan="$presentaseLaporan ?? 0"
            :jumlahLaporanTerkirim="$jumlahLaporanTerkirim ?? 0" :totalLaporan="$totalLaporan ?? 0" />

        {{-- Main Content Wrapper --}}
        {{-- Added padding-left to account for fixed sidebar on desktop --}}
        <main
            class="w-full lg:w-[calc(100%-250px)] lg:ml-[250px] px-4 lg:px-8 py-6 min-h-screen transition-all duration-300">
            @yield('content')
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
        document.addEventListener('submit', function () {
            NProgress.start()
        });
    </script>
    @stack('scripts')
</body>

</html>