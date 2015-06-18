<?php namespace Orchestra\Control\Listeners;

use Orchestra\Memory\MemoryManager;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Timezone as Model;
use Illuminate\Contracts\Config\Repository;

class Timezone
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
     * @var \Orchestra\Memory\MemoryManager
     */
    protected $memory;

    /**
     * Construct a new config handler.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Orchestra\Memory\MemoryManager  $memory
     */
    public function __construct(Repository $config, MemoryManager $memory)
    {
        $this->config = $config;
        $this->memory = $memory;
    }

    /**
     * Is localtime enabled.
     *
     * @return bool
     */
    protected function isLocaltimeEnabled()
    {
        return !! $this->config->get('orchestra/control::localtime.enable', false);
    }
}
