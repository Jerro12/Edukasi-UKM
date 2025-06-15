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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materi_edukasis')->onDelete('cascade');
            $table->string('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c')->nullable();
            $table->string('opsi_d')->nullable();
            $table->enum('jawaban_benar', ['A', 'B', 'C', 'D']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};