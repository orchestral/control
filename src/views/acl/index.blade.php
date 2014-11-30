@extends('orchestra/foundation::layouts.page')

@section('content')
@include('orchestra/control::widgets.menu')

<?php

$actions = $eloquent->actions()->get();
$roles = $eloquent->roles()->get(); ?>

<div class="row">
    <div class="navbar user-search hidden-phone">
        {!! app('form')->open(['url' => app('url')->current(), 'method' => 'GET', 'class' => 'navbar-form']) !!}
            {!! app('form')->select('name', $collection, $id, ['class' => '']) !!}&nbsp;
            <button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
        {!! app('form')->close() !!}
    </div>

    {!! app('form')->open(['url' => app('url')->current(), 'method' => 'POST']) !!}
    {!! app('form')->hidden('metric', $id) !!}

    @foreach ($roles as $roleKey => $roleName)
    <div class="twelve columns panel panel-default">
        <div class="panel-heading">
            {{ Orchestra\Support\Str::humanize($roleName) }}
        </div>
        <div class="white rounded-bottom box small-padding">
            <div class="row">
            @foreach($actions as $actionKey => $actionName)
                <label for="acl-{!! $roleKey !!}-{!! $actionKey !!}" class="three columns checkboxes">
                    {!! app('form')->checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), ['id' => "acl-{$roleKey}-{$actionKey}"]) !!}
                    {{ Orchestra\Support\Str::humanize($actionName) }}
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
            <a href="{!! handles("orchestra::control/acl/sync/{$id}", ['csrf' => true]) !!}" class="btn btn-link">
                {{ trans('orchestra/control::label.sync-roles') }}
            </a>
        </div>
    </div>
    {!! app('form')->close() !!}
</div>
@stop
