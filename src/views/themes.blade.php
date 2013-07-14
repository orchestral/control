@include('orchestra/control::widgets.menu')

<div class="container">
	<div class="row">
		<?php if (empty($themes)) : ?>
		<div class="jumbotron">
			<div class="page-header">
				<h2>We can't find any theme yet!</h2>
			</div>

			<p>Don't worry, you can stil use Orchestra without a theme :)</p>
		</div>
		<?php else : 
		foreach ($themes as $id => $theme) : ?>

		<div class="four columns white rounded themes box">
			<img src="<?php echo asset("themes/{$id}/screenshot.png"); ?>" class="img-thumbnail">
			<h3><?php echo $theme->name; ?></h3>
			<p><?php echo $theme->description; ?></p>

			<div>
			<?php if ($id === $current) : ?>
				<button class="btn btn-block btn-warning disabled">
					<?php echo trans('orchestra/control::label.themes.current'); ?>
				</button>
			<?php else : ?>
				<a href="<?php echo handles("orchestra/foundation::resources/control.themes/activate/{$type}/{$id}"); ?>"  
					 class="btn btn-block btn-primary">
					<?php echo trans('orchestra/control::label.themes.activate'); ?>
				</a>
			<?php endif; ?>
			</div>

		</div>
		<?php endforeach;
		endif; ?>

	</div>
</div>
