@include('orchestra/control::widgets.menu')

<?php 

use Orchestra\Support\Facades\Site; 

Site::set('header::add-button', true); ?>

<div class="row">
	<div class="col col-lg-12 box white rounded">
		<?php echo $table; ?>
	</div>
</div>
