<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cek dulu: Jika tabel 'readers' BELUM ADA, baru buat.
        // Jika sudah ada, lewati tanpa error.
        if (!Schema::hasTable('readers')) {
            Schema::create('readers', function (Blueprint $table) {
                $table->id();
                $table->string('ip_address')->unique();
                $table->string('device_name')->nullable();
                $table->text('user_agent')->nullable();
                $table->string('custom_name')->nullable();
                $table->timestamp('last_accessed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('readers');
    }
};
