<?php namespace Orchestra\Control\Routing;

use Orchestra\Support\Facades\Meta;

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
     * @return Response
     */
    public function getIndex()
    {
        Meta::set('title', 'Control');

        return view('orchestra/control::home');
    }
}
