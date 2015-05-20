<div class="content-header">
    <h1 class="page-header"><?php echo __('User'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Users/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <table class="table">
        <tr>
            <td class="fit-content"><?php echo __('ID'); ?></td><td><?php echo h($user['User']['id']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Login'); ?></td><td><?php echo h($user['User']['login']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Name'); ?></td><td><?php echo h($user['User']['name']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Enable'); ?></td><td><?php echo h($user['User']['enable']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Created'); ?></td><td><?php echo h($user['User']['created']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Modified'); ?></td><td><?php echo h($user['User']['modified']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Version'); ?></td><td><?php echo h($user['User']['_version']); ?></td>
        </tr>
    </table>
    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class'=>'btn btn-danger col-lg-1 col- col-xs-4 pull-right icon-bin-before'), __('Are you sure you want to delete # %s?', $user['User']['login'])); ?>
    </div>
</div>