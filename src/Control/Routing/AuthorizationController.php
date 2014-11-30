<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Fluent;
use Orchestra\Control\Authorize;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Processor\Authorization;
use Orchestra\Foundation\Routing\AdminController;

class AuthorizationController extends AdminController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Authorization  $processor
     */
    public function __construct(Authorization $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    /**
     * Define the filters.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->beforeFilter('control.manage:acl');
        $this->beforeFilter('control.csrf', ['only' => 'sync']);
    }

    /**
     * Get default resources landing page.
     *
     * @return mixed
     */
    public function edit()
    {
        return $this->processor->edit($this, Input::get('name', 'orchestra'));
    }

    /**
     * Update ACL metric.
     *
     * @return mixed
     */
    public function update()
    {
        return $this->processor->update($this, Input::all());
    }

    /**
     * Get sync roles action.
     *
     * @param  string  $id
     * @return mixed
     */
    public function sync($id)
    {
        return $this->processor->sync($this, $id);
    }

    /**
     * Response when lists ACL page succeed.
     *
     * @param  array  $data
     * @return mixed
     */
    public function indexSucceed(array $data)
    {
        set_meta('title', trans('orchestra/control::title.acls.list'));

        return view('orchestra/control::acl.index', $data);
    }

    /**
     * Response when ACL is updated.
     *
     * @param  string  $id
     * @return mixed
     */
    public function updateSucceed($id)
    {
        Authorize::sync();

        $message = trans('orchestra/control::response.acls.update');

        return $this->redirectWithMessage(handles("orchestra::control/acl?name={$id}"), $message);
    }

    /**
     * Response when sync roles succeed.
     *
     * @param  \Illuminate\Support\Fluent   $acl
     * @return mixed
     */
    public function syncSucceed(Fluent $acl)
    {
        $message = trans('orchestra/control::response.acls.sync-roles', [
            'name' => $acl->get('name'),
        ]);

        return $this->redirectWithMessage(handles("orchestra::control/acl?name={$acl->get('id')}"), $message);
    }

    /**
     * Response when acl verification failed.
     *
     * @return mixed
     */
    public function aclVerificationFailed()
    {
        return $this->suspend(404);
    }
}
