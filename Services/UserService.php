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

    public function index($params): array
    {
        $this->repository->orderBy('name', 'asc');

        if (isset($params['name'])) {
            $this->repository->where('name', $params['name']);
        }

        if (isset($params['email'])) {
            $this->repository->where('email', $params['email']);
        }

        return [
            'data' => $this->repository->paginate(),
        ];
    }

    public function find($id)
    {
        return $this->repository->getByColumn($id, config('costa_user.router.user'));
    }

    public function destroy($id)
    {
        $this->repository->where(config('costa_user.router.user'), $id)->delete($id);
    }

    public function update($id, $data)
    {
        if ($data['password_updated'] && self::canUpdatePassword()) {
            $data['password'] = Hash::make($data['password_updated']);
        }
        $obj = $this->repository->updateById($this->find($id)->id, $data);

        if (!empty($data['send'])) {
            $this->sendPassword($obj, $data['password_updated'], false);
        }

        $this->repository->verifySpatiePermission($data);

        $obj->syncPermissions($data['permissions'] ?? []);
        $obj->syncRoles($data['roles'] ?? []);
    }

    public function store($data)
    {
        $this->addPasswordInArray($data);
        $obj = $this->repository->create($data);

        if (!empty($data['send'])) {
            $this->sendPassword($obj, $data['password_old'], true);
        }

        $this->repository->verifySpatiePermission($data);

        $obj->syncPermissions($data['permissions'] ?? []);
        $obj->syncRoles($data['roles'] ?? []);
    }

    public function sendPassword($obj, $password, bool $isNew): void
    {
        if ($password) {
            Notification::send($obj, new UserSendPassword($password, $isNew));
        }
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
