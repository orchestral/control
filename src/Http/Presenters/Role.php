<?php

namespace Orchestra\Control\Http\Presenters;

use Illuminate\Contracts\Config\Repository;
use Orchestra\Contracts\Html\Form\Factory as FormFactory;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Builder as TableBuilder;
use Orchestra\Contracts\Html\Table\Factory as TableFactory;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Html\Form\Fieldset;
use Orchestra\Model\Role as Eloquent;

class Role extends Presenter
{
    /**
     * Implement of config contract.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new Role presenter.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Orchestra\Contracts\Html\Form\Factory  $form
     * @param  \Orchestra\Contracts\Html\Table\Factory  $table
     */
    public function __construct(Repository $config, FormFactory $form, TableFactory $table)
    {
        $this->config = $config;
        $this->form = $form;
        $this->table = $table;
    }

    /**
     * View table generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role|\Illuminate\Pagination\Paginator  $model
     *
     * @return \Orchestra\Contracts\Html\Table\Builder
     */
    public function table($model)
    {
        return $this->table->of('control.roles', function (TableGrid $table) use ($model) {
            // attach Model and set pagination option to true.
            $table->with($model)->paginate(true);

            $table->sortable();
            $table->searchable(['name']);

            $table->layout('orchestra/foundation::components.table');

            // Add columns.
            $table->column(trans('orchestra/foundation::label.name'), 'name');
        });
    }

    /**
     * Table actions View Generator for Orchestra\Model\User.
     *
     * @param  \Orchestra\Contracts\Html\Table\Builder  $table
     *
     * @return \Orchestra\Contracts\Html\Table\Builder
     */
    public function actions(TableBuilder $table)
    {
        return $table->extend(function (TableGrid $table) {
            $table->column('action')
                ->label('')
                ->escape(false)
                ->attributes(function () {
                    return ['class' => 'th-action'];
                })
                ->value(function ($row) {
                    $html = [$this->addEditButton($row)];

                    $roles = [
                        (int) $this->config->get('orchestra/foundation::roles.admin'),
                        (int) $this->config->get('orchestra/foundation::roles.member'),
                    ];

                    if (! in_array((int) $row->id, $roles)) {
                        $html[] = $this->addDeleteButton($row);
                    }

                    return app('html')->create('div', app('html')->raw(implode('', $html)), ['class' => 'btn-group']);
                });
        });
    }

    /**
     * Add edit button.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return string
     */
    protected function addEditButton(Eloquent $role)
    {
        $link = handles("orchestra::control/roles/{$role->id}/edit");
        $text = trans('orchestra/foundation::label.edit');
        $attributes = ['class' => 'btn btn-xs btn-label btn-warning'];

        return app('html')->link($link, $text, $attributes);
    }

    /**
     * Add delete button.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return string
     */
    protected function addDeleteButton(Eloquent $role)
    {
        $link = handles("orchestra::control/roles/{$role->id}");
        $text = trans('orchestra/foundation::label.delete');
        $attributes = ['class' => 'btn btn-xs btn-label btn-danger', 'data-method' => 'DELETE'];

        return app('html')->link($link, $text, $attributes);
    }

    /**
     * View form generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role  $model
     *
     * @return \Orchestra\Contracts\Html\Form\Builder
     */
    public function form(Eloquent $model)
    {
        return $this->form->of('control.roles', function (FormGrid $form) use ($model) {
            $form->resource($this, 'orchestra::control/roles', $model);
            $form->hidden('id');

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label(trans('orchestra/control::label.name'));
            });
        });
    }
}
