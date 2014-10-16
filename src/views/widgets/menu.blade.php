<?php $acl = app('orchestra.platform.acl'); ?>

@section('orchestra/control::primary_menu')

<ul class="nav navbar-nav">
    @if ($acl->can('manage-roles'))
    <li class="{!! app('request')->is('*resources/control.roles*') ? 'active' : '' !!}">
        <a href="{!! resources('control.roles') !!}">Roles</a>
    </li>
    @endif

    @if ($acl->can('manage-acl'))
    <li class="{!! app('request')->is('*resources/control.acl*') ? 'active' : '' !!}">
         <a href="{!! resources('control.acl') !!}">ACL</a>
    </li>
    @endif

    @if ($acl->can('manage-orchestra'))
    <li class="dropdown{{ app('request')->is('*resources/control.themes*') ? ' active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Themes</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{!! resources('control.themes/index/frontend') !!}">Frontend</a>
            </li>
            <li>
                <a href="{{ resources('control.themes/index/backend') }}">Backend</a>
            </li>
        </ul>
    </li>
    @endif
</ul>
@stop

<? $navbar = new \Illuminate\Support\Fluent([
    'id'    => 'control',
    'title' => 'Control',
    'url'   => handles('orchestra/foundation::resources/control'),
    'menu'  => app('view')->yieldContent('orchestra/control::primary_menu'),
]); ?>

@decorator('navbar', $navbar)

<br>
