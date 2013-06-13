@section('orchestra/control::primary_menu')

<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

<ul class="nav navbar-nav">
	<?php if (App::acl()->can('manage-roles')) : ?>
	<li class="<?php echo Request::is('*/resources/control.roles*') ? 'active' : ''; ?>">
		<?php echo HTML::link(handles('orchestra/foundation::resources/control.roles'), 'Roles'); ?>
	</li>
	<?php 
	endif;
	if (App::acl()->can('manage-acl')) : ?>
	<li class="<?php echo Request::is('*/resources/control.acl*') ? 'active' : ''; ?>">
		<?php echo HTML::link(handles('orchestra/foundation::resources/control.acl'), 'ACL') }}
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
