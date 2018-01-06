<?php

namespace Orchestra\Control\Processor;

use Illuminate\Support\Collection;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Contracts\Theme\Listener\Selector;

class Theme extends Processor
{
    /**
     * Available themes type.
     *
     * @var array
     */
    protected $type = ['frontend', 'backend'];

    /**
     * Setup a new processor.
     *
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     */
    public function __construct(Foundation $foundation)
    {
        $this->foundation = $foundation;
        $this->memory = $foundation->memory();
    }

    /**
     * List available theme.
     *
     * @param  \Orchestra\Contracts\Theme\Listener\Selector  $listener
     * @param  string  $type
     *
     * @return mixed
     */
    public function showByType(Selector $listener, string $type)
    {
        if (! in_array($type, $this->type)) {
            return $listener->themeFailedVerification();
        }

        $current = $this->memory->get("site.theme.{$type}");
        $themes = $this->getAvailableTheme($type);

        return $listener->showThemeSelection(compact('current', 'themes', 'type'));
    }

    /**
     * Activate a theme.
     *
     * @param  \Orchestra\Contracts\Theme\Listener\Selector  $listener
     * @param  string  $type
     * @param  string  $id
     *
     * @return mixed
     */
    public function activate(Selector $listener, string $type, string $id)
    {
        $theme = $this->getAvailableTheme($type)->get($id);

        if (! in_array($type, $this->type) || is_null($theme)) {
            return $listener->themeFailedVerification();
        }

        $this->memory->put("site.theme.{$type}", $id);

        return $listener->themeHasActivated($type, $id);
    }

    /**
     * Get all available theme.
     *
     * @param  string  $type
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAvailableTheme(string $type): Collection
    {
        $themes = $this->foundation->make('orchestra.theme.finder')->detect();

        return $themes->filter(function ($manifest) use ($type) {
            if (! empty($manifest->type) && ! in_array($type, $manifest->type)) {
                return null;
            }

            return $manifest;
        });
    }
}
