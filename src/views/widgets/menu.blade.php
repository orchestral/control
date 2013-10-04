@section('orchestra/control::primary_menu')

<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

<ul class="nav navbar-nav">
	<?php if (App::acl()->can('manage-roles')) : ?>
	<li class="<?php echo Request::is('*resources/control.roles*') ? 'active' : ''; ?>">
		<?php echo HTML::link(resources('control.roles'), 'Roles'); ?>
	</li>
	<?php 
	endif;
	if (App::acl()->can('manage-acl')) : ?>
	<li class="<?php echo Request::is('*resources/control.acl*') ? 'active' : ''; ?>">
		<?php echo HTML::link(resources('control.acl'), 'ACL'); ?>
	</li>
	<?php endif;
	if (App::acl()->can('manage-orchestra')) : ?>
	<li class="dropdown<?php echo Request::is('*resources/control.themes*') ? ' active' : ''; ?>">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Themes</a>
		<ul class="dropdown-menu">
			<li>
				<a href="<?php echo resources("control.themes/index/frontend"); ?>">Frontend</a>
			</li>
			<li>
				<a href="<?php echo resources("control.themes/index/backend"); ?>">Backend</a>
			</li>
		</ul>
	</li>
	<?php endif; ?>
</ul>
@stop

<?php

$navbar = new Fluent(array(
	'id'    => 'control',
	'title' => 'Control',
	'url'   => handles('orchestra/foundation::resources/control'),
	'menu'  => View::yieldContent('orchestra/control::primary_menu'),
)); ?>

@decorator('navbar', $navbar)

<br>
