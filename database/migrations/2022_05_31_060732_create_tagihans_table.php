<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('noinvoice');
            $table->string('tgl_invoice');
            $table->double('biaya', 20, 2)->nullable();
            $table->double('biaya_investor', 20, 2)->nullable();
            $table->double('biaya_danlap', 20, 2)->nullable();
            $table->double('biaya_bbmtol', 20, 2)->nullable();
            $table->double('biaya_driver', 20, 2)->nullable();
            $table->double('sisa_biaya', 20, 2)->nullable();
            $table->integer('hari')->nullable();
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
        Schema::dropIfExists('tagihans');
    }
}
