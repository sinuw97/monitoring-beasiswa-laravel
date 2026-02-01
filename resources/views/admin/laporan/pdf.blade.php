<!DOCTYPE html>
<html>
<head>
    <title>Laporan Monev</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #09697E;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #666;
            width: 120px;
        }
        .value {
            font-weight: bold;
            color: #333;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #09697E;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #09697E;
        }
        .status-badge {
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .evaluasi-box {
            background-color: #f9fafb;
            padding: 10px;
            border: 1px solid #e5e7eb;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>DETAIL LAPORAN MONITORING DAN EVALUASI</h1>
        <p>Tahun Akademik {{ $laporan->periodeSemester?->tahun_akademik }} - {{ $laporan->periodeSemester?->semester }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Mahasiswa</td>
            <td class="value">: {{ $dataMahasiswa->name }}</td>
            <td class="label">Periode</td>
            <td class="value">: {{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}</td>
        </tr>
        <tr>
            <td class="label">NIM</td>
            <td class="value">: {{ $dataMahasiswa->nim }}</td>
            <td class="label">Status</td>
            <td class="value">: {{ $laporan->status }}</td>
        </tr>
    </table>

    <div class="section-title">A. Kegiatan Akademik (IPS & IPK)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Semester</th>
                <th>IPS</th>
                <th>IPK</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan->academicReports as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->semester }}</td>
                    <td>{{ $item->ips }}</td>
                    <td>{{ $item->ipk }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Kegiatan Akademik Lainnya</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Tipe</th>
                <th>Peran</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan->academicActivities as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->activity_name }}</td>
                    <td>{{ $item->activity_type }}</td>
                    <td>{{ $item->participation }}</td>
                    <td>{{ $item->points }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">B. Kegiatan Non-Akademik (Organisasi)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>UKM</th>
                <th>Kegiatan</th>
                <th>Tingkat</th>
                <th>Posisi</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
             @forelse($laporan->organizationActivities as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->ukm_name }}</td>
                    <td>{{ $item->activity_name }}</td>
                    <td>{{ $item->level }}</td>
                    <td>{{ $item->position }}</td>
                    <td>{{ $item->points }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Kegiatan Kepanitiaan</div>
    <table class="data-table">
        <thead>
             <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Partisipasi</th>
                <th>Tingkat</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan->committeeActivities as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->activity_name }}</td>
                    <td>{{ $item->participation }}</td>
                    <td>{{ $item->level }}</td>
                    <td>{{ $item->points }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Prestasi</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Prestasi</th>
                <th>Tingkat</th>
                <th>Juara</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
         <tbody>
            @forelse($laporan->studentAchievements as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->achievements_name }}</td>
                    <td>{{ $item->level }}</td>
                    <td>{{ $item->award }}</td>
                    <td>{{ $item->points }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Kegiatan Mandiri</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Partisipasi</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan->independentActivities as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->activity_name }}</td>
                    <td>{{ $item->participation }}</td>
                    <td>{{ $item->points }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
             @empty
                <tr><td colspan="5" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">C. Evaluasi Diri</div>
    <div class="evaluasi-box">
        <p style="font-weight: bold; margin-bottom: 5px;">Faktor Pendukung</p>
        @if($laporan->evaluations->first())
            {{ $laporan->evaluations->first()->support_factors }}
            <br><br>
        @else
            Tidak ada evaluasi diri.
        @endif
        <p style="font-weight: bold; margin-bottom: 5px;">Faktor Penghambat</p>
        @if($laporan->evaluations->first())
            {{ $laporan->evaluations->first()->barrier_factors }}
        @else
            Tidak ada evaluasi diri.
        @endif
    </div>

    <div class="section-title">D. Rencana Semester Depan</div>

    <p style="font-weight: bold; margin-bottom: 5px;">Target Akademik</p>
    <table class="data-table">
        <thead>
             <tr>
                <th>No</th>
                <th>Semester</th>
                <th>Target IPS</th>
                <th>Target IPK</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan->targetNextSemester as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->semester }}</td>
                    <td>{{ $item->target_ips }}</td>
                    <td>{{ $item->target_ipk }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
