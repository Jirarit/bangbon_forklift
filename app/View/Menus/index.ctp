<div class="menus index">
	<h2><?php echo __('Menus'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('host'); ?></th>
			<th><?php echo $this->Paginator->sort('path'); ?></th>
			<th><?php echo $this->Paginator->sort('parent'); ?></th>
			<th><?php echo $this->Paginator->sort('level'); ?></th>
			<th><?php echo $this->Paginator->sort('sort'); ?></th>
			<th><?php echo $this->Paginator->sort('total_child'); ?></th>
			<th><?php echo $this->Paginator->sort('action'); ?></th>
			<th><?php echo $this->Paginator->sort('item'); ?></th>
			<th><?php echo $this->Paginator->sort('enable'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('_create_uid'); ?></th>
			<th><?php echo $this->Paginator->sort('_update_uid'); ?></th>
			<th><?php echo $this->Paginator->sort('_version'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($menus as $menu): ?>
	<tr>
		<td><?php echo h($menu['Menu']['id']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['type']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['name']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['host']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['path']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['parent']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['level']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['sort']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['total_child']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['action']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['item']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['enable']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['created']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['modified']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['_create_uid']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['_update_uid']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['_version']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $menu['Menu']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $menu['Menu']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $menu['Menu']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $menu['Menu']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Menu'), array('action' => 'add')); ?></li>
	</ul>
</div>
