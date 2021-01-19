<?php

namespace Costa\User\Http\Controllers;

use Costa\Package\Exceptions\CustomException;
use Costa\Package\Util\ExecuteAction;
use Costa\Package\Http\Controllers\Traits\{CreateTrait, DestroyTrait, EditTrait, IndexTrait, ShowTrait};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ProfileController extends Controller
{
    use IndexTrait, ShowTrait, CreateTrait, EditTrait, DestroyTrait;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|object
     * @throws CustomException
     * @throws CustomException
     */
    public function store(Request $request)
    {
        return (new ExecuteAction)->setForm($this->form())
            ->setFunction($this->functionStore() ?: $this->getNameFunction())
            ->setRequest($request)
            ->setService($this->service())
            ->setSession('profile_success', __('Perfil alterado com sucesso'))
            ->setNameRoute($this->getNameRoute())
            ->exec();
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
        return config('costa_user.forms.profile');
    }

    public function functionIndex(): string
    {
        return 'myProfile';
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

    public function functionStore()
    {
        return 'updateMyProfile';
    }

    public function functionDestroy()
    {
        return 'delete';
    }

    protected function getView(): ?string
    {
        return 'costa_user::profile';
    }

    protected function returnIndexAction(Model $result): array
    {
        $formBuilder = app(FormBuilder::class);

        $form = $formBuilder->create($this->form(), [
            'method' => 'POST',
            'model' => $result,
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
            'model' => $result,
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

        return [
            'form' => $form,
            'formPassword' => $formPassword,
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|object
     * @throws CustomException
     * @throws CustomException
     */
    public function password(Request $request){
        return (new ExecuteAction)
            ->setNameRoute($this->getNameRoute())
            ->setRequest($request)
            ->setService($this->service())
            ->setFunction("updateMyPassword")
            ->setForm(config('costa_user.forms.password'))
            ->setSession('password_success', __('Senha alterada com sucesso'))
            ->exec();
    }

}
