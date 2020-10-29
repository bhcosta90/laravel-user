@extends(config('user.layout'))

@section('content')
    <div class='card'>
        <div class='card-header'>{{ __('user::message.My Profile') }}</div>
        <div class="card-body">
            {!! form($formProfile) !!}
            @if (Session::has('profile_success') && Session::get("profile_success"))
                <div class="alert alert-success mt-3 text-center" role="alert">
                    {{ Session::get("profile_success") }}
                </div>
            @endif
        </div>
    </div>

    <div class='card'>
        <div class='card-header'>{{ __('user::message.Update Password') }}</div>
        <div class="card-body">
            {!! form($formPassword) !!}
            @if (Session::has('password_success') && Session::get("password_success"))
                <div class="alert alert-success mt-3 text-center" role="alert">
                    {{ Session::get("password_success") }}
                </div>
            @endif
        </div>
    </div>
@endsection
