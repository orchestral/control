<?php

namespace Orchestra\Control\Http\Controllers;

use Orchestra\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Control dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        \set_meta('title', 'Control');

        return \view('orchestra/control::home');
    }
}
