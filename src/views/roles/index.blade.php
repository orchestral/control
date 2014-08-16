@include('orchestra/control::widgets.menu')

<?php Orchestra\Support\Facades\Site::set('header::add-button', true); ?>

<div class="row">
	<div class="twelve columns white rounded box">
		{{ $table }}
	</div>
</div>
