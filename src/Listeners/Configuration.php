<?php namespace Orchestra\Control\Listeners;

use Orchestra\Contracts\Memory\Provider;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Control\Contracts\Command\Synchronizer;

abstract class Configuration
{
    /**
     * The config implementation.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The memory implementation.
     *
     * @var \Orchestra\Contracts\Memory\Provider
     */
    protected $memory;

    /**
     * The synchronizer implementation.
     *
     * @var \Orchestra\Control\Contracts\Command\Synchronizer
     */
    protected $synchronizer;

    /**
     * Construct a new config handler.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Orchestra\Contracts\Memory\Provider  $memory
     * @param  \Orchestra\Control\Contracts\Command\Synchronizer  $synchronizer
     */
    public function __construct(Repository $config, Provider $memory, Synchronizer $synchronizer)
    {
        $this->config       = $config;
        $this->memory       = $memory;
        $this->synchronizer = $synchronizer;
    }
}
