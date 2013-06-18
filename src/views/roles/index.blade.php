@include('orchestra/control::widgets.menu')

<?php use Orchestra\Support\Facades\Site; ?>

<div class="row">
	<?php Site::set('header::add-button', true); ?>
	@include('orchestra/foundation::layout.widgets.header')
	<?php echo $table; ?>
</div>
