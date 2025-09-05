<?php

namespace App\Models\monev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\semester\Periode;
use Illuminate\Database\Eloquent\Model;

class LaporanMonevMahasiswa extends Model
{
  use HasFactory;
  protected $table = 'laporan_mahasiswa';
  protected $primaryKey = 'laporan_id';
  public $incrementing = false;
  protected $keyType = 'string';
  protected $fillable = [
    'laporan_id',
    'nim',
  ];
  public $timestamps = true;

  // Relasi ke periode
  public function periodeSemester()
  {
    return $this->belongsTo(Periode::class, 'semester_id', 'semester_id');
  }

  // Relasi ke academic_report (one to many)
  public function academicReports()
  {
    return $this->hasMany(
      AcademicReports::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke academic_activities
  public function academicActivities()
  {
    return $this->hasMany(
      AcademicActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke committee_activities
  public function committeeActivities()
  {
    return $this->hasMany(
      CommitteeActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke organization_activities
  public function organizationActivities()
  {
    return $this->hasMany(
      OrganizationActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke student_achievements
  public function studentAchievements()
  {
    return $this->hasMany(
      StudentAchievements::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke independent_activities
  public function independentActivities()
  {
    return $this->hasMany(
      IndependentActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke evaluations
  public function evaluations()
  {
    return $this->hasMany(
      Evaluations::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke target_next_semester
  public function targetNextSemester()
  {
    return $this->hasMany(
      TargetNextSemester::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke target_academic_activities
  public function targetAcademicActivities()
  {
    return $this->hasMany(
      TargetAcademicActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke target_achievements
  public function targetAchievements()
  {
    return $this->hasMany(
      TargetAchievements::class,
      'laporan_id',
      'laporan_id',
    );
  }
  // Relasi ke independent_activities
  public function targetIndependentActivities()
  {
    return $this->hasMany(
      TargetIdependentActivities::class,
      'laporan_id',
      'laporan_id',
    );
  }
}
