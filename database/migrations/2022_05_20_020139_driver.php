<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Driver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_identitas');
            $table->string('no_identitas')->unique();
            $table->string('alamat');
            $table->tinyInteger('sedia_status')->default(1)->comment('1 = tersedia, 2=sedang digunakan, 3=booking, 4=tidak aktif');
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
        Schema::dropIfExists('drivers');
    }
}
