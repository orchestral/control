<?php namespace Orchestra\Control\Processor;

use Orchestra\Support\Facades\Foundation;

class Theme extends AbstractableProcessor
{
    /**
     * Available themes type.
     *
     * @var array
     */
    protected $type = array('frontend', 'backend');

    /**
     * Setup a new processor.
     */
    public function __construct()
    {
        $this->memory = Foundation::memory();
    }

    /**
     * List available theme.
     *
     * @param  object  $listener
     * @param  string  $type
     * @return mixed
     */
    public function index($listener, $type)
    {
        if (! in_array($type, $this->type)) {
            return $listener->themeVerificationFailed();
        }

        $current = $this->memory->get("site.theme.{$type}");
        $themes  = $this->getAvailableTheme($type);

        return $listener->indexSucceed(compact('current', 'themes', 'type'));
    }

    /**
     * Activate a theme.
     *
     * @param  object  $listener
     * @param  string  $type
     * @param  string  $id
     * @return mixed
     */
    public function activate($listener, $type, $id)
    {
        $theme = $this->getAvailableTheme($type)->get($id);

        if (! in_array($type, $this->type) || is_null($theme)) {
            return $listener->themeVerificationFailed();
        }

        $this->memory->put("site.theme.{$type}", $id);

        return $listener->activateSucceed($type, $id);
    }

    /**
     * Get all available theme.
     *
     * @param  string   $type
     * @return \Illuminate\Support\Collection
     */
    protected function getAvailableTheme($type)
    {
        $themes = Foundation::make('orchestra.theme.finder')->detect();

        return $themes->filter(function ($manifest) use ($type) {
            if (! empty($manifest->type) && ! in_array($type, $manifest->type)) {
                return ;
            }

            return $manifest;
        });
    }
}
