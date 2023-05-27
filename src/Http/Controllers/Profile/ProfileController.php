<?php

namespace BRCas\LaravelUser\Http\Controllers\Profile;

use BRCas\Laravel\Abstracts\Traits\PostTrait;
use BRCas\Laravel\Support\FormSupport;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\LaravelUser\Forms\Profile\PasswordForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProfileController extends BaseController
{
    use PostTrait, AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, FormSupport $formSupport)
    {
        $obj = $request->user();

        $form = $formSupport->run(
            $this->createForm(),
            route(RouteSupport::getRouteActual() . '.store'),
            $request->user(),
            ['method' => 'post', 'submit' => config('bhcosta90-user.profile.save')]
        );

        $password = $formSupport->run(
            $this->passwordForm(),
            route(RouteSupport::getRouteActual() . '.password'),
            null,
            ['method' => 'post', 'submit' => 'Atualizar minha senha']
        );

        return view('bhcosta90-user::profile.index', compact('obj', 'form', 'password'));
    }

    public function store()
    {
        return $this->executePost("create", "update", config('bhcosta90-user.profile.message.update'));
    }

    public function password()
    {
        return $this->executePost("password", "updatePassword", config('bhcosta90-user.profile.message.password'));
    }

    protected function createForm()
    {
        return config('bhcosta90-user.profile.form');
    }

    protected function passwordForm()
    {
        return PasswordForm::class;
    }

    protected function service()
    {
        return config('bhcosta90-user.profile.service');
    }
}
