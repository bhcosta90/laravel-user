<?php

namespace BRCas\LaravelUser\View\Components;

use Illuminate\View\Component;

class PermissionComponent extends Component
{
    public function __construct(
        public string $model,
        public bool $fieldset = false,
        public array $permissions = [],
        public array $myPermissions = [],
        public string $name = "",
        public ?string $save = null,
    ) {
        //
    }

    public function render()
    {
        return view('bhcosta90-user::components.permission');
    }
}
