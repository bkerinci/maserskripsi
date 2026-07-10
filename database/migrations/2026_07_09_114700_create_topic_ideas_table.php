<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('input_minat')->nullable();
            $table->string('input_lokasi')->nullable();
            $table->string('input_bidang')->nullable();
            $table->json('results')->nullable(); // Menyimpan array JSON respons Gemini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_ideas');
    }
};
