<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\View;

class HomeController extends BaseController {
	
	/**
	 * Control dashboard.
	 *
	 * @access public
	 * @return Response
	 */
	public function getIndex()
	{
		return View::make('orchestra/control::home');
	}
}
