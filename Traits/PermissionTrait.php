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
        DB::beginTransaction();
        foreach ($this->permissions() as $permission) {
            $obj = app(config('costa_user.models.permission'));
            $obj->name = $permission;
            $obj->guard_name = $this->guardName();
            $obj->save();
        }
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $obj = app(config('costa_user.models.role'));
        $obj->whereIn('name', $this->permissions())->where('guard_name', $this->guardName())->delete();
    }

    protected function guardName(): string
    {
        return 'web';
    }

    protected abstract function permissions(): array;
}
