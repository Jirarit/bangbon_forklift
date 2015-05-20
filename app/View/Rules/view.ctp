<div class="rules view">
<h2><?php echo __('Rule'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('No'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ad'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['ad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Item'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['item']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Position Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['position_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Department Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['department_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['group_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enable'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['enable']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Create Uid'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['_create_uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Update Uid'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['_update_uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __(' Version'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['_version']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rule'), array('action' => 'edit', $rule['Rule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rule'), array('action' => 'delete', $rule['Rule']['id']), array(), __('Are you sure you want to delete # %s?', $rule['Rule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('action' => 'add')); ?> </li>
	</ul>
</div>
