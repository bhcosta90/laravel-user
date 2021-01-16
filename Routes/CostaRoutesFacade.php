<?php


namespace Costa\User\Routes;


use Illuminate\Support\Facades\Facade;

class CostaRoutesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CostaRoutes::class;
    }
}
