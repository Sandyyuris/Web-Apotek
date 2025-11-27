<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_users');
            $table->unsignedBigInteger('id_role')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nomor_telp', 15)->nullable();
            $table->timestamps();

            $table->foreign('id_role')
            ->references('id_role')
            ->on('roles')
            ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
