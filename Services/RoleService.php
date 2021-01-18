<?php


namespace Costa\User\Services;


use Costa\User\Repositories\Contracts\RoleContract;
use Costa\User\Repositories\RoleRepository;
use Costa\User\Tables\RoleTable;
use Illuminate\Http\Request;

class RoleService implements Contracts\RoleContract
{
    private RoleContract $roleContract;
    private Request $request;

    /**
     * RoleService constructor.
     * @param RoleContract $roleContract
     * @param Request $request
     */
    public function __construct(RoleContract $roleContract, Request $request)
    {
        /**
         * @var RoleRepository $roleContract
         */
        $this->roleContract = $roleContract;
        $this->request = $request;
    }


    public function all()
    {
        return (new RoleTable())->setup();
    }

    public function show($id)
    {
        return $this->roleContract->getByColumn($id, config('costa_user.router.role'));
    }

    public function create(array $data)
    {
        $obj = $this->roleContract->create($data);
        $obj->syncPermissions($data['permissions']);
    }

    public function update($id, $data)
    {
        $obj = $this->show($id);
        $this->roleContract->updateById($obj->id, $data);
        $obj->syncPermissions($data['permissions']);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

}
