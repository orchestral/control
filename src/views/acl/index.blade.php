@include('orchestra/control::widgets.menu')

<?php 

use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\URL;
use Orchestra\Support\Str; ?>

<div class="row">
	<div class="navbar user-search hidden-phone">
		<?php echo Form::open(array('url' => URL::current(), 'method' => 'GET', 'class' => 'navbar-form')); ?>
			<?php echo Form::select('name', $lists, $selected, array('class' => '')); ?>&nbsp;
			<button type="submit" class="btn btn-primary"><?php echo trans('orchestra/foundation::label.submit'); ?></button>
		<?php echo Form::close(); ?>
	</div>

	<?php echo Form::open(array('url' => URL::current(), 'method' => 'POST')); ?>
	<?php echo Form::hidden('metric', $selected); ?>
		
	<?php foreach ($eloquent->roles()->get() as $roleKey => $roleName) : ?>
	<div class="twelve columns panel">
		<div class="panel-heading">
			<?php echo Str::humanize($roleName); ?>
		</div>
		<div class="white rounded-bottom box small-padding">
			<div class="row">
			<?php foreach($eloquent->actions()->get() as $actionKey => $actionName) : ?>
				<label for="acl-<?php echo $roleKey; ?>-<?php echo $actionKey; ?>" class="three columns checkboxes">
					<?php echo Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), array('id' => "acl-{$roleKey}-{$actionKey}")); ?>
					<?php echo Str::humanize($actionName); ?>&nbsp;&nbsp;&nbsp;
				</label>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>

	<div class="row">
		<div class="twelve columns">
			<button type="submit" class="btn btn-primary"><?php echo trans('orchestra/foundation::label.submit'); ?></button>
			<a href="<?php echo handles("orchestra/foundation::resources/control.acl/sync/{$selected}"); ?>" class="btn btn-link">
				<?php echo trans('orchestra/control::label.sync-roles'); ?>
			</a>
		</div>
	</div>
	<?php echo Form::close(); ?>

</div>
