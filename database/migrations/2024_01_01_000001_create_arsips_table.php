<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_definitif')->nullable();
            $table->string('nomor_sementara')->nullable();
            $table->string('seri')->nullable();
            $table->string('masalah')->nullable();
            $table->string('kode_klasifikasi')->nullable();
            $table->string('tingkat_perkembangan')->nullable();
            $table->text('isi_informasi')->nullable();
            $table->date('tanggal_terhitung')->nullable();
            $table->date('tanggal_termuda')->nullable();
            $table->string('kondisi')->default('Baik');
            $table->string('jumlah')->nullable();

            // Indexes
            $table->string('indeks_nama')->nullable();
            $table->string('indeks_tempat')->nullable();
            $table->string('indeks_masalah')->nullable();
            $table->string('daftar_singkatan')->nullable();
            $table->string('kepanjangan_singkatan')->nullable();
            $table->string('daftar_istilah')->nullable();
            $table->text('arti_istilah')->nullable();

            // File
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();

            // Meta
            $table->string('kategori')->nullable();
            $table->enum('status', ['active', 'archived', 'pending'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
