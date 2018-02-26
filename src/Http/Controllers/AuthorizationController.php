<?php

namespace Orchestra\Control\Http\Controllers;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Processor\Authorization;
use Orchestra\Control\Contracts\Command\Synchronizer;
use Orchestra\Foundation\Http\Controllers\AdminController;

class AuthorizationController extends AdminController
{
    /**
     * The synchronizer implementation.
     *
     * @var \Orchestra\Control\Contracts\Command\Synchronizer
     */
    protected $synchronizer;

    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Authorization  $processor
     * @param  \Orchestra\Control\Contracts\Command\Synchronizer  $synchronizer
     */
    public function __construct(Authorization $processor, Synchronizer $synchronizer)
    {
        $this->processor = $processor;
        $this->synchronizer = $synchronizer;

        parent::__construct();
    }

    /**
     * Define the middleware.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->middleware('orchestra.can:manage-acl');
        $this->middleware('orchestra.csrf', ['only' => 'sync']);
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
     * @param  string  $vendor
     * @param  string|null  $package
     *
     * @return mixed
     */
    public function sync($vendor, $package = null)
    {
        return $this->processor->sync($this, $vendor, $package);
    }

    /**
     * Response when lists ACL page succeed.
     *
     * @param  array  $data
     *
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
     * @param  string  $metric
     *
     * @return mixed
     */
    public function updateSucceed($metric)
    {
        $this->synchronizer->handle();

        $message = trans('orchestra/control::response.acls.update');

        return $this->redirectWithMessage(handles("orchestra::control/acl?name={$metric}"), $message);
    }

    /**
     * Response when sync roles succeed.
     *
     * @param  \Illuminate\Support\Fluent   $acl
     *
     * @return mixed
     */
    public function syncSucceed(Fluent $acl)
    {
        $message = trans('orchestra/control::response.acls.sync-roles', [
            'name' => $acl->get('name'),
        ]);

        return $this->redirectWithMessage(handles("orchestra::control/acl?name={$acl->get('name')}"), $message);
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
