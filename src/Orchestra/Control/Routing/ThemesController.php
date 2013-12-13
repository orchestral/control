<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Control\Processor\Theme as ThemeProcessor;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

class ThemesController extends BaseController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Theme  $processor
     */
    public function __construct(ThemeProcessor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    /**
     * Define the filters.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->beforeFilter('control.manage:acl');
    }

    /**
     * Show frontend/backend theme for Orchestra Platform.
     *
     * @param  string   $type
     * @return Response
     */
    public function getIndex($type = 'frontend')
    {
        return $this->processor->index($this, $type);
    }

    /**
     * Set active theme for Orchestra Platform.
     *
     * @param  string   $type
     * @param  integer  $id
     * @return Response
     */
    public function getActivate($type, $id)
    {
        return $this->processor->activate($this, $type, $id);
    }

    public function indexSucceed(array $data)
    {
        Site::set('title', trans('orchestra/control::title.themes.list', array(
            'type' => Str::title($data['type']),
        )));

        return View::make('orchestra/control::themes.index', $data);
    }

    public function activateSucceed($type, $id)
    {
        $message = trans('orchestra/control::response.themes.update', array(
            'type' => Str::title($type),
        ));

        return $this->redirectWithMessage(resources("control.themes/index/{$type}"), $message);
    }

    public function themeVerificationFailed()
    {
        return $this->suspend(404);
    }
}
