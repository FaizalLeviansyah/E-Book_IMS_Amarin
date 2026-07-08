<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('theme_color')->default('#0d47a1');
            $table->string('cover_image')->nullable(); // Penampung file gambar cover
            $table->string('pdf_file')->nullable();    // Penampung file PDF mentahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
