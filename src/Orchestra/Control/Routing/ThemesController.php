<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

class ThemesController extends BaseController
{
    /**
     * Define the filters.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->beforeFilter('control.manage:orchestra');
    }

    /**
     * Show frontend/backend theme for Orchestra Platform.
     *
     * @access public
     * @param  string   $type       Type of theme either 'frontend' or 'backend'
     * @return Response
     */
    public function getIndex($type = 'frontend')
    {
        if (! in_array($type, array('frontend', 'backend'))) {
            App::abort(404);
        }

        $current = App::memory()->get("site.theme.{$type}");
        $themes  = App::make('orchestra.theme.finder')->detect();

        Site::set('title', trans('orchestra/control::title.themes.list', array(
            'type' => Str::title($type),
        )));

        return View::make('orchestra/control::themes', array(
            'themes'  => $themes,
            'type'    => $type,
            'current' => $current,
        ));
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
        if (! in_array($type, array('frontend', 'backend'))) {
            App::abort(404);
        }

        App::memory()->put("site.theme.{$type}", $themeId);

        Messages::add('success', trans('orchestra/control::response.themes.update', array(
            'type' => Str::title($type),
        )));

        return Redirect::to(resources("control.themes/index/{$type}"));
    }
}
