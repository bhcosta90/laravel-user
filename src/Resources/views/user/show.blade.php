@extends(config('user.layout'))

@section('content')
    <div class='card'>
        <div class='card-header'>{{ $obj->name }}</div>
        <table class='table table-striped'>
            <tr>
                <td style='width: 50%'>{{ __('Email') }}</td>
                <td style='width: 50%'><a href='mailto:{{ $obj->email }}'>{{ $obj->email }}</a></td>
            </tr>

            <tr>
                <td style='width: 50%'>{{ __('user::message.Date Created') }}</td>
                <td style='width: 50%'>{{ $obj->created_at->format('d/m/Y H:i') }}</td>
            </tr>

            <tr>
                <td style='width: 50%'>{{ __('user::message.Date Updated') }}</td>
                <td style='width: 50%'>{{ $obj->updated_at->format('d/m/Y H:i') }}</td>
            </tr>

            @if($obj->last_login)
                <tr>
                    <td style='width: 50%'>{{ __('user::message.Last Login') }}</td>
                    <td style='width: 50%'>{{ $obj->last_login ? (new \Carbon\Carbon($obj->last_login))->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @endif
        </table>
    </div>
@endsection