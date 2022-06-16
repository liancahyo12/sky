<?php

use Illuminate\Database\Migrations\Migration;

class AddJenispaketPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'lihat_jenispaket',
            'display_name' => 'lihat jenis paket',
            'description' => 'lihat jenis paket',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->insertGetId([
            'name' => 'jenispaket',
            'display_name' => 'jenis paket',
        ]);

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

        DB::table('permissions_categories')->where('name', 'jenispaket')->delete();
    }
}
