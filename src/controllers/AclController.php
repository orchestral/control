<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;

class AclController extends BaseController {

	/**
	 * Define the filters.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('orchestra.manage:acl');
	}

	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function getIndex()
	{
		$lists    = array();
		$selected = Input::get('name', 'orchestra');
		$acls     = Acl::all();
		$active   = null;
		$memory   = App::memory();

		foreach ($acls as $name => $instance)
		{
			$extension    = $memory->get("extensions.available.{$name}.name", null);
			$lists[$name] = (is_null($extension) ? Str::title($name) : $extension);

			if ($name === $selected) $active = $instance;
		}

		if (is_null($active)) return App::abort(404);

		$data     = array(
			'eloquent' => $active,
			'lists'    => $lists,
			'selected' => $selected,
		);

		Site::set('title', trans('orchestra/control::title.acls.list'));

		return View::make('orchestra/control::acl.index', $data);
	}
}
