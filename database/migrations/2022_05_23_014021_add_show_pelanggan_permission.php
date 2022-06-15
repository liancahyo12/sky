<?php

use Illuminate\Database\Migrations\Migration;

class AddShowPelangganPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'show_pelanggan',
            'display_name' => 'show detail pelanggan',
            'description' => 'show detail pelanggan',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->where('name', 'pelanggan')->first('id')->id;

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
