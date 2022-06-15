<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('jenis_paket_id');
            $table->unsignedBigInteger('biaya_mobil_id');
            $table->unsignedBigInteger('mobil_id');
            $table->dateTime('awal_sewa');
            $table->dateTime('akhir_sewa');
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->string('noinvoice')->nullable();
            $table->integer('hari')->nullable();
            $table->double('biaya', 20, 2)->nullable();
            $table->double('biaya_investor', 20, 2)->nullable();
            $table->double('biaya_danlap', 20, 2)->nullable();
            $table->double('biaya_adm', 20, 2)->nullable();
            $table->double('biaya_bbmtol', 20, 2)->nullable();
            $table->double('biaya_driver', 20, 2)->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('file_tagihan')->nullable();
            $table->double('sisa_tagihan', 20, 2)->nullable();
            $table->tinyInteger('status_tagihan')->default(1)->comment('1 = belum dibayar,2=Lunas, 3=Sebagian');
            $table->tinyInteger('booking_status')->default(1)->comment('1 = book, 2=sedang berjalan, 3=selesai, 4=batal');
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
        Schema::dropIfExists('bookings');
    }
}
