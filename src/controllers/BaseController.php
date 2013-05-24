<?php namespace Orchestra\Control\Routing;

use Illuminate\Routing\Controllers\Controller;

abstract class BaseController extends Controller {
	
	/**
	 * Define the filters.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('orchestra.manage:users');
	}
}
