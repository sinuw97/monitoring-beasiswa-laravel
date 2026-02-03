<?php

namespace App\Models\monev;

use Illuminate\Database\Eloquent\Model;
use App\Models\users\Mahasiswa;
use App\Models\monev\LaporanKeuanganMahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DetailKeuanganMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'detail_keuangan_mahasiswa';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'id',
      'laporan_keuangan_id',
      'nim',
      'keperluan',
      'nominal',
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

    // Relasi ke laporan_keuangan_mahasiswa
    public function laporanKeuanganMahasiswa(){
        return $this->belongsTo(LaporanKeuanganMahasiswa::class, 'laporan_keuangan_id', 'id');
    }
}
