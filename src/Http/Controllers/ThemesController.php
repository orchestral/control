<?php

namespace Orchestra\Control\Http\Controllers;

use Orchestra\Support\Str;
use Orchestra\Contracts\Theme\Listener\Selector;
use Orchestra\Control\Processors\Theme as Processor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class ThemesController extends AdminController implements Selector
{
    /**
     * Define the middleware.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->middleware('orchestra.can:manage-acl');
        $this->middleware('orchestra.csrf', ['only' => 'activate']);
    }

    /**
     * Show frontend/backend theme for Orchestra Platform.
     *
     * @param  \Orchestra\Control\Processors\Theme  $processor
     * @param  string  $type
     *
     * @return mixed
     */
    public function index(Processor $processor, $type = 'frontend')
    {
        return $processor->showByType($this, $type);
    }

    /**
     * Show backend theme for Orchestra Platform.
     *
     * @param  \Orchestra\Control\Processors\Theme  $processor
     *
     * @return mixed
     */
    public function backend(Processor $processor)
    {
        return $processor->showByType($this, 'backend');
    }

    /**
     * Show frontend theme for Orchestra Platform.
     *
     * @param  \Orchestra\Control\Processors\Theme  $processor
     *
     * @return mixed
     */
    public function frontend(Processor $processor)
    {
        return $processor->showByType($this, 'frontend');
    }

    /**
     * Set active theme for Orchestra Platform.
     *
     * @param  string  $type
     * @param  int     $id
     *
     * @return mixed
     */
    public function activate(Processor $processor, $type, $id)
    {
        return $processor->activate($this, $type, $id);
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
        \set_meta('title', \trans('orchestra/control::title.themes.list', [
            'type' => Str::title($data['type']),
        ]));

        return \view('orchestra/control::themes.index', $data);
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
        $message = \trans('orchestra/control::response.themes.update', [
            'type' => Str::title($type),
        ]);

        return \redirect_with_message(
            \handles("orchestra::control/themes/{$type}"), $message
        );
    }

    /**
     * Response when theme verification failed.
     *
     * @return mixed
     */
    public function themeFailedVerification()
    {
        return \abort(404);
    }
}
