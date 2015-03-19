<?php $acl = app('orchestra.platform.acl'); ?>

<?php $navbar = new \Illuminate\Support\Fluent([
    'id'    => 'control',
    'title' => 'Control',
    'url'   => handles('orchestra::control'),
    'menu'  => app('view')->make('orchestra/control.widgets._menu'),
]); ?>

@decorator('navbar', $navbar)

<br>
