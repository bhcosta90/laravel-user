<?php

namespace BRCas\LaravelUser\Traits;

use Illuminate\Support\Facades\DB;

trait PermissionSpatieTrait
{
    public abstract function title(): string;

    public abstract function permissions(): array;

    public function up()
    {
        $tableNames = config('permission.table_names');
        $title = $this->title();

        $permissions = [];

        foreach ($this->permissions() as $permission) {

            $permissions[] = [
                'name' => "{$title} - {$permission}",
                'guard_name' => 'web',
            ];
        }

        DB::table($tableNames['permissions'])->insert($permissions);
    }

    public function down()
    {
        $tableNames = config('permission.table_names');

        DB::table($tableNames['permissions'])->whereIn('name', $this->permissions())->delete();
    }
}
