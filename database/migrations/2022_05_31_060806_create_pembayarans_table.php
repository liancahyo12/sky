<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->double('pembayaran', 20, 2)->nullable();
            $table->double('biaya', 20, 2)->nullable();
            $table->double('sisa_tagihan', 20, 2)->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->tinyInteger('status_pembayaran')->default(1)->comment('1 = belum dibayar, 2=Berhasil');
            $table->tinyInteger('status_tagihan')->default(1)->comment('1 = belum dibayar,2=Lunas, 3=Sebagian');
            $table->string('keterangan')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = invalid, 1=valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
