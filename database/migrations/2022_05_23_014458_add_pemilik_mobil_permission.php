<?php

use Illuminate\Database\Migrations\Migration;

class AddPemilikMobilPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'pemilik_mobil',
            'display_name' => 'pemilik mobil',
            'description' => 'pemilik mobil',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            DB::table('permissions')->insert($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->where('name', $permission['name'])->delete();
        }
    }
}
