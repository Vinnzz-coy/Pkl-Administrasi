<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nip')->unique();
            $table->string('password');
            $table->timestamps();
        });

        $admins = [
            '1987654321',
            '1976543210',
            '1965432109',
            '1954321098',
            '1943210987',
        ];

        foreach ($admins as $nip) {
            DB::table('users')->insert([
                'nip'        => $nip,
                'password'   => Hash::make($nip),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
