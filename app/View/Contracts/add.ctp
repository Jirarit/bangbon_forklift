<div class="contracts form">
<?php echo $this->Form->create('Contract'); ?>
	<fieldset>
		<legend><?php echo __('Add Contract'); ?></legend>
	<?php
		echo $this->Form->input('contract_no');
		echo $this->Form->input('product_id');
		echo $this->Form->input('product_serial');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('customer_location_id');
		echo $this->Form->input('ref_car_no');
		echo $this->Form->input('ref_quotation_no');
		echo $this->Form->input('ref_pr_no');
		echo $this->Form->input('ref_po_no');
		echo $this->Form->input('price');
		echo $this->Form->input('status');
		echo $this->Form->input('attach_pic');
		echo $this->Form->input('attach_doc');
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

		<li><?php echo $this->Html->link(__('List Contracts'), array('action' => 'index')); ?></li>
	</ul>
</div>
