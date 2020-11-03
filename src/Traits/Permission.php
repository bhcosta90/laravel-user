<?php

namespace BRCas\User\Traits;

use Illuminate\Support\Facades\DB;

trait Permission
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        $permissions = [];

        foreach ($this->permissions() as $permission) {
            // DB::table($tableNames['permissions'])->insert([
            //     'name' => $permission,
            //     'guard_name' => 'web',
            // ]);

            $permissions[] = [
                'name' => $permission,
                'guard_name' => 'web',
            ];
        }

        DB::table($tableNames['permissions'])->insert($permissions);
    }

    public abstract function permissions(): array;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        DB::table($tableNames['permissions'])->whereIn('name', $this->permissions())->delete();
    }
}
