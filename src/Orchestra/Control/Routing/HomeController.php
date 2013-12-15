<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Site;

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
        Site::set('title', 'Control');

        return View::make('orchestra/control::home');
    }
}
