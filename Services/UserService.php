<?php


namespace Costa\User\Services;


use Costa\Package\Services\Contracts\WebContract;
use Costa\User\Notification\UserSendPassword;
use Costa\User\Repositories\Contracts\UserContract;
use Costa\User\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService implements WebContract, Contracts\UserContract
{
    private UserRepository $repository;
    private Request $request;

    /**
     * UserService constructor.
     * @param UserContract $repository
     * @param Request $request
     */
    public function __construct(UserContract $repository, Request $request)
    {
        /**
         * @var $repository UserRepository
         */
        $this->repository = $repository;
        $this->request = $request;
    }

    public function webIndex($filter): array
    {
        $this->repository->orderBy('name', 'asc');

        if (isset($filter['name'])) {
            $this->repository->where('name', $filter['name']);
        }

        if (isset($filter['email'])) {
            $this->repository->where('email', $filter['email']);
        }

        return [
            'data' => $this->repository->paginate(),
            'filter' => $filter,
        ];
    }

    public function find($id)
    {
        return $this->repository->getById($id);
    }

    public function webDestroy($id, $nameRoute = null)
    {
        $this->repository->deleteById($id);
        return redirect()->route($nameRoute . '.index')
            ->withSuccess(__('Usuário deletado com sucesso'));
    }

    public function webUpdate($id, $data, $nameRoute)
    {
        if ($data['password_updated'] && self::canUpdatePassword()) {
            $data['password'] = Hash::make($data['password_updated']);
        }
        $obj = $this->repository->updateById($id, $data);

        if(!empty($data['send'])){
            $this->sendPassword($obj, $data['password_updated'], false);
        }

        return redirect()->route($nameRoute . '.index')
            ->withSuccess(__('Usuário editado com sucesso'));
    }

    public function webStore($data, $nameRoute)
    {
        $this->addPasswordInArray($data);
        $obj = $this->repository->create($data);

        if(!empty($data['send'])){
            $this->sendPassword($obj, $data['password_old'], true);
        }
        return redirect()->route($nameRoute . '.index')
            ->withSuccess(__('Usuário cadastrado com sucesso e a senha do usuário é: <b>:password</b>', [
                'password' => $data['password_old'],
            ]));
    }

    public function sendPassword($obj, $password, bool $isNew): void{
        Notification::send($obj, new UserSendPassword($password, $isNew));
    }

    private function addPasswordInArray(&$data)
    {
        $data['password'] = Hash::make($password = Str::random(10));
        $data['password_old'] = $password;
        return $data;
    }

    public function canUpdatePassword(): bool
    {
        return app()->isLocal()
            || (
                auth()->user()
                && in_array(auth()->user()->email, config('costa_user.permissions.email_reset_password'))
            );
    }

    public function getPermissions($obj): array
    {
        $objPermission = Permission::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            list($module, $permission) = explode('|', $rs->name);
            $permissions[trim($module)][$rs->id] = __(trim($permission));
        }

        return $permissions;
    }

    public function getRoles($obj): array
    {
        $objPermission = Role::all();
        $permissions = [];

        foreach ($objPermission as $rs) {
            $permissions[$rs->id] = __($rs->name);
        }

        return $permissions;
    }

    public function updateMyProfile($id, $data, $nameRoute): RedirectResponse
    {
        $this->repository->updateById($id, $data);
        return redirect()->route($nameRoute . '.index')->with('profile_success', __('Profile updated successfully'));
    }

    public function updateMyPassword($id, $password, $nameRoute): RedirectResponse
    {
        $this->repository->updateById($id, [
            'password' => Hash::make($password),
        ]);
        return redirect()->route($nameRoute . '.index')->with('password_success', __('Password updated successfully'));
    }

    public function loginFailed($password, $hashPassword): bool
    {
        return !$this->loginSuccess($password, $hashPassword);
    }

    public function loginSuccess($password, $hashPassword): bool
    {
        return Hash::check($password, $hashPassword);
    }


}
