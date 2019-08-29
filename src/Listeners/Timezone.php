<?php

namespace Orchestra\Control\Listeners;

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
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Is localtime enabled.
     *
     * @return bool
     */
    protected function isLocaltimeEnabled(): bool
    {
        return (bool) $this->config->get('orchestra/control::localtime.enable', false);
    }
}
