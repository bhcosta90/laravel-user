<?php

namespace Costa\User\Http\Controllers;

use Costa\Package\Traits\Controller\BaseController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseControllerLaravel;
use Kris\LaravelFormBuilder\FormBuilder;

class ProfileController extends BaseControllerLaravel
{
    use BaseController;

    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create($this->form());
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();

        $service = app($this->service());

        $objUser = auth()->user();

        if ($service->loginFailed($data['password'], $objUser->password)) {
            return redirect()
                ->route($this->getNameRoute() . '.index')
                ->with('profile_error', __('Credentials incorrect'));
        }

        unset($data['password']);
        return $service->updateMyProfile($objUser->id, $data, $this->getNameRoute());
    }

    protected function service()
    {
        return config('costa_user.services.user');
    }

    public function password(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(config('costa_user.forms.password'));
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();

        $service = app($this->service());

        $objUser = auth()->user();

        if ($service->loginFailed($data['password_actual'], $objUser->password)) {
            return redirect()
                ->route($this->getNameRoute() . '.index')
                ->with('password_error', __('Credentials incorrect'));
        }

        return $service->updateMyPassword($objUser->id, $data['password_new'], $this->getNameRoute());
    }

    protected function index(Request $request)
    {
        $model = $request->user();

        $formBuilder = app(FormBuilder::class);

        $form = $formBuilder->create($this->form(), [
            'method' => 'POST',
            'model' => $model,
            'attr' => [
                'id' => 'formDefault'
            ],
            'url' => route($this->getNameRoute() . '.store'),
        ])->add('btn', 'submit', [
            "attr" => [
                'class' => 'btn btn-primary',
                'id' => 'btnForm'
            ],
            'label' => __('Edit')
        ]);

        $formPassword = $formBuilder->create(config('costa_user.forms.password'), [
            'method' => 'POST',
            'model' => $model,
            'attr' => [
                'id' => 'formDefault'
            ],
            'url' => route($this->getNameRoute() . '.password'),
        ])->add('btn', 'submit', [
            "attr" => [
                'class' => 'btn btn-primary',
                'id' => 'btnForm'
            ],
            'label' => __('Edit')
        ]);

        return view(
            $this->getNameView(),
            compact('form', 'formPassword') + ['route_name' => $this->getNameRoute()]
        );
    }

    public function form(): string
    {
        return config('costa_user.forms.profile');
    }

    protected function getNameView(): string
    {
        return 'costa_user::user.profile.' . $this->getActionName();
    }
}
