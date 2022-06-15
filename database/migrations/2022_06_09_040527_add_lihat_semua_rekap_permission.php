<?php

use Illuminate\Database\Migrations\Migration;

class AddLihatSemuaRekapPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'lihat_semua_rekap',
            'display_name' => 'lihat semua rekapitulasi',
            'description' => 'lihat semua rekapitulasi',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->where('name', 'transaksi')->first('id')->id;

        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            $permission['category_id'] = $catId;
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
