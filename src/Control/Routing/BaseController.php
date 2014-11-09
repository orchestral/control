<?php namespace Orchestra\Control\Routing;

use Orchestra\Routing\Controller;
use Orchestra\Support\Traits\ControllerResponseTrait;

abstract class BaseController extends Controller
{
    use ControllerResponseTrait;

    /**
     * Processor instance.
     *
     * @var object
     */
    protected $processor;

    /**
     * Setup a new controller.
     */
    public function __construct()
    {
        $this->setupFilters();
    }

    /**
     * Define the filters.
     *
     * @return void
     */
    abstract protected function setupFilters();
}
