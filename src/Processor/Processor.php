<?php

namespace Orchestra\Control\Processors;

abstract class Processor
{
    /**
     * The foundation implementation.
     *
     * @var \Orchestra\Contracts\Foundation\Foundation
     */
    protected $foundation;

    /**
     * Memory instance.
     *
     * @var \Orchestra\Contracts\Memory\Provider
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
