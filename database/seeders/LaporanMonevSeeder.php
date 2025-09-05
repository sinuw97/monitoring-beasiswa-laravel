<?php

namespace Database\Seeders;

use App\Models\monev\LaporanMonevMahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class LaporanMonevSeeder extends Seeder
{
    public function run(): void
    {
        $monevMhs1 = LaporanMonevMahasiswa::create([
            'laporan_id' => 'LP221111110509251011',
            'nim' => '22111111',
            'semester_id' => 'SM202201',
            'status' => 'Lolos',
        ]);
        $monevMhs1->academicReports()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'ips' => 4,
            'ipk' => 4,
            'bukti_url' => 'Tidak Ada',
            'comment' => 'Lorem ipsum',
            'status' => 'Valid',
        ]);
        $monevMhs1->academicActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Lorem ipsum dolor',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs1->committeeActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'level' => 'Amet',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs1->organizationActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'ukm_name' => 'ukm 1',
            'activity_name' => 'Lorem ipsum',
            'level' => 'Perguruan Tinggi',
            'position' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs1->independentActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs1->studentAchievements()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'achievements_name' => 'Lorem ipsum dolor',
            'scope' => 'Pemerintahan',
            'is_group' => false,
            'level' => 'Regional',
            'award' => 'Juara Harapan',
            'place' => 'Lorem ipsum',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs1->evaluations()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 1,
            'support_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'barrier_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'status' => 'Valid',
        ]);
        $monevMhs1->targetNextSemester()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 2,
            'target_ips' => 4,
            'target_ipk' => 4,
            'status' => 'Valid',
        ]);
        $monevMhs1->targetAcademicActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);
        $monevMhs1->targetAchievements()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 2,
            'achievements_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'level' => 'dolor',
            'award' => 'amet',
            'status' => 'Valid',
        ]);
        $monevMhs1->targetIndependentActivities()->create([
            'nim' => $monevMhs1->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'participation' => 'Anggota',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);

        $monevMhs2 = LaporanMonevMahasiswa::create([
            'laporan_id' => 'LP222222220509251014',
            'nim' => '22222222',
            'semester_id' => 'SM202201',
            'status' => 'Lolos',
        ]);
        $monevMhs2->academicReports()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'ips' => 4,
            'ipk' => 4,
            'bukti_url' => 'Tidak Ada',
            'comment' => 'Lorem ipsum',
            'status' => 'Valid',
        ]);
        $monevMhs2->academicActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Lorem ipsum dolor',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs2->committeeActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'level' => 'Amet',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs2->organizationActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'ukm_name' => 'ukm 1',
            'activity_name' => 'Lorem ipsum',
            'level' => 'Perguruan Tinggi',
            'position' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs2->independentActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs2->studentAchievements()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'achievements_name' => 'Lorem ipsum dolor',
            'scope' => 'Pemerintahan',
            'is_group' => false,
            'level' => 'Regional',
            'award' => 'Juara Harapan',
            'place' => 'Lorem ipsum',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs2->evaluations()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 1,
            'support_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'barrier_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'status' => 'Valid',
        ]);
        $monevMhs2->targetNextSemester()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 2,
            'target_ips' => 4,
            'target_ipk' => 4,
            'status' => 'Valid',
        ]);
        $monevMhs2->targetAcademicActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);
        $monevMhs2->targetAchievements()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 2,
            'achievements_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'level' => 'dolor',
            'award' => 'amet',
            'status' => 'Valid',
        ]);
        $monevMhs2->targetIndependentActivities()->create([
            'nim' => $monevMhs2->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'participation' => 'Anggota',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);

        $monevMhs3 = LaporanMonevMahasiswa::create([
            'laporan_id' => 'LP223333330509251015',
            'nim' => '22333333',
            'semester_id' => 'SM202201',
            'status' => 'Lolos',
        ]);
        $monevMhs3->academicReports()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'ips' => 4,
            'ipk' => 4,
            'bukti_url' => 'Tidak Ada',
            'comment' => 'Lorem ipsum',
            'status' => 'Valid',
        ]);
        $monevMhs3->academicActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Lorem ipsum dolor',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs3->committeeActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'level' => 'Amet',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs3->organizationActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'ukm_name' => 'ukm 1',
            'activity_name' => 'Lorem ipsum',
            'level' => 'Perguruan Tinggi',
            'position' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs3->independentActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'activity_name' => 'Lorem ipsum',
            'activity_type' => 'Dolor sit',
            'participation' => 'Anggota',
            'place' => 'Kampus TSU',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs3->studentAchievements()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'achievements_name' => 'Lorem ipsum dolor',
            'scope' => 'Pemerintahan',
            'is_group' => false,
            'level' => 'Regional',
            'award' => 'Juara Harapan',
            'place' => 'Lorem ipsum',
            'start_date' => Date::now(),
            'end_date' => Date::now(),
            'points' => 0,
            'comment' => 'Bagus',
            'status' => 'Valid',
            'bukti_url' => 'Tiadk Ada'
        ]);
        $monevMhs3->evaluations()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 1,
            'support_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'barrier_factors' => '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat. Phasellus eu nunc tempor, pretium sapien vel, dictum felis. Aenean sit amet lorem maximus, maximus dolor at, pharetra sapien. Vivamus semper justo quis rutrum gravida. Nulla facilisi. Aenean ac purus fermentum, luctus magna nec, luctus nisi. Nulla facilisi.',
            'status' => 'Valid',
        ]);
        $monevMhs3->targetNextSemester()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 2,
            'target_ips' => 4,
            'target_ipk' => 4,
            'status' => 'Valid',
        ]);
        $monevMhs3->targetAcademicActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);
        $monevMhs3->targetAchievements()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 2,
            'achievements_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'level' => 'dolor',
            'award' => 'amet',
            'status' => 'Valid',
        ]);
        $monevMhs3->targetIndependentActivities()->create([
            'nim' => $monevMhs3->nim,
            'semester' => 2,
            'activity_name' => 'Lorem ipsum dolor sit amet, consectetur',
            'participation' => 'Anggota',
            'strategy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum sed ipsum in consequat.',
            'status' => 'Valid',
        ]);
    }
}
