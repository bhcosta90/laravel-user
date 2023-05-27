@foreach($permissions as $groupPermission)
    @if($save)
        <form method="post" action="{{$save}}">
        @csrf
        @method('PUT')
    @endif
    <input type="hidden" name="{{$name}}name_model" value="{{base64_encode($model)}}" />
    <x-card>
        <x-card-header :title="$groupPermission['title']" :register="$save" type-register="submit" text-register="Vincular permissões" />
        <x-card-body>
            <div class='row'>
                @foreach($groupPermission['permissions'] as $id => $permission)
                    <input type="hidden" name="{{$name}}group" value="{{$groupPermission['title']}}" />
                    <div class='pull-left float-left ml-3'>
                        <div class="icheck-primary" title="{{ $permission }}">
                            <input
                                @if(in_array($id, $myPermissions))
                                    checked
                                @endif
                                type="checkbox"
                                value="{{$id}}"
                                name="{{$name}}permission[{{$groupPermission['title']}}][{{$id}}]" id="{{sha1($name.$id)}}"
                            />
                            <label for="{{sha1($name.$id)}}">
                                {{ __($permission) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card-body>
    </x-card>
    @if($save)
        </form>
    @endif
@endforeach
