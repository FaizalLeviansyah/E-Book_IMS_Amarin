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
    Schema::create('sub_chapters', function (Blueprint $table) {
        $table->id();
        // foreignId ini menghubungkan sub-bab dengan bab tertentu
        $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');
        $table->string('title');
        $table->string('slug');
        $table->longText('content')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_chapters');
    }
};
