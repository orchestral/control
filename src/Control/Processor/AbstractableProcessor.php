<?php namespace Orchestra\Control\Processor;

abstract class AbstractableProcessor
{
    /**
     * Memory instance.
     *
     * @var \Orchestra\Memory\Provider
     */
    protected $memory;

    /**
     * Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Presenter instance.
     *
     * @var object
     */
    protected $presenter;

    /**
     * Validation instance.
     *
     * @var object
     */
    protected $validator;
}
