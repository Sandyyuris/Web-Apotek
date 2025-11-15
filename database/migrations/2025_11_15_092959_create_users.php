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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_users');
            $table->unsignedBigInteger('id_role')->nullable(); // Kolom FK

            $table->string('name');
            $table->string('username')->unique(); // Unique dan bukan email
            $table->string('password');

            $table->timestamps();

            // Definisi Foreign Key (Langsung dalam create table)
            $table->foreign('id_role')
            ->references('id_role')
            ->on('roles')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
