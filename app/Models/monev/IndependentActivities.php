<?php

namespace App\Models\monev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\users\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IndependentActivities extends Model
{
    use HasFactory;
    protected $table = 'independent_activities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'id',
      'laporan_id',
      'nim',
      'semester',
      'activity_name',
      'activity_type',
      'participation',
      'place',
      'start_date',
      'end_date',
      'bukti_url',
      'points',
      'comment',
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
}
