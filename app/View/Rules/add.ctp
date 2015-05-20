<div class="rules form">
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
		<legend><?php echo __('Add Rule'); ?></legend>
	<?php
		echo $this->Form->input('no');
		echo $this->Form->input('ad');
		echo $this->Form->input('action');
		echo $this->Form->input('item');
		echo $this->Form->input('user_id');
		echo $this->Form->input('position_id');
		echo $this->Form->input('department_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('enable');
		echo $this->Form->input('_create_uid');
		echo $this->Form->input('_update_uid');
		echo $this->Form->input('_version');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Rules'), array('action' => 'index')); ?></li>
	</ul>
</div>
