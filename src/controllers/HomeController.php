<?php namespace Orchestra\Control\Routing;

class HomeController extends BaseController {
	
	/**
	 * Control dashboard.
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		return View::make('orchestra/control::home');
	}
}
