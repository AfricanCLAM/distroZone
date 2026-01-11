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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            $table->string('no_transaksi', 20);
            $table->unsignedBigInteger('id_kasir')->nullable();

            $table->string('nama_pembeli', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_telp_pembeli', 255)->nullable();

            $table->enum('wilayah', [
                'Jakarta',
                'Depok',
                'Bekasi',
                'Tangerang',
                'Bogor',
                'Seluruh Wilayah Jawa Barat',
                'Seluruh Wilayah Jawa Tengah',
                'Seluruh Wilayah Jawa Timur'
            ])->nullable();

            $table->text('struk')->nullable();
            $table->string('metode_pembayaran', 255)->nullable();

            $table->string('total_harga', 255)->default('0');
            $table->string('ongkir', 255)->default('0');
            $table->string('pemasukan', 255)->nullable();

            $table->enum('status', [
                'pending',
                'validated',
                'rejected',
                'completed'
            ])->default('pending');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('validated_at')->nullable();

            $table->index('id_kasir');
            $table->foreign('id_kasir')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
