@foreach($permissions as $groupPermission)
    @if($save)
        <form method="post" action="{{$save}}">
        @csrf
        @method('PUT')
    @endif
    <input type="hidden" name="{{$name}}name_model" value="{{base64_encode($model)}}" />
    @if(empty($fieldset))
    <x-card>
        <x-card-header :title="$groupPermission['title']" :register="$save" type-register="submit" modal-close="0" text-register="Vincular permissões" />
        <x-card-body>
            <div class='row'>
                @foreach($groupPermission['permissions'] as $id => $permission)
                    <input type="hidden" name="{{$name}}group" value="{{$groupPermission['title']}}" />
                    <div class='pull-left float-left ml-3'>
                        <div class="icheck-primary" title="{{ $permission }}">
                            <label>
                                <input
                                    @if(in_array($id, $myPermissions))
                                        checked
                                    @endif
                                    type="checkbox"
                                    value="{{$id}}"
                                    name="{{$name}}permission[{{$groupPermission['title']}}][{{$id}}]"
                                />

                                {{ __($permission) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card-body>
    </x-card>
    @else
    <fieldset class='card-fieldset form-group'>
        <legend>{{$groupPermission['title']}}</legend>
        @foreach($groupPermission['permissions'] as $id => $permission)
            <input type="hidden" name="{{$name}}group" value="{{$groupPermission['title']}}" />
            <div class='pull-left float-left mr-3'>
                <div class="icheck-primary" title="{{ $permission }}">
                    <label>
                        <input
                            @if(in_array($id, $myPermissions))
                                checked
                            @endif
                            type="checkbox"
                            value="{{$id}}"
                            name="{{$name}}permission[{{$groupPermission['title']}}][{{$id}}]"
                        />
                        {{ __($permission) }}
                    </label>
                </div>
            </div>
        @endforeach
    </fieldset>
    @endif
    @if($save)
        </form>
    @endif
@endforeach
