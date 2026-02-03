<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Belajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
        }
        .page-break {
            page-break-after: always;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }
        .mt-5 { margin-top: 30px; }

        /* Cover Styles */
        .cover-title {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 50px;
            margin-bottom: 100px;
        }
        .cover-logo {
            width: 600px;
            margin-bottom: 100px;
        }
        .cover-info {
            margin: 0 auto;
            width: auto;
        }
        .cover-footer {
            position: absolute;
            bottom: 50px;
            width: 100%;
            text-align: center;
            font-weight: bold;
        }

        /* Section Styles */
        .section-header {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .sub-section-header {
            margin-left: 20px;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.bordered th, table.bordered td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }
        table.bordered th {
            background-color: #bffbf9; /* Light cyan matching reference */
            text-align: center;
        }
        table.no-border td {
            border: none;
            padding: 2px;
        }

        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: left;
            width: 45%;
        }
        .signature-box.right {
            float: right;
        }

        /* Clear float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <!-- COVER PAGE -->
    <div class="text-center page-break">
        <div class="cover-title">
            LAPORAN HASIL BELAJAR<br>
            PENERIMA BANTUAN KIP KULIAH
        </div>

        <img src="{{ public_path('icon/Logo-TSU.png') }}" class="cover-logo" alt="Logo">

        <table class="cover-info no-border">
            <tr>
                <td style="width: 200px;">NAMA</td>
                <td style="width: 10px;">:</td>
                <td>{{ $dataMahasiswa->name }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $dataMahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>ANGKATAN</td>
                <td>:</td>
                <td>{{ $dataMahasiswa->detailMahasiswa->angkatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>JENJANG/PROGRAM STUDI</td>
                <td>:</td>
                <td>S1 / {{ $dataMahasiswa->detailMahasiswa->prodi ?? '-' }}</td>
            </tr>
        </table>

        <div class="cover-footer">
            Bantuan Biaya Pendidikan KIP KULIAH<br>
            UNIVERSITAS TIGA SERANGKAI<br>
            TAHUN {{ date('Y') }}
        </div>
    </div>

    <!-- PAGE 2: DATA & AKADEMIK -->
    <div class="page-break">
        <div class="section-header">I. DATA MAHASISWA</div>
        <table class="no-border" style="width: 100%; margin-left: 20px;">
            <tr>
                <td style="width: 200px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td>{{ $dataMahasiswa->name }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $dataMahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>-</td> <!-- Data not available in model -->
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $dataMahasiswa->detailMahasiswa->prodi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenjang</td>
                <td>:</td>
                <td>S1</td>
            </tr>
            <tr>
                <td>Fakultas</td>
                <td>:</td>
                <td>-</td> <!-- Data not available in model -->
            </tr>
            <tr>
                <td>Perguruan Tinggi</td>
                <td>:</td>
                <td>Universitas Tiga Serangkai</td>
            </tr>
            <tr>
                <td>Tahun Masuk</td>
                <td>:</td>
                <td>{{ $dataMahasiswa->detailMahasiswa->angkatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tahun Lulus</td>
                <td>:</td>
                <td>-</td>
            </tr>
        </table>

        <div class="section-header">II. LAPORAN PRESTASI AKADEMIK</div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>Semester</th>
                    <th>IPS</th>
                    <th>IPK</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop for Semester 1 to 8 -->
                @for ($i = 1; $i <= 8; $i++)
                    @php
                        // Convert number to Roman
                        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'];
                        $romanSemester = $romans[$i-1];

                        // Find data for this semester
                        $report = $laporan->academicReports->where('semester', $i)->first();
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">{{ $romanSemester }}</td>
                        <td class="text-center">{{ $report ? $report->ips : '' }}</td>
                        <td class="text-center">{{ $report ? $report->ipk : '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div style="font-size: 10pt; margin-top: 5px;">
            *) Melampirkan KHS atau transkrip nilai keseluruhan sampai lulus yang dilegalisir oleh Jurusan/Program Studi<br>
            *) Untuk D3 maksimal semester 6, untuk D4/S1 maksimal semester 8
        </div>

        <div class="section-header">III. LAPORAN PRESTASI NON AKADEMIK</div>
        <div class="sub-section-header">a) Prestasi yang diraih selama menjadi mahasiswa Universitas Tiga Serangkai :</div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th>Kegiatan</th>
                    <th>Tingkat</th>
                    <th>Waktu pelaksanaan</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan->studentAchievements as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->achievements_name }}</td>
                        <td>{{ $item->level }}</td>
                        <td>{{ $item->date ?? '-' }}</td>
                        <td>{{ $item->award }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="font-size: 10pt;">
            *) Kolom ‘Tingkat’ diisi dengan pilihan kota/propinsi/nasional/internasional<br>
            *) melampirkan copy sertifikat/piagam
        </div>

        <div class="sub-section-header">b) Keikutsertaan pada kegiatan organisasi kemahasiswaan intra kampus selama menjadi mahasiswa Universitas Tiga Serangkai :</div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th>Nama Organisasi</th>
                    <th>Aktif sejak</th>
                    <th>Akhir Keaktifan</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan->organizationActivities as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->ukm_name }}</td>
                        <td>{{ $item->start_date ?? '-' }}</td>
                        <td>{{ $item->end_date ?? '-' }}</td>
                        <td>{{ $item->position }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="font-size: 10pt;">
            *) melampirkan copy sertifikat/surat keterangan dari pimpinan organisasi
        </div>
    </div>

    <!-- PAGE 3: CONTINUE NON-AKADEMIK & KEUANGAN -->
    <div class="page-break">
        <div class="sub-section-header">c) Keikutsertaan pada kegiatan kepanitiaan yang diikuti selama menjadi mahasiswa Universitas Tiga Serangkai :</div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th>Kegiatan</th>
                    <th>Waktu pelaksanaan</th>
                </tr>
            </thead>
            <tbody>
                 @forelse($laporan->committeeActivities as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->activity_name }}</td>
                        <td>{{ $item->start_date ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="font-size: 10pt;">
            *) melampirkan copy sertifikat/surat keterangan dari ketua panitia
        </div>

        <div class="sub-section-header">d) Publikasi Ilmiah/Artikel/Karya Tulis/PKM yang dibuat selama menjadi mahasiswa Universitas Tiga Serangkai :</div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th>Judul karya tulis/karya ilmiah</th>
                </tr>
            </thead>
            <tbody>
                 @forelse($laporan->independentActivities as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->activity_name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="font-size: 10pt;">
            *) melampirkan copy hasil Karya Ilmiah/Karya Tulis/PKM yang telah dibuat
        </div>

        <div class="section-header">IV. LAPORAN KEUANGAN</div>
        <div style="margin-bottom: 5px;">
            Laporan rata-rata pemakaian dana biaya hidup yang diberikan sebesar Rp 5.700.000,- per semester oleh mahasiswa selama satu semester :
        </div>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Keperluan</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Correct relation usage
                    $laporanKeuangan = $laporan->laporanKeuanganMahasiswa;
                    $detailKeuangan = $laporanKeuangan ? $laporanKeuangan->detailKeuanganMahasiswa : collect([]);
                    $total = 0;
                @endphp
                @if($detailKeuangan->isNotEmpty())
                    @foreach($detailKeuangan as $item)
                        @php $total += $item->nominal; @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->keperluan }}</td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">1</td>
                        <td>Makan</td>
                        <td>Rp </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Tempat Tinggal (kos)</td>
                        <td>Rp </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Transportasi</td>
                        <td>Rp </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>.........................................</td>
                        <td>Rp </td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>.........................................</td>
                        <td>Rp </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2" class="text-center text-bold">Jumlah</td>
                    <td class="text-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-header">V. Kesan - kesan Mahasiswa</div>
        <div style="font-style: italic; color: #09697E;">
            Diisi kesan selama menerima beasiswa KIPdi Universitas Tiga Serangkai
        </div>
        <div style="border-bottom: 1px solid black; margin-top: 5px; min-height: 20px;">
             @foreach($laporan->kesanPesanMahasiswa as $kesan)
                {{ $kesan->kesan }} <br>
             @endforeach
        </div>
        <div style="margin-top: 20px;">
            Demikian laporan ini saya buat dengan sebenar-benarnya.
        </div>

        <div class="signature-section clearfix">
            <div class="signature-box left">
                Mengetahui,<br>
                Wakil Rektor<br>
                Bidang Akademik, Inovasi dan Kemahasiswaan<br>
                <br><br><br><br>
                <div class="mb-1" style="font-size: 8pt; color: #888;">CAP PTS - TTD</div>
                <b>( Prof. Dr. Drajat Tri Kartono, M.Si )</b><br>
                NIP. 102024039
            </div>
            <div class="signature-box right">
                ...................., ...........................................<br>
                Pembuat Laporan<br>
                <br><br><br><br><br>
                <div class="mb-1" style="font-size: 8pt; color: #888;">TTD + Materai Rp.10.000,-</div>
                <b>( {{ $dataMahasiswa->name }} )</b><br>
                NIM. {{ $dataMahasiswa->nim }}
            </div>
        </div>
    </div>

    <!-- PAGE 4: ATTACHMENTS -->
    <div>
        <h3 class="text-center">Lampiran - lampiran</h3>
        <table class="bordered">
            <thead>
                <tr>
                    <th style="width: 30px;">No.</th>
                    <th>Nama Dokumen</th>
                    <th style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Kartu Hasil Studi (KHS)</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Copy sertifikat/piagam prestasi yang diraih selama menjadi mahasiswa</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Copy sertifikat/surat keterangan keikutsertaan pada kegiatan organisasi kemahasiswaan intra kampus</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>Copy sertifikat/surat keterangan keikutsertaan pada kegiatan kepanitiaan</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td>Copy hasil publikasi Ilmiah/Karya Tulis/PKM</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">7</td>
                    <td>Copy Surat Keterangan Lulus/ Copy Ijazah</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">8</td>
                    <td>Copy Transkrip Nilai</td>
                    <td class="text-center">Ada / Tidak</td>
                </tr>
                <tr>
                    <td class="text-center">9</td>
                    <td>......................... (Lampiran lain)</td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center">Dst.</td>
                    <td></td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
