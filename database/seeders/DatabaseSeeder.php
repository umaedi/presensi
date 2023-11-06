<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kepalaopd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $opd = [
            ['nama_opd'    => 'Bagian Hukum dan Perundangan undangan'],
            ['nama_opd'    => 'Bagian Umum'],
            ['nama_opd'    => 'Bagian Kerjasama'],
            ['nama_opd'    => 'Bagian Kesejahtraan Sosial'],
            ['nama_opd'    => 'Bagian Organisasi'],
            ['nama_opd'    => 'Bagian Administrasi Penatausahaan Keuangan'],
            ['nama_opd'    => 'Bagian Perekonomian'],
            ['nama_opd'    => 'Bagian Pemerintah dan Otonomi Daerah'],
            ['nama_opd'    => 'Bagian Protokol'],
            ['nama_opd'    => 'Bagian SDA dan Infrastruktur'],
            ['nama_opd'    => 'Bagian Pengadaan Barang dan Jasa'],
            ['nama_opd'    => 'Bagian Administrasi Pembangunan'],
            ['nama_opd'    => 'Badan Kepegawaian Daerah'],
            ['nama_opd'    => 'Badan Penanggulangan Bencana Daerah'],
            ['nama_opd'    => 'Badan Perencanaan dan Pembangunan'],
            ['nama_opd'    => 'Badan Pendapatan Daerah'],
            ['nama_opd'    => 'Badan Pengelolaan Keuangan dan Aset Daerah'],
            ['nama_opd'    => 'Badan Kesbangpol'],
            ['nama_opd'    => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu'],
            ['nama_opd'    => 'Dinas Kominfo'],
            ['nama_opd'    => 'Dinas Pendidikan'],
            ['nama_opd'    => 'Dinas Kebudayaan dan Parawisata'],
            ['nama_opd'    => 'Dinas Perikanan'],
            ['nama_opd'    => 'Dinas Kependudukan dan Catatan Sipil'],
            ['nama_opd'    => 'Dinas Perdagangan'],
            ['nama_opd'    => 'Dinas Pekerjaan Umum dan Penataan Ruang'],
            ['nama_opd'    => 'Dinas Ketahanan Pangan'],
            ['nama_opd'    => 'Dinas Lingkungan Hidup'],
            ['nama_opd'    => 'Dinas PMK'],
            ['nama_opd'    => 'Dinas Perhubungan'],
            ['nama_opd'    => 'Dinas Kepemudaan dan Olahraga'],
            ['nama_opd'    => 'Dinas Koprasi dan UMKM'],
            ['nama_opd'    => 'Dinas Pertanian'],
            ['nama_opd'    => 'Dinas Tenaga Kerja dan Transmigrasi'],
            ['nama_opd'    => 'Dinas Perpustakaan dan Kearsipan'],
            ['nama_opd'    => 'Dinas Perumahan Rakyat dan Kawasan Permukiman'],
            ['nama_opd'    => 'Dinas Sosial'],
            ['nama_opd'    => 'Dinas Kesehatan'],
            ['nama_opd'    => 'Dinas PPKB'],
            ['nama_opd'    => 'Dinas DP3A'],
        ];

        foreach ($opd as $value) {
            \App\Models\Opd::create($value);
        }

        \App\Models\User::create([
            'opd_id'    => 1,
            'nama'      => 'dev',
            'nip'       => '12345678910111213141516',
            'jabatan'   => 'Kepala Pengembang',
            'organisasi'    => 'Tulang Bawang',
            'unit_organisasi'   => 'Bidang Pengembangan Teknologi',
            'email'     => 'devkh@gmail.com',
            'no_hp'     => '085741492045',
            'role'      => 'user',
            'status'     => 'active',
            'password'  => bcrypt('devkh123'),
        ]);
    }
}
