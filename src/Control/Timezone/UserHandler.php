<?php namespace Orchestra\Control\Timezone;

use Orchestra\Control\Timezone;
use Orchestra\Html\Form\Fieldset;
use Orchestra\Memory\MemoryManager;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Form\Builder as FormBuilder;

class UserHandler
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
     * Construct a new config handler.
     *
     * @param  \Illuminate\Contracts\Config\Repository   $config
     * @param  \Orchestra\Memory\MemoryManager   $memory
     */
    public function __construct(Repository $config, MemoryManager $memory)
    {
        $this->config = $config;
        $this->memory = $memory;
    }

    /**
     * Handle `orchestra.form: user.account` event.
     *
     * @param  \Orchestra\Model\User   $user
     * @param  \Orchestra\Contracts\Html\Form\Builder   $form
     * @return void
     */
    public function onViewForm($user, FormBuilder $form)
    {
        if (! $this->isLocaltimeEnabled()) {
            return ;
        }

        $form->extend(function (FormGrid $form) {
            $form->fieldset('Timezone', function (Fieldset $fieldset) {
                $fieldset->control('select', 'meta_timezone')
                    ->label('Timezone')
                    ->options(Timezone::lists())
                    ->value(function ($row) {
                        $meta = $this->memory->make('user');

                        return $meta->get("timezone.{$row->id}", $this->config->get('app.timezone'));
                    });
                });
            });
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

    /**
     * Handle `orchestra.saved: user.account` event.
     *
     * @param  \Orchestra\Model\User   $user
     * @return void
     */
    public function onSaved($user)
    {
        if (! $this->isLocaltimeEnabled()) {
            return ;
        }

        $userId = $user->id;
        $meta   = $this->memory->make('user');

        $meta->put("timezone.{$userId}", Input::get('meta_timezone'));
    }
}
