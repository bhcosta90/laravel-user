<?php

namespace Costa\User\Http\Controllers;

use App\Exceptions\WebException;
use Costa\Package\Exceptions\CustomException;
use Costa\Package\Traits\HasPermission;
use Costa\Package\Util\ExecuteAction;
use Costa\Package\Traits\Controllers\{CreateTrait, DestroyTrait, EditTrait, IndexTrait, ShowTrait};
use Costa\User\Services\Contracts\UserContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use IndexTrait, ShowTrait, CreateTrait, EditTrait, DestroyTrait, HasPermission;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|object
     * @throws WebException
     * @throws CustomException
     */
    public function store(Request $request)
    {
        $request->request->add(['password' => $password = Str::random(10)]);

        return (new ExecuteAction)->setForm($this->form())
            ->setFunction($this->functionStore() ?: $this->getNameFunction())
            ->setRequest($request)
            ->setService($this->service())
            ->setSession(
                'success',
                __('Usuário criado com sucesso, a senha do usuário é: <strong>:password</strong>', [
                'password' => $password
                ])
            )
            ->setNameRoute($this->getNameRoute())
            ->exec();
    }

    public function verifyContract(): string
    {
        return UserContract::class;
    }

    public function service(): string
    {
        return config('costa_user.services.user');
    }

    public function resource(): string
    {
        return config('costa_user.resources.user');
    }

    public function form(): string
    {
        return config('costa_user.forms.user');
    }

    public function functionIndex(): string
    {
        return 'all';
    }

    public function functionEdit(): string
    {
        return 'show';
    }

    public function functionShow(): string
    {
        return 'show';
    }

    public function functionUpdate(): string
    {
        return 'update';
    }

    public function functionStore(): string
    {
        return 'create';
    }

    public function functionDestroy(): string
    {
        return 'delete';
    }

    public function getView(): string
    {
        return 'costa_user::user';
    }

    protected function permissions()
    {
        return config('costa_user.permissions.user');
    }
}
