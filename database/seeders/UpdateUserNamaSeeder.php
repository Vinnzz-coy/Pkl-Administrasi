<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserNamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            '1987654321' => 'Admin Satu',
            '1976543210' => 'Admin Dua',
            '1965432109' => 'Admin Tiga',
            '1954321098' => 'Admin Empat',
            '1943210987' => 'Admin Lima',
        ];

        foreach ($admins as $nip => $nama) {
            DB::table('users')->where('nip', $nip)->update([
                'nama' => $nama,
            ]);
        }
    }
}
