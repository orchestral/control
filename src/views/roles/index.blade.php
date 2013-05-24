@include('orchestra/control::widgets.menu')

<div class="row-fluid">
	<?php Orchestra\Site::set('header::add-button', true); ?>
	@include('orchestra/foundation::layout.widgets.header')
	{{ $table }}
</div>
