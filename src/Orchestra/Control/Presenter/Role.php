<?php namespace Orchestra\Control\Presenter;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\HTML;
use Orchestra\Support\Facades\Form;
use Orchestra\Support\Facades\Table;
use Orchestra\Model\Role as Eloquent;

class Role extends AbstractablePresenter
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
            $table->with($model);
            $table->layout('orchestra/foundation::components.table');

            // Add columns.
            $table->column(trans('orchestra/foundation::label.name'), 'name');
            $table->column('action', function ($column) {
                $column->label('');
                $column->escape(false);
                $column->attributes(function () {
                    return array('class' => 'th-action');
                });

                $column->value(function ($row) {
                    $html = array(
                        HTML::link(
                            handles("orchestra/foundation::resources/control.roles/{$row->id}/edit"),
                            trans('orchestra/foundation::label.edit'),
                            array('class' => 'btn btn-mini btn-warning')
                        )
                    );

                    $roles = array(
                        (int) Config::get('orchestra/foundation::roles.admin'),
                        (int) Config::get('orchestra/foundation::roles.member'),
                    );

                    if (! in_array((int) $row->id, $roles)) {
                        $html[] = HTML::link(
                            handles("orchestra/foundation::resources/control.roles/{$row->id}/delete"),
                            trans('orchestra/foundation::label.delete'),
                            array('class' => 'btn btn-mini btn-danger')
                        );
                    }

                    return HTML::create('div', HTML::raw(implode('', $html)), array('class' => 'btn-group'));
                });
            });
        });
    }

    /**
     * View form generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role    $model
     * @return Orchestra\Html\Form\FormBuilder
     */
    public function form(Eloquent $model)
    {
        return Form::of('control.roles', function ($form) use ($model) {
            $form->resource($this, 'control.roles', $model);
            $form->hidden('id');

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name', function ($control) {
                    $control->label(trans('orchestra/control::label.name'));
                });
            });
        });
    }
}
