<?php

namespace Database\Seeders;

use App\Models\users\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mhs1 = Mahasiswa::create([
            'nim'=>'22111111',
            'name'=>'Akun Dummy 1',
            'email'=>'dummy1@email.com',
            'password'=>bcrypt('dummy123'),
            'avatar'=>'https://ui-avatars.com/api/?name=Akun+Dummy+1&background=random'
        ]);
        $mhs1->detailMahasiswa()->create([
            'prodi'=>'S1-Informatika',
            'angkatan'=>'2022',
            'kelas'=>'Reguler',
            'jenis_beasiswa'=>'KIP',
            'jenis_kelamin'=>'Laki-Laki',
            'no_hp'=>'08123456789',
            'alamat'=>'Lorem ipsum dolor sit amet',
            'status'=>'Aktif'
        ]);

        $mhs2 = Mahasiswa::create([
            'nim'=>'22222222',
            'name'=>'Akun Dummy 2',
            'email'=>'dummy2@email.com',
            'password'=>bcrypt('dummy123'),
            'avatar'=>'https://ui-avatars.com/api/?name=Akun+Dummy+2&background=random'
        ]);
        $mhs2->detailMahasiswa()->create([
            'prodi'=>'S1-Informatika',
            'angkatan'=>'2022',
            'kelas'=>'Reguler',
            'jenis_beasiswa'=>'KIP',
            'jenis_kelamin'=>'Laki-Laki',
            'no_hp'=>'08123456789',
            'alamat'=>'Lorem ipsum dolor sit amet',
            'status'=>'Aktif'
        ]);

        $mhs3 = Mahasiswa::create([
            'nim'=>'22333333',
            'name'=>'Akun Dummy 3',
            'email'=>'dummy3@email.com',
            'password'=>bcrypt('dummy123'),
            'avatar'=>'https://ui-avatars.com/api/?name=Akun+Dummy+3&background=random'
        ]);
        $mhs3->detailMahasiswa()->create([
            'prodi'=>'S1-Informatika',
            'angkatan'=>'2022',
            'kelas'=>'Reguler',
            'jenis_beasiswa'=>'KIP',
            'jenis_kelamin'=>'Perempuan',
            'no_hp'=>'08123456789',
            'alamat'=>'Lorem ipsum dolor sit amet',
            'status'=>'Aktif'
        ]);
    }
}
