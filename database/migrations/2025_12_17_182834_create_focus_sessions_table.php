<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('focus_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke User
            $table->string('task')->nullable();     // Nama tugas (bisa kosong)
            $table->integer('duration');            // Durasi dalam menit
            $table->string('mode');                 // 'focus', 'short', 'long'
            $table->timestamps();                   // created_at (otomatis jadi tanggal)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('focus_sessions');
    }
};
