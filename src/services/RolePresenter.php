<?php namespace Orchestra\Control\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\HTML;
use Orchestra\Support\Facades\Form;
use Orchestra\Support\Facades\Table;

class RolePresenter {
	
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
		return Table::of('control.roles', function($table) use ($model)
		{
			// attach Model and set pagination option to true
			$table->with($model);

			// Add columns
			$table->column('name', trans('orchestra::label.name'));
			$table->column('action', function ($column)
			{
				$column->label('');
				$column->escape(false);
				$column->attributes(array('class' => 'th-action'));
				$column->value(function ($row)
				{
					$html = array(
						HTML::link(
							handles("orchestra/foundation::resources/authorize.roles/{$row->id}/edit"),
							trans('orchestra::label.edit'),
							array('class' => 'btn btn-mini btn-warning')
						)
					);

					$roles = array(
						(int) Config::get('orchestra/foundation::roles.admin'),
						(int) Config::get('orchestra/foundation::roles.member'),
					);

					if ( ! in_array((int) $row->id, $roles))
					{
						$html[] = HTML::link(
							handles("orchestra/foundation::resources/authorize.roles/{$row->id}/delete"),
							trans('orchestra::label.delete'),
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
	 * @return Orchestra\Html\Form\FormBuilder
	 */
	public static function form($model)
	{
		return Form::of('control.roles', function ($form) use ($model)
		{
			$form->row($model);
			$form->attributes(array(
				'url'    => handles("orchestra/foundation::resources/authorize.roles/{$model->id}"),
				'method' => 'POST',
			));

			$form->fieldset(function ($fieldset)
			{
				$fieldset->control('input:text', 'name', function ($control)
				{
					$control->label(trans('authorize::label.name'));
				});
			});
		});
	}
}
