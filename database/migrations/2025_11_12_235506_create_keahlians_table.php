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
        Schema::create('keahlians', function (Blueprint $table) {
            $table->id(); // Ini akan membuat 'id' auto-increment
            $table->string('nama'); // Kolom untuk 'nama'
            $table->string('keahlian'); // Kolom untuk 'keahlian'
            $table->string('foto')->nullable(); // Kolom untuk 'foto', boleh kosong
            $table->timestamps(); // Ini membuat 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keahlians');
    }
};
