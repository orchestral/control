@include('orchestra/control::widgets.menu')

<?php

use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\URL;
use Orchestra\Support\Str;

$actions = $eloquent->actions()->get();
$roles = $eloquent->roles()->get(); ?>

<div class="row">
    <div class="navbar user-search hidden-phone">
        {{ Form::open(array('url' => URL::current(), 'method' => 'GET', 'class' => 'navbar-form')) }}
            {{ Form::select('name', $collection, $id, array('class' => '')) }}&nbsp;
            <button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
        {{ Form::close() }}
    </div>

    {{ Form::open(array('url' => URL::current(), 'method' => 'POST')) }}
    {{ Form::hidden('metric', $id) }}

    @foreach ($roles as $roleKey => $roleName)
    <div class="twelve columns panel panel-default">
        <div class="panel-heading">
            {{ Str::humanize($roleName) }}
        </div>
        <div class="white rounded-bottom box small-padding">
            <div class="row">
            @foreach($actions as $actionKey => $actionName)
                <label for="acl-{{ $roleKey }}-{{ $actionKey }}" class="three columns checkboxes">
                    {{ Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), array('id' => "acl-{$roleKey}-{$actionKey}")) }}
                    {{ Str::humanize($actionName) }}
                    &nbsp;&nbsp;&nbsp;
                </label>
            @endforeach
            </div>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="twelve columns">
            <button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
            <a href="{{ resources("control.acl/sync/{$id}") }}" class="btn btn-link">
                {{ trans('orchestra/control::label.sync-roles') }}
            </a>
        </div>
    </div>
    {{ Form::close() }}
</div>
