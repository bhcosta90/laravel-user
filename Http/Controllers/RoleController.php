<?php

namespace Costa\User\Http\Controllers;

use App\Exceptions\WebException;
use Costa\Package\Exceptions\CustomException;
use Costa\Package\Traits\HasPermission;
use Costa\Package\Util\ExecuteAction;
use Costa\Package\Traits\Controllers\{CreateTrait, DestroyTrait, EditTrait, IndexTrait, ShowTrait};
use Costa\User\Services\Contracts\RoleContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    use IndexTrait, ShowTrait, CreateTrait, EditTrait, DestroyTrait, HasPermission;

    public function verifyContract(): string
    {
        return RoleContract::class;
    }

    public function service(): string
    {
        return config('costa_user.services.role');
    }

    public function resource(): string
    {
        return config('costa_user.resources.role');
    }

    public function form(): string
    {
        return config('costa_user.forms.role');
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
        return 'costa_user::role';
    }

    protected function permissions()
    {
        return config('costa_user.permissions');
    }
}
