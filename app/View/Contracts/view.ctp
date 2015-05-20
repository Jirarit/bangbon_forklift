<div class="contracts view">
<h2><?php echo __('Contract'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contract No'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['contract_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Id'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['product_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Serial'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['product_serial']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Id'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['customer_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Location Id'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['customer_location_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ref Car No'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['ref_car_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ref Quotation No'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['ref_quotation_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ref Pr No'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['ref_pr_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ref Po No'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['ref_po_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attach Pic'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['attach_pic']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attach Doc'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['attach_doc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Create Uid'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['_create_uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Update Uid'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['_update_uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Version'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['_version']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contract'), array('action' => 'edit', $contract['Contract']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contract'), array('action' => 'delete', $contract['Contract']['id']), array(), __('Are you sure you want to delete # %s?', $contract['Contract']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contracts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contract'), array('action' => 'add')); ?> </li>
	</ul>
</div>
