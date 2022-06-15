<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayaMobilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya_mobils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mobil_id');
            $table->double('biaya', 20, 2)->nullable();
            $table->double('biaya_investor', 20, 2)->nullable();
            $table->double('biaya_danlap', 20, 2)->nullable();
            $table->double('biaya_adm', 20, 2)->nullable();
            $table->double('biaya_bbmtol', 20, 2)->nullable();
            $table->double('biaya_driver', 20, 2)->nullable();
            $table->unsignedBigInteger('jenis_paket_id');
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
        Schema::dropIfExists('biaya_mobils');
    }
}
