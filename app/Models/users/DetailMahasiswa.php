<?php

namespace App\Models\users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\users\Mahasiswa;
use Illuminate\Database\Eloquent\Model;

class DetailMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'detail_mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'nim',
      'prodi',
      'angkatan',
      'kelas',
      'jenis_beasiswa',
      'jenis_kelamin',
      'no_hp',
      'alamat',
      'status',
    ];
    public $timestamps = true;

    // Relasi mahasiswa (one to one)
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
