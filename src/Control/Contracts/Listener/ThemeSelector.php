<?php namespace Orchestra\Control\Contracts\Listener;

interface ThemeSelector
{
    /**
     * Response when list themes page succeed.
     *
     * @param  array  $data
     * @return mixed
     */
    public function showThemeSelection(array $data);

    /**
     * Response when theme activation succeed.
     *
     * @param  string $type
     * @param  string $id
     * @return mixed
     */
    public function themeHasActivated($type, $id);

    /**
     * Response when theme verification failed.
     *
     * @return mixed
     */
    public function themeFailedVerification();
}