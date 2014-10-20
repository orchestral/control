<?php namespace Orchestra\Control\Presenter;

use Orchestra\Html\Form\PresenterInterface as FormPresenterInterface;

abstract class Presenter implements FormPresenterInterface
{
    /**
     * {@inheritdoc}
     */
    public function handles($url)
    {
        return resources($url);
    }

    /**
     * {@inheritdoc}
     */
    public function setupForm($form)
    {
        $form->layout('orchestra/foundation::components.form');
    }
}
