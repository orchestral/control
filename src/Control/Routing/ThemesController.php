<?php namespace Orchestra\Control\Routing;

use Orchestra\Support\Str;
use Orchestra\Foundation\Routing\AdminController;
use Orchestra\Control\Processor\Theme as ThemeProcessor;

class ThemesController extends AdminController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Theme   $processor
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
     * @return mixed
     */
    public function getIndex($type = 'frontend')
    {
        return $this->processor->index($this, $type);
    }

    /**
     * Show backend theme for Orchestra Platform.
     *
     * @return mixed
     */
    public function getBackend()
    {
        return $this->processor->index($this, 'backend');
    }

    /**
     * Show frontend theme for Orchestra Platform.
     *
     * @return mixed
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
     * @return mixed
     */
    public function getActivate($type, $id)
    {
        return $this->processor->activate($this, $type, $id);
    }

    /**
     * Response when list themes page succeed.
     *
     * @param  array  $data
     * @return mixed
     */
    public function indexSucceed(array $data)
    {
        set_meta('title', trans('orchestra/control::title.themes.list', [
            'type' => Str::title($data['type']),
        ]));

        return view('orchestra/control::themes.index', $data);
    }

    /**
     * Response when theme activation succeed.
     *
     * @param  string  $type
     * @param  string  $id
     * @return mixed
     */
    public function activateSucceed($type, $id)
    {
        $message = trans('orchestra/control::response.themes.update', [
            'type' => Str::title($type),
        ]);

        return $this->redirectWithMessage(handles("orchestra::control/themes/{$type}"), $message);
    }

    /**
     * Response when theme verification failed.
     *
     * @return mixed
     */
    public function themeVerificationFailed()
    {
        return $this->suspend(404);
    }
}
