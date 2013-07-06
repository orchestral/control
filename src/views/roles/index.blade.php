@include('orchestra/control::widgets.menu')

<?php 

use Orchestra\Support\Facades\Site; 

Site::set('header::add-button', true); ?>

<div class="row">
	<div class="twelve columns white rounded box">
		<?php echo $table; ?>
	</div>
</div>
