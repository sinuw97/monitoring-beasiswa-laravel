<?php

namespace App\Models\users;

use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\DetailMahasiswa;
use App\Models\monev\AcademicReports;
use App\Models\monev\AcademicActivities;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\OrganizationActivities;
use App\Models\monev\IndependentActivities;
use App\Models\monev\Evaluations;
use App\Models\monev\StudentAchievements;
use App\Models\monev\TargetNextSemester;
use App\Models\monev\TargetAcademicActivities;
use App\Models\monev\TargetAchievements;
use App\Models\monev\TargetIdependentActivities;
use App\Models\monev\LaporanKeuanganMahasiswa;
use App\Models\monev\DetailKeuanganMahasiswa;
use App\Models\monev\KesanPesanMahasiswa;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Authenticate
{
  use HasFactory;
  protected $table = 'mahasiswa';
  protected $primaryKey = 'nim';
  public $incrementing = false;
  protected $keyType = 'string';
  protected $fillable = [
    'nim',
    'name',
    'email',
    'password',
    'avatar',
  ];
  public $timestamps = true;

  // Relasi ke detail_mahasiswa (one to one)
  public function detailMahasiswa()
  {
    return $this->hasOne(DetailMahasiswa::class, 'nim', 'nim');
  }

  // Relasi ke laporan_mahasiswa
  public function laporanMahasiswaByNim()
  {
    return $this->hasMany(
      LaporanMonevMahasiswa::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke academic_report (one to many)
  public function academicReportsByNim()
  {
    return $this->hasMany(
      AcademicReports::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke academic_activities
  public function academicActivitiesByNim()
  {
    return $this->hasMany(
      AcademicActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke committee_activities
  public function committeeActivitiesByNim()
  {
    return $this->hasMany(
      CommitteeActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke organization_activities
  public function organizationActivitiesByNim()
  {
    return $this->hasMany(
      OrganizationActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke student_achievements
  public function studentAchievementsByNim()
  {
    return $this->hasMany(
      StudentAchievements::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke independent_activities
  public function independentActivitiesByNim()
  {
    return $this->hasMany(
      IndependentActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke evaluations
  public function evaluationsByNim()
  {
    return $this->hasMany(
      Evaluations::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke target_next_semester
  public function targetNextSemesterByNim()
  {
    return $this->hasMany(
      TargetNextSemester::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke target_academic_activities
  public function targetAcademicActivitiesByNim()
  {
    return $this->hasMany(
      TargetAcademicActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke target_achievements
  public function targetAchievementsByNim()
  {
    return $this->hasMany(
      TargetAchievements::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke independent_activities
  public function targetIndependentActivitiesByNim()
  {
    return $this->hasMany(
      TargetIdependentActivities::class,
      'nim',
      'nim',
    );
  }
  // Relasi ke laporan_keuangan_mahasiswa
  public function laporanKeuanganMahasiswa()
  {
    return $this->hasMany(
      LaporanKeuanganMahasiswa::class,
      'nim',
      'nim'
    );
  }
  // Relasi ke kesan_pesan_mahasiswa
  public function kesanPesanMahasiswa()
  {
    return $this->hasMany(
      KesanPesanMahasiswa::class,
      'nim',
      'nim'
    );
  }
  public function detailKeuanganMahasiswa()
  {
    return $this->hasMany(
      DetailKeuanganMahasiswa::class,
      'nim',
      'nim'
    );
  }
}
