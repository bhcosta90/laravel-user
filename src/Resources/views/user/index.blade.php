@extends(config('user.layout'))

@section('content')
    @if(!empty($filter))
        <div class='card'>
            <div class='card-header'>
                <div class='float-left'>{{ __('user::message.Filter User Report') }}</div>
                <div class='float-right'>
                    <a href='javascript:void(1)' 
                        onclick='console.log($(this).parent().parent().parent().find(".card-body").slideToggle())' 
                        class='btn btn-secondary btn-sm'>
                        <i class="fas fa-caret-down"></i>
                    </a>
                </div>
            </div>
            <form class='card-body' style='display:none'>
                @foreach ($filter as $key => $value)
                    @if(substr($key, 0, 7) == 'request')
                        {!! Form::hidden(substr($key, 8), request(substr($key, 8)), ['class' => 'form-control m-input']) !!}
                    @else
                    <div class='form-group'>
                        {!! Form::label($key, __($value)) !!}
                        {!! Form::text($key, request($key), ['class' => 'form-control m-input']) !!}
                    </div>
                    @endif
                @endforeach
                <button class='btn btn-primary'>{!! __('user::message.Filter') !!}</button>
            </form>
        </div>
    @endif

    <div class='card'>
        <div class='card-header'>
            <div class='float-left'>{{ __('user::message.User Report') }}</div>
            @empty(!$linkRegister)
                <div class='float-right'><a href="{{ $linkRegister }}" class='btn btn-light'>{{__('user::message.New Register')}}</a></div>
            @endif
        </div>
        @include('package::table')
    </div>
@endsection