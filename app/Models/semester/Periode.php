<?php

namespace App\Models\semester;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\monev\LaporanMonevMahasiswa;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table = 'periode';
    protected $primaryKey = 'semester_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'semester_id',
        'tahun_akademik',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
    public $timestamps = true;

    // Relasi ke laporan_mahasiswa
    public function laporanMonevMahasiswa() {
        return $this->hasMany(LaporanMonevMahasiswa::class, 'semester_id', 'semester_id');
    }
}
