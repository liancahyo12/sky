<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('mobil')->nullable();
            $table->string('tipe');
            $table->string('merek');
            $table->string('plat')->unique();
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
        Schema::dropIfExists('mobils');
    }
}
