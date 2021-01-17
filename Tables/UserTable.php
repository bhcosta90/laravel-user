<?php

namespace Costa\User\Tables;

use App\Models\User;
use ErrorException;
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
        $route = [
            'index' => ['name' => 'admin.user.user.index'],
            'show' => ['name' => 'admin.user.user.show'],
            'create' => ['name' => 'admin.user.user.create'],
            'edit' => ['name' => 'admin.user.user.edit'],
            'destroy' => ['name' => 'admin.user.user.destroy'],
        ];

        if (config('costa_user.permissions.edit')
            && !auth()->user()->can(config('costa_user.permissions.edit'))
        ) {
            unset($route['edit']);
        }

        if (config('costa_user.permissions.destroy')
            && !auth()->user()->can(config('costa_user.permissions.destroy'))
        ) {
            unset($route['destroy']);
        }

        if (config('costa_user.permissions.show')
            && !auth()->user()->can(config('costa_user.permissions.show'))
        ) {
            unset($route['show']);
        }

        if (config('costa_user.permissions.create')
            && !auth()->user()->can(config('costa_user.permissions.create'))
        ) {
            unset($route['create']);
        }

        return (new Table())->model(User::class)
            ->routes($route)
            ->destroyConfirmationHtmlAttributes(fn(User $user) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $user->database_attribute . ' ?'),
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
