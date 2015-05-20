<div class="menus form">
<?php echo $this->Form->create('Menu'); ?>
	<fieldset>
		<legend><?php echo __('Add Menu'); ?></legend>
	<?php
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('name_en');
		echo $this->Form->input('host');
		echo $this->Form->input('path');
		echo $this->Form->input('parent');
		echo $this->Form->input('level');
		echo $this->Form->input('sort');
		echo $this->Form->input('total_child');
		echo $this->Form->input('action');
		echo $this->Form->input('item');
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

		<li><?php echo $this->Html->link(__('List Menus'), array('action' => 'index')); ?></li>
	</ul>
</div>
