<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Beasiswa - TSU</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body class="font-sans bg-gray-50">

    <!-- Navbar -->
    <x-navbar-landingPage />

    <!-- Hero Section -->
    <section id="beranda" class="relative">
        <!-- Gambar background -->
        <img src="{{ asset('img/bckg1.png') }}" alt="Gedung TSU"
            class="w-full h-[400px] sm:h-[500px] md:h-[600px] lg:h-[714px] object-cover">

        <!-- Overlay hitam transparan -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Teks di atas semuanya -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">
                Web Monitoring
            </h1>
            <p class="text-lg sm:text-2xl md:text-3xl lg:text-4xl mt-2 text-cyan-300">
                Beasiswa Tiga Serangkai University
            </p>
        </div>
    </section>

    <!-- Apa itu Beasiswa -->
    <section id="tentang-beasiswa" class="scroll-mt-15 container mx-auto px-6 py-12 text-center">
        <button class="bg-cyan-900 text-white px-4 py-1 rounded-full text-sm mb-4">Tentang Beasiswa</button>
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Apa itu Beasiswa?</h2>
        <p class="max-w-3xl mx-auto text-gray-700 leading-relaxed">
            Beasiswa adalah bentuk bantuan finansial yang diberikan kepada individu, baik pelajar maupun mahasiswa,
            sebagai dukungan untuk meringankan beban biaya pendidikan
            dan membantu mereka melanjutkan studi. Di Tiga Serangkai University, terdapat beberapa program beasiswa yang
            ditawarkan sebagai wujud komitmen perguruan tinggi dalam
            mendukung pemerataan akses pendidikan. Beberapa di antaranya adalah beasiswa KIP Kuliah, yang ditujukan bagi
            mahasiswa berprestasi dari keluarga kurang mampu,
            serta beasiswa Solo Peduli, yang berfokus pada pemberian bantuan bagi mahasiswa yang membutuhkan dukungan
            tambahan untuk menyelesaikan pendidikan mereka.
        </p>
    </section>

    <!-- Jenis Beasiswa -->
    <section class="container mx-auto px-6 text-center py-12">
        <h2 class="text-2xl font-bold mb-8 bg">
            Semangat kuliah bersama beasiswa di
            <span class="text-cyan-700">Tiga Serangkai University!</span>
        </h2>

        <section class="my-12">
            <div class="swiper">
                <div class="swiper-wrapper">

                    <!-- 1 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-cyan-700">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa KIP-K" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Keluarga Tidak Mampu</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan para calon mahasiswa yang berasal dari keluarga tidak
                                mampu,
                                dalam hal ini merupakan penerima KIP Kuliah atau yang bukan penerima KIP Kuliah dari
                                pemerintah,
                                dengan waktu kelulusan maksimal 3 (tiga) tahun terakhir
                            </p>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-red-500">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa Solo Peduli" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Prestasi Akademik</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan atas prestasi akademik, yaitu Lomba Kompetensi Siswa,
                                Olimpiade Sains Nasional, Hibah/Penelitian Siswa, dan Lomba Mata Pelajaran,
                                atau Konferensi Siswa yang diikuti selama bersekolah di SMA/SMK/MA/sederajat,
                                dengan waktu kelulusan maksimal 3 (tiga) tahun terakhir.
                            </p>
                        </div>
                    </div>

                    <!-- 3 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-green-600">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa Unggulan" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Prestasi Non-Akademik</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan atas prestasi non akademik, yaitu kejuaraan di bidang
                                seni,
                                budaya, dan olahraga, yang diikuti selama bersekolah di SMA/SMK/MA/sederajat,
                                dengan waktu kelulusan maksimal 3 (tiga) tahun terakhir.
                            </p>
                        </div>
                    </div>

                    <!-- 4 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-yellow-500">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa PPA" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Tahfidzul Qur’an</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan untuk hafalan Qur’an minimal 10 Juz,
                                selama bersekolah di SMA/SMK/MA/sederajat, dengan waktu kelulusan maksimal 3 (tiga)
                                tahun terakhir.
                            </p>
                        </div>
                    </div>

                    <!-- 5 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-blue-600">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa Daerah" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Young Leaders</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan untuk para Ketua/Koordinator organisasi sekolah
                                (OSIS, MPK, Majalah Sekolah, PMR, Pramuka, dan lain-lain), selama bersekolah di
                                SMA/SMK/MA/sederajat,
                                dengan waktu kelulusan maksimal 3 (tiga) tahun terakhir.
                            </p>
                        </div>
                    </div>

                    <!-- 6 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-purple-600">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa Riset" class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Young Entrepreneurs</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan para wirausahawan muda yang dirintis sejak bersekolah
                                di SMA/SMK/MA/sederajat atau selama masa tunggu menuju perkuliahan.
                            </p>
                        </div>
                    </div>

                    <!-- 7 -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-md p-8 border-t-4 border-pink-600">
                            <img src="{{ asset('icon/hat.svg') }}" alt="Beasiswa Internasional"
                                class="mx-auto w-24 mb-4">
                            <h3 class="text-xl font-bold mb-2">Beasiswa Kompetensi Keahlian ICT</h3>
                            <p class="text-gray-700">
                                Beasiswa Siti Aminah diberikan atas kompetensi keahlian di bidang Information,
                                Communication, and Technology (ICT) yang diikuti selama bersekolah di
                                SMA/SMK/MA/sederajat,
                                dengan waktu kelulusan maksimal 3 (tiga) tahun terakhir.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Tombol navigasi -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination bulatan -->
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <script>
            const swiper = new Swiper('.swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2, // tampil 2 kartu di layar sedang
                    },
                    1024: {
                        slidesPerView: 3, // tampil 3 kartu di layar besar
                    },
                },
            });
        </script>
    </section>

    <!-- Cara Mendaftar -->
    <section id="alur" class="bg-yellow-400 text-black py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-8">Alur Penggunaan Sistem</h2>

            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <img src="{{ asset('img/urutan.svg') }}" alt="Login" class="h-18">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto text-gray-900 text-left">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">1.</span>
                    <img src="{{ asset('icon/alur-icon-1.svg') }}" alt="Login" class="w-6 h-6">
                    <p>Mahasiswa login untuk bisa mengisi laporan nya</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">2.</span>
                    <img src="{{ asset('icon/alur-icon-2.svg') }}" alt="Isi Laporan" class="w-6 h-6">
                    <p>Mengisi laporan monev yang tersedia pada dashboard mahasiswa</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">3.</span>
                    <img src="{{ asset('icon/alur-icon-3.svg') }}" alt="Evaluasi" class="w-6 h-6">
                    <p>Menunggu laporan dievaluasi oleh dosen</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">4.</span>
                    <img src="{{ asset('icon/alur-icon-4.svg') }}" alt="Status" class="w-6 h-6">
                    <p>Mengecek status apakah beasiswa dilanjutkan atau tidak</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white-900 text-black">
        <div class="container mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">
            <div>
                <img src="{{ asset('icon/logo.svg') }}" alt="Logo TSU" class="w-28 mb-4">
                <p>Jl. KH Samanhudi No.84-86,<br>Purwosari, Kec. Laweyan, Kota Surakarta,<br>Jawa Tengah 57149</p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.instagram.com/tsuniversity.official?igsh=MWttc3ZlcTZxcmdwcQ==">
                        <img src="{{ asset('icon/instagram.svg') }}" alt="Instagram" class="w-6">
                    </a>
                    <a href="https://youtube.com/@tsu_official_25?si=4v3-wX8031oSnzzG">
                        <img src="{{ asset('icon/youtube.svg') }}" alt="YouTube" class="w-6">
                    </a>
                    <a href="https://www.tiktok.com/@tsuniversity.official?_r=1&_t=ZS-912S0LGR1Z1">
                        <img src="{{ asset('icon/tik-tok.svg') }}" alt="TikTok" class="w-6">
                    </a>
                </div>
            </div>

            <div>
                <h3 class="font-bold mb-2">Links</h3>
                <ul class="space-y-1">
                    <li><a href="https://tsu.ac.id/" class="hover:underline">Tentang TSU</a></li>
                    <li><a href="https://sinus.siakadcloud.com/gate/login" class="hover:underline">Sistem Akademik
                            TSU</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-2">Contact</h3>
                <p>Tiga Serangkai University</p>
                <p>(0271) 765500</p>
            </div>
        </div>

        <div class="bg-gray-800 text-white text-center py-3 text-sm">
            © 2025 Tiga Serangkai University. All rights reserved.
        </div>
    </footer>

</body>

</html>