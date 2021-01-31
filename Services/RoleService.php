<?php


namespace Costa\User\Services;


use Costa\Package\Services\Contracts\WebContract;
use Costa\User\Repositories\Contracts\RoleContract;
use Costa\User\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleService implements WebContract
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

    public function find($id)
    {
        return $this->roleContract->getByColumn($id, config('costa_user.router.role'));
    }

    public function index($params): array
    {
        $this->roleContract->orderBy('name', 'asc');
        if (isset($params['name'])) {
            $this->roleContract->where('name', $params['name']);
        }

        return [
            'data' => $this->roleContract->paginate(),
        ];
    }

    public function destroy($id)
    {
        $this->roleContract->where(config('costa_user.router.role'), $id)->delete($id);
        return redirect()->route($nameRoute . ".index");
    }

    public function update($id, $data)
    {
        $obj = $this->roleContract->updateById($this->find($id)->id, $data);
        $obj->syncPermissions($data['permissions'] ?? []);
    }

    public function store($data)
    {
        $obj = $this->roleContract->create($data);
        $obj->syncPermissions($data['permissions'] ?? []);
    }



//    public function all()
//    {
//        return (new RoleTable())->setup();
//    }
//
//    public function show($id)
//    {
//        return $this->roleContract->getByColumn($id, config('costa_user.router.role'));
//    }
//
//    public function create(array $data)
//    {
//        $obj = $this->roleContract->create($data);
//        $obj->syncPermissions($data['permissions']);
//    }
//
//    public function update($id, $data)
//    {
//        $obj = $this->show($id);
//        $this->roleContract->updateById($obj->id, $data);
//        $obj->syncPermissions($data['permissions']);
//    }
//
//    public function delete($id)
//    {
//        // TODO: Implement delete() method.
//    }

}
