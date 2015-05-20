<div class="rules index">
	<h2><?php echo __('Rules'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('no'); ?></th>
			<th><?php echo $this->Paginator->sort('ad'); ?></th>
			<th><?php echo $this->Paginator->sort('action'); ?></th>
			<th><?php echo $this->Paginator->sort('item'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('position_id'); ?></th>
			<th><?php echo $this->Paginator->sort('department_id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('enable'); ?></th>
			<th><?php echo $this->Paginator->sort('_create_uid'); ?></th>
			<th><?php echo $this->Paginator->sort('_update_uid'); ?></th>
			<th><?php echo $this->Paginator->sort('_version'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($rules as $rule): ?>
	<tr>
		<td><?php echo h($rule['Rule']['id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['no']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['ad']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['action']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['item']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['position_id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['department_id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['group_id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['enable']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['_create_uid']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['_update_uid']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['_version']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rule['Rule']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rule['Rule']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rule['Rule']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $rule['Rule']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Rule'), array('action' => 'add')); ?></li>
	</ul>
</div>
