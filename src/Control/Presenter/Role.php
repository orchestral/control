<?php namespace Orchestra\Control\Presenter;

use Orchestra\Support\Facades\Form;
use Orchestra\Support\Facades\HTML;
use Orchestra\Support\Facades\Table;
use Orchestra\Model\Role as Eloquent;
use Orchestra\Html\Table\TableBuilder;
use Illuminate\Support\Facades\Config;

class Role extends Presenter
{
    /**
     * View table generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role|\Illuminate\Pagination\Paginator  $model
     * @return \Orchestra\Html\Table\TableBuilder
     */
    public function table($model)
    {
        return Table::of('control.roles', function ($table) use ($model) {
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
     * @param  \Orchestra\Html\Table\TableBuilder   $table
     * @return \Orchestra\Html\Table\TableBuilder
     */
    public function actions(TableBuilder $table)
    {
        return $table->extend(function ($table) {
            $table->column('action')
                ->label('')
                ->escape(false)
                ->attributes(function () {
                    return ['class' => 'th-action'];
                })
                ->value(function ($row) {
                    $html = [
                        HTML::link(
                            handles("orchestra/foundation::resources/control.roles/{$row->id}/edit"),
                            trans('orchestra/foundation::label.edit'),
                            ['class' => 'btn btn-mini btn-warning']
                        )
                    ];

                    $roles = [
                        (int) Config::get('orchestra/foundation::roles.admin'),
                        (int) Config::get('orchestra/foundation::roles.member'),
                    ];

                    if (! in_array((int) $row->id, $roles)) {
                        $html[] = HTML::link(
                            handles("orchestra/foundation::resources/control.roles/{$row->id}/delete"),
                            trans('orchestra/foundation::label.delete'),
                            ['class' => 'btn btn-mini btn-danger']
                        );
                    }

                    return HTML::create('div', HTML::raw(implode('', $html)), ['class' => 'btn-group']);
                });
        });
    }

    /**
     * View form generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role    $model
     * @return \Orchestra\Html\Form\FormBuilder
     */
    public function form(Eloquent $model)
    {
        return Form::of('control.roles', function ($form) use ($model) {
            $form->resource($this, 'control.roles', $model);
            $form->hidden('id');

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label(trans('orchestra/control::label.name'));
            });
        });
    }
}
