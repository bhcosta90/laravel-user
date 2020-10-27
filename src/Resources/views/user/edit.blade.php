@extends(config('user.layout'))

@section('content')
    <div class='card'>
        <div class='card-header'>{{ __('user::message.User Edit') }}</div>
        <div class='card-body'>
            {!! form($form) !!}
        </div>
    </div>
@endsection