<div class="content-header">
    <h1 class="page-header"><?php echo __('Customer'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Customers/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Info</a></li>
            <li><a href="/Customers/locations/<?php echo $customer['Customer']['id']; ?>">Locations</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <table class="table">
                <tr>
                    <td class="fit-content" style="border-top-style: none;"><?php echo __('ID'); ?></td>
                    <td style="border-top-style: none;"><?php echo h($customer['Customer']['id']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Name'); ?></td><td><?php echo h($customer['Customer']['name']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Name (EN)'); ?></td><td><?php echo h($customer['Customer']['name_en']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Enable'); ?></td><td><?php echo h($customer['Customer']['enable']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Created'); ?></td><td><?php echo h($customer['Customer']['created']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Modified'); ?></td><td><?php echo h($customer['Customer']['modified']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Version'); ?></td><td><?php echo h($customer['Customer']['_version']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id']), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $customer['Customer']['id']), array('class'=>'btn btn-danger col-lg-1 col- col-xs-4 pull-right icon-bin-before'), __('Are you sure you want to delete # %s?', $customer['Customer']['name'])); ?>
    </div>
</div>