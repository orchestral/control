<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Fluent;
use Orchestra\Control\Authorize;
use Orchestra\Support\Facades\Meta;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Processor\Acl as AclProcessor;

class AclController extends BaseController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Acl    $processor
     */
    public function __construct(AclProcessor $processor)
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
    }

    /**
     * Get default resources landing page.
     *
     * @return Response
     */
    public function getIndex()
    {
        return $this->processor->index($this, Input::get('name', 'orchestra'));
    }

    /**
     * Update ACL metric.
     *
     * @return Response
     */
    public function postIndex()
    {
        return $this->processor->update($this, Input::all());
    }

    /**
     * Get sync roles action.
     *
     * @param  string   $id
     * @return Response
     */
    public function getSync($id)
    {
        return $this->processor->sync($this, $id);
    }

    /**
     * Response when lists ACL page succeed.
     *
     * @param  array  $data
     * @return Response
     */
    public function indexSucceed(array $data)
    {
        Meta::set('title', trans('orchestra/control::title.acls.list'));

        return view('orchestra/control::acl.index', $data);
    }

    /**
     * Response when ACL is updated.
     *
     * @param  string  $id
     * @return Response
     */
    public function updateSucceed($id)
    {
        Authorize::sync();

        $message = trans('orchestra/control::response.acls.update');

        return $this->redirectWithMessage(resources("control.acl?name={$id}"), $message);
    }

    /**
     * Response when sync roles succeed.
     *
     * @param  \Illuminate\Support\Fluent   $acl
     * @return Response
     */
    public function syncSucceed(Fluent $acl)
    {
        $message = trans('orchestra/control::response.acls.sync-roles', array(
            'name' => $acl->name,
        ));

        return $this->redirectWithMessage(resources("control.acl?name={$acl->id}"), $message);
    }

    /**
     * Response when acl verification failed.
     *
     * @return Response
     */
    public function aclVerificationFailed()
    {
        return $this->suspend(404);
    }
}
