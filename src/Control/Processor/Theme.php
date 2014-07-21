<?php namespace Orchestra\Control\Processor;

use Orchestra\Support\Facades\App;

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
        $this->memory = App::memory();
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
        $themes  = App::make('orchestra.theme.finder')->detect($type);

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
        if (! in_array($type, $this->type)) {
            return $listener->themeVerificationFailed();
        }

        $this->memory->put("site.theme.{$type}", $id);

        return $listener->activateSucceed($type, $id);
    }
}
