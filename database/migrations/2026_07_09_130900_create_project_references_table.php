<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('authors')->nullable();
            $table->string('journal')->nullable();
            $table->string('year')->nullable();
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('source')->default('manual'); // manual, crossref, pdf
            $table->string('citation_format')->default('APA'); // APA, IEEE, MLA, Chicago, Vancouver
            $table->text('citation_text')->nullable();
            $table->text('pdf_extracted_text')->nullable();
            $table->text('ai_review')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_references');
    }
};
