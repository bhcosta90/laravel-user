<?php

namespace Costa\User\View\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class PaginatorComponent extends Component
{
    private LengthAwarePaginator $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('costa_user::components.paginator', [
            'total' => $this->data->total(),
            'page' => $this->data->perPage(),
            'links' => $this->data->links(),
        ]);
    }
}
