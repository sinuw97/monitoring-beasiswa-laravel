<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\users\Mahasiswa;
use App\Models\monev\LaporanMonevMahasiswa;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        View::composer('components.sidebar-mhs', function ($view) {

            $mahasiswa = Auth::guard('mahasiswa')->user();

            if (!$mahasiswa) {
                return;
            }

            $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
                ->where('nim', $mahasiswa->nim)
                ->first();

            $allLaporan = LaporanMonevMahasiswa::where('nim', $mahasiswa->nim)->get();

            $totalLaporan = str_contains(
                $dataMahasiswa->detailMahasiswa->prodi,
                'S1'
            ) ? 8 : 6;

            $jumlahLaporanTerkirim = $allLaporan
                ->where('status', '!=', 'Draft')
                ->count();

            $presentaseLaporan = ($jumlahLaporanTerkirim / $totalLaporan) * 100;

            $view->with(compact(
                'dataMahasiswa',
                'totalLaporan',
                'jumlahLaporanTerkirim',
                'presentaseLaporan'
            ));
        });
    }
}
