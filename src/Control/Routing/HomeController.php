<?php namespace Orchestra\Control\Routing;

class HomeController extends BaseController
{
    /**
     * Define the filters.
     *
     * @return void
     */
    protected function setupFilters()
    {
        //
    }

    /**
     * Control dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        set_meta('title', 'Control');

        return view('orchestra/control::home');
    }
}
