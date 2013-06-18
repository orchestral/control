<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;

class ThemesController extends BaseController {

	/**
	 * Show frontend/backend theme for Orchestra Platform.
	 *
	 * @access public			
	 * @param  string   $type       Type of theme either 'frontend' or 'backend'
	 * @return Response
	 */
	public function getIndex($type = 'frontend')
	{
		$current = App::memory()->get('site.theme.frontend');
		$themes  = App::make('orchestra.theme.finder')->detect();

		Site::set('title', trans('orchestra/control::title.themes.list', array(
			'type' => Str::title($type),
		)));

		return View::make('orchestra/control::themes', compact('themes', 'type', 'current'));
	}

	/**
	 * Set active theme for Orchestra Platform.
	 * 
	 * @access public
	 * @param  string   $type       Type of theme either 'frontend' or 'backend'
	 * @param  integer  $themeId
	 * @return Response
	 */
	public function getActivate($type, $themeId)
	{
		if ( ! in_array($type, array('frontend', 'backend'))) App::abort(404);

		App::memory()->put("site.theme.{$type}", $themeId);
		
		Messages::add('success', trans('orchestra/control::response.themes.update', array(
			'type' => Str::title($type),
		)));

		return Redirect::to(handles("orchestra/control::resources/control.themes/{$type}"));
	}
}
