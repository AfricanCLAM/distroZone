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
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            $table->integer('transaksi_id');
            $table->string('id_kaos', 11);

            $table->integer('qty');
            $table->string('harga', 255)->nullable();
            $table->string('subtotal', 255)->nullable();

            $table->index('transaksi_id');
            $table->foreign('transaksi_id')
                ->references('id')
                ->on('transaksi')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
