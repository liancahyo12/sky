<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('mobil_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('noinvoice')->nullable();
            $table->double('biaya', 20, 2)->nullable();
            $table->tinyInteger('status_biaya')->nullable()->comment('1 = belum lunas, 2=Lunas, 3=Sebagian');
            $table->double('biaya_investor', 20, 2)->nullable();
            $table->double('biaya_danlap', 20, 2)->nullable();
            $table->double('biaya_adm', 20, 2)->nullable();
            $table->double('biaya_bbmtol', 20, 2)->nullable();
            $table->double('biaya_driver', 20, 2)->nullable();
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
        Schema::dropIfExists('transaksis');
    }
}
