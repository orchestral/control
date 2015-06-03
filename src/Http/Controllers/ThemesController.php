<?php namespace Orchestra\Control\Http\Controllers;

use Orchestra\Support\Str;
use Orchestra\Contracts\Theme\Listener\Selector;
use Orchestra\Control\Processor\Theme as Processor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class ThemesController extends AdminController implements Selector
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Theme  $processor
     */
    public function __construct(Processor $processor)
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
        $this->middleware('orchestra.manage:acl');
        $this->middleware('orchestra.csrf', ['only' => 'activate']);
    }

    /**
     * Show frontend/backend theme for Orchestra Platform.
     *
     * @param  string  $type
     *
     * @return mixed
     */
    public function index($type = 'frontend')
    {
        return $this->processor->showByType($this, $type);
    }

    /**
     * Show backend theme for Orchestra Platform.
     *
     * @return mixed
     */
    public function backend()
    {
        return $this->processor->showByType($this, 'backend');
    }

    /**
     * Show frontend theme for Orchestra Platform.
     *
     * @return mixed
     */
    public function frontend()
    {
        return $this->processor->showByType($this, 'frontend');
    }

    /**
     * Set active theme for Orchestra Platform.
     *
     * @param  string  $type
     * @param  int     $id
     *
     * @return mixed
     */
    public function activate($type, $id)
    {
        return $this->processor->activate($this, $type, $id);
    }

    /**
     * Response when list themes page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function showThemeSelection(array $data)
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
     *
     * @return mixed
     */
    public function themeHasActivated($type, $id)
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
    public function themeFailedVerification()
    {
        return $this->suspend(404);
    }
}
