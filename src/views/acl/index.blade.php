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

	<div class="col col-lg-12 box white rounded">

		<?php echo Form::open(array('url' => URL::current(), 'method' => 'POST')); ?>
			<?php echo Form::hidden('metric', $selected); ?>
			<div class="accordion" id="acl-accordion">
			
			<?php foreach ($eloquent->roles()->get() as $roleKey => $roleName) : ?>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" 
							data-parent="#acl-accordion" href="#collapse<?php echo $roleKey; ?>">
							<?php echo Str::humanize($roleName); ?>
						</a>
					</div>
					<div id="collapse<?php echo $roleKey; ?>" class="accordion-body collapse in">
						<div class="accordion-inner">
							<div class="row">
							<?php foreach($eloquent->actions()->get() as $actionKey => $actionName) : ?>
								<label for="acl-<?php echo $roleKey; ?>-<?php echo $actionKey; ?>" class="col col-lg-3 checkboxes">
									<?php echo Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), array('id' => "acl-{$roleKey}-{$actionKey}")); ?>
									<?php echo Str::humanize($actionName); ?>&nbsp;&nbsp;&nbsp;
								</label>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary"><?php echo trans('orchestra/foundation::label.submit'); ?></button>
				<a href="<?php echo handles("orchestra/foundation::resources/control.acl/sync/{$selected}"); ?>" class="btn">
					<?php echo trans('orchestra/control::label.sync-roles'); ?>
				</a>
			</div>
		<?php echo Form::close(); ?>
	</div>

</div>
