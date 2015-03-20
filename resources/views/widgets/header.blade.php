<?php $navbar = new \Illuminate\Support\Fluent([
    'id'    => 'control',
    'title' => 'Control',
    'url'   => handles('orchestra::control'),
    'menu'  => view('orchestra/control::widgets._menu'),
]); ?>

@decorator('navbar', $navbar)

<br>
