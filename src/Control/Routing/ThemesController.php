<?php namespace Orchestra\Control\Routing;

use Orchestra\Support\Str;
use Orchestra\Support\Facades\Meta;
use Orchestra\Control\Processor\Theme as ThemeProcessor;

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
     * Show backend theme for Orchestra Platform.
     *
     * @return Response
     */
    public function getBackend()
    {
        return $this->processor->index($this, 'backend');
    }

    /**
     * Show frontend theme for Orchestra Platform.
     *
     * @return Response
     */
    public function getFrontend()
    {
        return $this->processor->index($this, 'frontend');
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

    /**
     * Response when list themes page succeed.
     *
     * @param  array  $data
     * @return Response
     */
    public function indexSucceed(array $data)
    {
        Meta::set('title', trans('orchestra/control::title.themes.list', array(
            'type' => Str::title($data['type']),
        )));

        return view('orchestra/control::themes.index', $data);
    }

    /**
     * Response when theme activation succeed.
     *
     * @param  string  $type
     * @param  string  $id
     * @return Response
     */
    public function activateSucceed($type, $id)
    {
        $message = trans('orchestra/control::response.themes.update', array(
            'type' => Str::title($type),
        ));

        return $this->redirectWithMessage(resources("control.themes/{$type}"), $message);
    }

    /**
     * Response when theme verification failed.
     *
     * @return Response
     */
    public function themeVerificationFailed()
    {
        return $this->suspend(404);
    }
}
