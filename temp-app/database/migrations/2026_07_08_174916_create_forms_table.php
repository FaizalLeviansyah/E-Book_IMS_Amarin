<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('forms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // Terkait ke buku mana
        $table->string('title'); // Contoh: "Visitor Boarding Request Form"
        $table->string('file_path'); // Path file PDF/Word mentahan
        $table->string('file_type'); // 'pdf' atau 'word'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
