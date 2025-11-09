<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Beasiswa - TSU</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #0891b2; /* cyan-600 */
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: #0891b2; /* cyan-600 */
        }

        .swiper-button-next:hover::after,
        .swiper-button-prev:hover::after {
            color: white;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 16px;
            font-weight: bold;
            color: #0891b2; /* cyan-600 */
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: #0891b2 !important; /* cyan-600 */
        }
    </style>

</head>

<body class="font-sans bg-gray-50 antialiased">

    <x-navbar-landingPage />

    <section id="beranda" class="relative overflow-hidden">
        <div class="relative h-[450px] sm:h-[600px] lg:h-[700px]">
            <img src="{{ asset('img/bckg1.png') }}" alt="Gedung TSU"
                class="w-full h-full object-cover transition-transform duration-700 ease-in-out hover:scale-105" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-cyan-900/40"></div>
        </div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight drop-shadow-lg">
                <span class="block">Web Monitoring</span>
                <span class="block text-cyan-300 mt-2">Beasiswa Tiga Serangkai University</span>
            </h1>
            <p class="mt-6 text-xl sm:text-2xl md:text-3xl font-light max-w-2xl drop-shadow-md">
                Kelola dan pantau progres beasiswa Anda dengan mudah dan transparan.
            </p>
            <a href="#tentang-beasiswa"
                class="mt-8 px-8 py-3 bg-cyan-600 text-white font-semibold rounded-full shadow-lg hover:bg-cyan-700 transition duration-300 transform hover:scale-105">
                Mulai Eksplorasi
            </a>
        </div>
    </section>

    <section id="tentang-beasiswa" class="scroll-mt-20 container mx-auto px-6 py-16 md:py-24 text-center">
        <span class="inline-block bg-cyan-100 text-cyan-800 text-sm font-medium px-4 py-1 rounded-full mb-4 ring-2 ring-cyan-500/50">
            Tentang Program
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">Apa itu <span class="text-cyan-700">Beasiswa TSU</span>?</h2>
        <p class="max-w-4xl mx-auto text-lg text-gray-600 leading-relaxed">
            <span class="font-semibold">Beasiswa</span> adalah <span class="font-semibold text-cyan-700">investasi masa depan</span> yang meringankan beban biaya pendidikan dan memungkinkan individu berfokus pada studi mereka. Di Tiga Serangkai University, kami berkomitmen untuk mendukung pemerataan akses pendidikan melalui berbagai program.
            <span class="block mt-4">Beasiswa unggulan kami meliputi <span class="font-semibold">KIP Kuliah</span> untuk mahasiswa berprestasi dari keluarga kurang mampu, serta program <span class="font-semibold">Solo Peduli</span> yang menawarkan dukungan finansial tambahan yang krusial.</span>
        </p>
    </section>

    <section class="bg-gray-100 py-16 md:py-24">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">
                Pilih Beasiswa yang Tepat di
                <span class="text-cyan-600">TSU</span>
            </h2>
            <p class="text-lg text-gray-600 mb-12">Beragam jenis beasiswa untuk mendukung perjalanan akademik Anda.</p>

            <section class="my-8">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @php
                            $scholarships = [
                                ['title' => 'Keluarga Kurang Mampu', 'desc' => 'Diberikan kepada calon mahasiswa penerima KIP Kuliah atau non-KIP Kuliah dari pemerintah, lulusan maksimal 3 tahun terakhir.', 'border' => 'border-cyan-600'],
                                ['title' => 'Prestasi Akademik', 'desc' => 'Diberikan atas prestasi di Lomba Kompetensi Siswa, Olimpiade, Hibah/Penelitian, atau Konferensi Siswa, lulusan maksimal 3 tahun terakhir.', 'border' => 'border-red-500'],
                                ['title' => 'Prestasi Non-Akademik', 'desc' => 'Diberikan atas kejuaraan di bidang seni, budaya, dan olahraga, lulusan maksimal 3 tahun terakhir.', 'border' => 'border-green-600'],
                                ['title' => 'Tahfidzul Qur’an', 'desc' => 'Diberikan untuk hafalan Qur’an minimal 10 Juz, lulusan maksimal 3 tahun terakhir.', 'border' => 'border-yellow-500'],
                                ['title' => 'Young Leaders', 'desc' => 'Diberikan untuk para Ketua/Koordinator organisasi sekolah (OSIS, PMR, Pramuka, dll.).', 'border' => 'border-blue-600'],
                                ['title' => 'Young Entrepreneurs', 'desc' => 'Diberikan untuk wirausahawan muda yang dirintis sejak bersekolah atau masa tunggu perkuliahan.', 'border' => 'border-purple-600'],
                                ['title' => 'Kompetensi Keahlian ICT', 'desc' => 'Diberikan atas kompetensi keahlian di bidang Information, Communication, and Technology (ICT).', 'border' => 'border-pink-600'],
                            ];
                        @endphp

                        @foreach ($scholarships as $item)
                        <div class="swiper-slide h-auto py-0 md:py-12">
                            <div class="flex flex-col h-full bg-white rounded-2xl p-8 border-t-8 {{ $item['border'] }} transition duration-500 hover:scale-[1.02] transform">
                                <img src="{{ asset('icon/hat.svg') }}" alt="Ikon Beasiswa" class="mx-auto w-16 h-16 mb-6 opacity-80">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item['title'] }}</h3>
                                <p class="text-gray-600 flex-grow leading-relaxed">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination mt-4"></div>
                </div>
            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const swiper = new Swiper('.swiper', {
                        loop: true,
                        slidesPerView: 1,
                        spaceBetween: 30, // Spasi lebih besar
                        // Pagination
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        // Navigation
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        // Autoplay
                        autoplay: {
                            delay: 3500, // Lebih cepat
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true, // Interaktif
                        },
                        // Responsiveness
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 30,
                            },
                        },
                    });
                });
            </script>
        </div>
    </section>

    <section id="alur" class="bg-[#09697E] text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <span class="inline-block bg-white/20 text-white text-sm font-medium px-4 py-1 rounded-full mb-4 ring-2 ring-white/50">
                Tentang Program
            </span>
            <h2 class="text-3xl md:text-4xl font-bold mb-12">Alur Penggunaan Sistem Monitoring</h2>

            <div class="relative max-w-6xl mx-auto mb-16 px-4">
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-white/30 transform -translate-y-1/2"></div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    @php
                        $alur = [
                            ['step' => 1, 'title' => 'Login', 'desc' => 'Mahasiswa masuk ke sistem menggunakan akun terdaftar.', 'icon' => 'alur-icon-1.svg'],
                            ['step' => 2, 'title' => 'Isi Laporan', 'desc' => 'Mengisi formulir Laporan Monev yang tersedia di dashboard.', 'icon' => 'alur-icon-2.svg'],
                            ['step' => 3, 'title' => 'Evaluasi Dosen', 'desc' => 'Laporan akan dievaluasi dan diverifikasi oleh dosen pembimbing.', 'icon' => 'alur-icon-3.svg'],
                            ['step' => 4, 'title' => 'Cek Status', 'desc' => 'Mengecek status beasiswa: dilanjutkan atau tidak dilanjutkan.', 'icon' => 'alur-icon-4.svg'],
                        ];
                    @endphp

                    @foreach ($alur as $item)
                        <div class="relative flex flex-col items-center text-center p-4 bg-[#075a6c] rounded-xl shadow-lg hover:bg-[#095e71] transition duration-300">
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-yellow-400 text-cyan-900 font-extrabold rounded-full flex items-center justify-center ring-4 ring-cyan-700 shadow-xl">
                                {{ $item['step'] }}
                            </div>

                            <img src="{{ asset('icon/' . $item['icon']) }}" alt="{{ $item['title'] }}" class="w-12 h-12 mt-4 mb-3 filter invert">
                            <h3 class="text-xl font-bold mb-2">{{ $item['title'] }}</h3>
                            <p class="text-sm text-cyan-100">{{ $item['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <a href={{ route('mahasiswa.login') }} class="mt-8 inline-block px-10 py-4 bg-yellow-400 text-cyan-900 font-bold text-lg rounded-full shadow-2xl hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                Masuk ke Sistem Monitoring
            </a>
        </div>
    </section>

    <footer class="bg-gray-800 text-gray-300">
        <div class="container mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-700">
            <div class="col-span-2 md:col-span-1">
                <img src="{{ asset('icon/logo.svg') }}" alt="Logo TSU" class="w-32 mb-4 filter brightness-0 invert">
                <p class="text-sm leading-relaxed">Jl. KH Samanhudi No.84-86,<br>Purwosari, Kec. Laweyan, Kota Surakarta,<br>Jawa Tengah 57149</p>
                <div class="flex space-x-4 mt-6">
                    <a href="https://www.instagram.com/tsuniversity.official?igsh=MWttc3ZlcTZxcmdwcQ==" class="text-gray-400 hover:text-cyan-400 transition duration-300" aria-label="Instagram">
                        <img src="{{ asset('icon/instagram.svg') }}" alt="Instagram" class="w-6 h-6 filter brightness-0 invert">
                    </a>
                    <a href="https://youtube.com/@tsu_official_25?si=4v3-wX8031oSnzzG" class="text-gray-400 hover:text-cyan-400 transition duration-300" aria-label="YouTube">
                        <img src="{{ asset('icon/youtube.svg') }}" alt="YouTube" class="w-6 h-6 filter brightness-0 invert">
                    </a>
                    <a href="https://www.tiktok.com/@tsuniversity.official?_r=1&_t=ZS-912S0LGR1Z1" class="text-gray-400 hover:text-cyan-400 transition duration-300" aria-label="TikTok">
                        <img src="{{ asset('icon/tik-tok.svg') }}" alt="TikTok" class="w-6 h-6 filter brightness-0 invert">
                    </a>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Navigasi Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#beranda" class="hover:text-cyan-400 transition duration-300">Beranda</a></li>
                    <li><a href="#tentang-beasiswa" class="hover:text-cyan-400 transition duration-300">Tentang Beasiswa</a></li>
                    <li><a href="#alur" class="hover:text-cyan-400 transition duration-300">Alur Sistem</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Links TSU</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="https://tsu.ac.id/" target="_blank" class="hover:text-cyan-400 transition duration-300">Website Utama TSU</a></li>
                    <li><a href="https://sinus.siakadcloud.com/gate/login" target="_blank" class="hover:text-cyan-400 transition duration-300">Sistem Akademik</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Hubungi Kami</h3>
                <p class="text-sm">
                    **Tiga Serangkai University**<br>
                    Telepon: <a href="tel:0271765500" class="hover:text-cyan-400 transition duration-300">(0271) 765500</a>
                </p>
            </div>
        </div>

        <div class="bg-gray-900 text-gray-500 text-center py-4 text-xs">
            © 2025 Tiga Serangkai University. All rights reserved.
        </div>
    </footer>

</body>

</html>
