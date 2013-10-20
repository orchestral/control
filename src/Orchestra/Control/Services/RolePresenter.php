<?php namespace Orchestra\Control\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\HTML;
use Orchestra\Support\Facades\Form;
use Orchestra\Support\Facades\Table;

class RolePresenter
{
    /**
     * View table generator for Orchestra\Model\Role.
     *
     * @static
     * @access public
     * @param  Orchestra\Model\Role $model
     * @return Orchestra\Html\Table\TableBuilder
     */
    public static function table($model)
    {
        return Table::of('control.roles', function ($table) use ($model) {
            // attach Model and set pagination option to true
            $table->with($model);
            $table->layout('orchestra/foundation::components.table');

            // Add columns
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
     * @static
     * @access public
     * @param  Orchestra\Model\Role $model
     * @param  string               $type
     * @return Orchestra\Html\Form\FormBuilder
     */
    public static function form($model, $type = 'create')
    {
        return Form::of('control.roles', function ($form) use ($model, $type) {
            $form->row($model);
            $form->layout('orchestra/foundation::components.form');

            $url    = "orchestra/foundation::resources/control.roles";
            $method = 'POST';

            if ($type === 'update') {
                $url    = "orchestra/foundation::resources/control.roles/{$model->id}";
                $method = 'PUT';
            }

            $form->attributes(array(
                'url'    => handles($url),
                'method' => $method,
            ));

            $form->hidden('id');

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name', function ($control) {
                    $control->label(trans('orchestra/control::label.name'));
                });
            });
        });
    }
}
