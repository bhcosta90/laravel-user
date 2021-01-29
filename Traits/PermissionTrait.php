<?php


namespace Costa\User\Traits;


use Illuminate\Support\Facades\DB;

trait PermissionTrait
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
            $permissions[] = [
                'name' => $permission,
                'guard_name' => $this->guardName(),
            ];
        }

        DB::table($tableNames['permissions'])->insert($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');
        DB::table($tableNames['permissions'])
            ->whereIn('name', $this->permissions())
            ->where('guard_name', $this->guardName())
            ->delete();
    }

    protected function guardName(): string
    {
        return 'web';
    }

    protected abstract function permissions(): array;
}
