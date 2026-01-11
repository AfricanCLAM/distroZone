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
        Schema::create('kaos', function (Blueprint $table) {
            $table->integer('id_kaos')->autoIncrement();

            $table->string('merek', 255)->nullable();

            $table->enum('tipe', [
                'Lengan Panjang',
                'Lengan Pendek'
            ]);

            $table->string('warna_kaos', 255)->nullable();

            $table->string('harga_jual', 255)->nullable();
            $table->string('harga_pokok', 255)->nullable();
            $table->string('stok_kaos', 255)->nullable();
            $table->string('foto_kaos', 255)->nullable();

            $table->enum('ukuran', [
                'XS',
                'S',
                'M',
                'L',
                'XL',
                '2XL',
                '3XL',
                '4XL',
                '5XL'
            ]);

            $table->string('tID', 255)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaos');
    }
};
