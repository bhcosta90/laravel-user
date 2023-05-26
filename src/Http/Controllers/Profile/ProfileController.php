<?php

namespace BRCas\LaravelUser\Http\Controllers\Profile;

use BRCas\Laravel\Support\FormSupport;
use BRCas\Laravel\Support\RouteSupport;
use BRCas\Laravel\Traits\Controller\Write\StoreTrait;
use BRCas\LaravelUser\Forms\Profile\PasswordForm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProfileController
{
    use StoreTrait;

    public $actionStore = 'update';

    public function index(Request $request, FormSupport $formSupport)
    {
        $obj = $request->user();

        $form = $formSupport->run(
            config('bhcosta90-user.profile.form'),
            route(RouteSupport::getRouteActual() . '.store'),
            $request->user(),
            ['method' => 'post', 'submit' => config('bhcosta90-user.profile.save')]
        );

        $password = $formSupport->run(
            PasswordForm::class,
            route(RouteSupport::getRouteActual() . '.password'),
            null,
            ['method' => 'post', 'submit' => 'Atualizar minha senha']
        );

        return view('bhcosta90-user::profile.index', compact('obj', 'form', 'password'));
    }

    public function password(FormSupport $formSupport, Request $request)
    {
        $action = "updatePassword";

        $objService = $this->validateService([$action]);
        $data = $request->route()->parameters() + $formSupport->data(PasswordForm::class);

        if (method_exists($this, 'addDataInStore')) {
            $data += $this->addDataInStore($request->all());
        }

        return DB::transaction(function () use ($data, $request, $objService, $action) {

            $obj = $objService->$action($data);

            $actionMessage = str()->camel("message " . $action);
            $message = __(method_exists($this, $actionMessage) ? $this->$actionMessage() : __('Successfully created'));

            if (!$request->isJson() && empty($request->get('__ajax'))) {
                session()->flash('success', $message);
                return method_exists($this, 'redirectCreate')
                    ? $this->redirectCreate($obj)
                    : redirect()->route(RouteSupport::getRouteActual() . ".index", $request->route()->parameters());
            }

            return response()->json([
                'data' => $obj,
                'msg' => $message,
            ], Response::HTTP_CREATED);
        });
    }

    public function formCreate()
    {
        return config('bhcosta90-user.profile.form');
    }

    public function service()
    {
        return config('bhcosta90-user.profile.service');
    }
}
