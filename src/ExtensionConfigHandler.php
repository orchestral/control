<?php namespace Orchestra\Control;

use Orchestra\Model\Role;
use Illuminate\Support\Fluent;
use Orchestra\Contracts\Memory\Provider;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Control\Contracts\Command\Synchronizer;
use Orchestra\Contracts\Html\Form\Builder as FormBuilder;

class ExtensionConfigHandler
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

    /**
     * Handle `orchestra.form: extension.orchestra/control` event.
     *
     * @param  \Orchestra\Model\User  $model
     * @param  \Orchestra\Contracts\Html\Form\Builder  $form
     *
     * @return void
     */
    public function onViewForm($model, FormBuilder $form)
    {
        $form->extend(function (FormGrid $form) {
            $form->fieldset('Role Configuration', function (Fieldset $fieldset) {
                $roles = Role::lists('name', 'id');

                $fieldset->control('select', 'admin_role')
                    ->label(trans('orchestra/control::label.roles.admin'))
                    ->options($roles);

                $fieldset->control('select', 'member_role')
                    ->label(trans('orchestra/control::label.roles.member'))
                    ->options($roles);
            });

            $form->fieldset('Timezone', function (Fieldset $fieldset) {
                $agreement = ['yes' => 'Yes', 'no'  => 'No'];

                $fieldset->control('select', 'localtime')
                    ->attributes(['role' => 'agreement'])
                    ->label(trans('orchestra/control::label.enable-timezone'))
                    ->options($agreement)
                    ->value(function ($row) {
                        return ($row->localtime === true) ? 'yes' : 'no';
                    });
            });
        });
    }

    /**
     * Handle `orchestra.saved: extension.orchestra/control` event.
     *
     * @param  \Illuminate\Support\Fluent  $input
     *
     * @return void
     */
    public function onSaved(Fluent $input)
    {
        $localtime = ($input['localtime'] === 'yes');

        $this->config->set('orchestra/foundation::roles.admin', (int) $input['admin_role']);
        $this->config->set('orchestra/foundation::roles.member', (int) $input['member_role']);

        Role::setDefaultRoles($this->config->get('orchestra/foundation::roles'));

        $this->synchronizer->handle();

        $this->memory->put('extension_orchestra/control.localtime', $localtime);
    }
}
