<?php

namespace Costa\User\Tables;

use ErrorException;
use Illuminate\Support\Facades\Route;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class UserTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return Table
     * @throws ErrorException
     */
    protected function table(): Table
    {
        $arrayRoute = explode('.', Route::currentRouteName());
        array_pop($arrayRoute);
        $nameRoute = implode('.', $arrayRoute);
        $route = [
            'index' => ['name' => $nameRoute . '.index'],
            'show' => ['name' => $nameRoute . '.show'],
            'create' => ['name' => $nameRoute . '.create'],
            'edit' => ['name' => $nameRoute . '.edit'],
            'destroy' => ['name' => $nameRoute . '.destroy'],
        ];

        if (config('costa_user.permissions.user.edit')
            && !auth()->user()->can(config('costa_user.permissions.user.edit'))
        ) {
            unset($route['edit']);
        }

        if (config('costa_user.permissions.user.destroy')
            && !auth()->user()->can(config('costa_user.permissions.user.destroy'))
        ) {
            unset($route['destroy']);
        }

        if (config('costa_user.permissions.user.show')
            && !auth()->user()->can(config('costa_user.permissions.user.show'))
        ) {
            unset($route['show']);
        }

        if (config('costa_user.permissions.user.create')
            && !auth()->user()->can(config('costa_user.permissions.user.create'))
        ) {
            unset($route['create']);
        }

        return (new Table())->model(config('costa_user.models.user'))
            ->routes($route)
            ->destroyConfirmationHtmlAttributes(fn($user) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $user->name . ' ?'),
            ]);
    }

    /**
     * Configure the table columns.
     *
     * @param Table $table
     *
     * @throws ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('name')
            ->title('Nome')
            ->sortable()->searchable();

        $table->column('email')
            ->title('E-mail')
            ->sortable()->searchable();
    }

    /**
     * Configure the table result lines.
     *
     * @param Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
