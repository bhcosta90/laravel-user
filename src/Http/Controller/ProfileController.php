<?php


namespace BRCas\User\Http\Controller;

use BRCas\Laravel\Exceptions\CustomException;
use BRCas\Laravel\Traits\Support\Execute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Kris\LaravelFormBuilder\FormBuilder;

class ProfileController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Execute;

    public function index(FormBuilder $formBuilder)
    {
        $obj = auth()->user();

        $objUser = new \stdClass;
        $objUser->name = $obj->name;
        $objUser->email = $obj->email;

        $formPassword = $formBuilder->create(config('user.forms.password'), [
            'method' => 'POST',
            'url' => route('admin.users.profile.password'),
        ])->add('btn', 'submit', [
            "attr" => ['class' => 'btn btn-primary'],
            'label' => __('Update')
        ]);

        $formProfile = $formBuilder->create(config('user.forms.profile'), [
            'method' => 'POST',
            'url' => route('admin.users.profile.profile'),
            'model' => $objUser,
        ])->add('btn', 'submit', [
            "attr" => ['class' => 'btn btn-primary'],
            'label' => __('Update')
        ]);
        return view(config('user.views.users.profile'), compact('obj', 'formProfile', 'formPassword'));
    }

    public function profile(FormBuilder $formBuilder)
    {
        return $this->execute(function () use ($formBuilder) {
            $objForm = $formBuilder->create(config('user.forms.profile'));
            if (!$objForm->isValid()) {
                return redirect()->back()->withErrors($objForm->getErrors())->withInput();
            }

            $objService = app(config('user.services.profile'));
            $data = $objForm->getFieldValues();

            if ($this->verifyPassword($data['password']) == false)
                throw new CustomException(__('user::message.Password incorrect'));

            $objService->updateProfile($data['name'], $data['email']);

            session()->flash('profile_success', __('user::message.Profile updated with sucessfully'));

            return redirect()->route("profile");
        });
    }

    private function verifyPassword($password): bool
    {
        return Hash::check($password, auth()->user()->password);
    }

    public function password(FormBuilder $formBuilder)
    {
        return $this->execute(function () use ($formBuilder) {
            $objForm = $formBuilder->create(config('user.forms.password'));

            if (!$objForm->isValid()) {
                return redirect()->back()->withErrors($objForm->getErrors())->withInput();
            }
            $objService = app(config('user.services.profile'));
            $data = $objForm->getFieldValues();

            if ($this->verifyPassword($data['password_old']) == false)
                throw new CustomException(__('user::message.Password incorrect'));

            $objService->updatePassword($data['password']);

            session()->flash('password_success', __('user::message.Password updated with sucessfully'));

            return redirect()->route("profile");
        });
    }
}
