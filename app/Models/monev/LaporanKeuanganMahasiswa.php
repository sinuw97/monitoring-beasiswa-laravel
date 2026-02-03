<?php

namespace App\Models\monev;

use Illuminate\Database\Eloquent\Model;
use App\Models\users\Mahasiswa;
use App\Models\monev\DetailKeuanganMahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class LaporanKeuanganMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'laporan_keuangan_mahasiswa';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'id',
      'laporan_id',
      'nim',
      'total_nominal',
      'status',
    ];
    public $timestamps = true;

    // generate uuid
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

     // Relasi ke mahasiswa
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    // Relasi ke laporan_mahasiswa
    public function laporanMonev() {
        return $this->belongsTo(LaporanMonevMahasiswa::class, 'laporan_id', 'laporan_id');
    }

    // Relasi ke detail_keuangan_mahasiswa
    public function detailKeuanganMahasiswa()
    {
        return $this->hasMany(
            DetailKeuanganMahasiswa::class,
            'laporan_keuangan_id',
            'id',
        );
    }
}
