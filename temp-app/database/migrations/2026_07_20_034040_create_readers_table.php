<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('readers', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->string('device_name')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('custom_name')->nullable(); // Nama yang akan diisi Admin
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('readers');
    }
};
