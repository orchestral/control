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

    public function index($listener, $type)
    {
        if (! in_array($type, $this->type)) {
            return $listener->themeVerificationFailed();
        }

        $current = App::memory()->get("site.theme.{$type}");
        $themes  = App::make('orchestra.theme.finder')->detect();

        return $listener->indexSucceed(compact('current', 'themes', 'type'));
    }

    public function activate($listener, $type, $id)
    {
        if (! in_array($type, $this->type)) {
            return $listener->themeVerificationFailed();
        }

        App::memory()->put("site.theme.{$type}", $id);

        return $listener->updateSucceed($type, $id);
    }
}
