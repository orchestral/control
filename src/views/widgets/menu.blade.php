<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

@section('orchestra/control::primary_menu')

<ul class="nav navbar-nav">
    @if (App::acl()->can('manage-roles'))
    <li class="{{ Request::is('*resources/control.roles*') ? 'active' : '' }}">
        {{ HTML::link(resources('control.roles'), 'Roles') }}
    </li>
    @endif

    @if (App::acl()->can('manage-acl'))
    <li class="{{ Request::is('*resources/control.acl*') ? 'active' : '' }}">
        {{ HTML::link(resources('control.acl'), 'ACL') }}
    </li>
    @endif

    @if (App::acl()->can('manage-orchestra'))
    <li class="dropdown{{ Request::is('*resources/control.themes*') ? ' active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Themes</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ resources("control.themes/index/frontend") }}">Frontend</a>
            </li>
            <li>
                <a href="{{ resources("control.themes/index/backend") }}">Backend</a>
            </li>
        </ul>
    </li>
    @endif
</ul>
@stop

<? $navbar = new Fluent(array(
    'id'    => 'control',
    'title' => 'Control',
    'url'   => handles('orchestra/foundation::resources/control'),
    'menu'  => View::yieldContent('orchestra/control::primary_menu'),
)); ?>

@decorator('navbar', $navbar)

<br>
