<x-app-layout>
    <x-slot name="header">
        <h2 class="m-0 text-dark my-2">
            {{ __('Listagem de Grupos') }}
        </h2>

        @if(Breadcrumbs::exists($route_name . '.index'))
            {{ Breadcrumbs::render($route_name . '.index') }}
        @endif
    </x-slot>
    <div class="card card-outline card-gray">
        <div class="card-header">{{__('Meus dados')}}</div>
        <div class="card-body">
            {!! form_start($form) !!}
            <div class="row">
                <div class="col-6">
                    {!! form_row($form->name) !!}
                </div>
                <div class="col-6">
                    {!! form_row($form->email) !!}
                </div>
            </div>
            {!! form_row($form->password) !!}

            @if (Session::has('profile_success') && Session::get("profile_success"))
                <div class="alert-flash alert alert-success mt-3 text-center" role="alert">
                    {{ Session::get("profile_success") }}
                </div>
            @endif

            @if (Session::has('profile_error') && Session::get("profile_error"))
                <div class="alert-flash alert alert-default-warning mt-3 text-center" role="alert">
                    {{ Session::get("profile_error") }}
                </div>
            @endif

            {!! form_end($form) !!}
        </div>
    </div>

    <div class="card card-outline card-gray">
        <div class="card-header">{{__('Alterar minha senha')}}</div>
        <div class="card-body">
            {!! form_start($formPassword) !!}

            {!! form_row($formPassword->password_actual) !!}

            <div class="row">
                <div class="col-6">
                    {!! form_row($formPassword->password_new) !!}
                </div>
                <div class="col-6">
                    {!! form_row($formPassword->password_new_confirmation) !!}
                </div>
            </div>
            @if (Session::has('password_success') && Session::get("password_success"))
                <div class="alert-flash alert alert-success mt-3 text-center" role="alert">
                    {{ Session::get("password_success") }}
                </div>
            @endif

            @if (Session::has('password_error') && Session::get("password_error"))
                <div class="alert-flash alert alert-default-warning mt-3 text-center" role="alert">
                    {{ Session::get("password_error") }}
                </div>
            @endif

            {!! form_end($formPassword) !!}
        </div>
    </div>

</x-app-layout>
