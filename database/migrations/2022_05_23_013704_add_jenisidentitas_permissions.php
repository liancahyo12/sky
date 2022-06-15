<?php

use Illuminate\Database\Migrations\Migration;

class AddJenisidentitasPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'lihat_jenisidentitas',
            'display_name' => 'lihat daftar jenis identitas',
            'description' => 'lihat daftar jenis identitas',
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
            'name' => 'jenisidentitas',
            'display_name' => 'jenis identitas',
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

        DB::table('permissions_categories')->where('name', 'jenisidentitas')->delete();
    }
}
