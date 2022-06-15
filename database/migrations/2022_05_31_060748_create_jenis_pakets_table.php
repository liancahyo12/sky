<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $data = [
        [
            'jenis_paket' => 'Dalam Kota',
        ],
        [
            'jenis_paket' => 'Luar Kota',
        ],
    ];

    public function up()
    {
        Schema::create('jenis_pakets', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_paket');
            $table->tinyInteger('status')->default(1)->comment('0 = invalid , 1 = valid');
            $table->timestamps();
        });

        foreach ($this->data as $data) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            DB::table('jenis_pakets')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_pakets');
    }
}
