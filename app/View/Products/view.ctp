<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Products/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Info</a></li>
            <li><a href="/Products/view_property/<?php echo $product['Product']['id']; ?>">Property</a></li>
            <li><a href="/Products/view_serial/<?php echo $product['Product']['id']; ?>">Serial</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <table class="table">
                <tr>
                    <td class="fit-content" style="border-top-style: none;"><?php echo __('ID'); ?></td>
                    <td style="border-top-style: none;"><?php echo h($product['Product']['id']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Name'); ?></td><td><?php echo h($product['Product']['name']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Name (EN)'); ?></td><td><?php echo h($product['Product']['name_en']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Description'); ?></td><td><pre style="margin: 0px;padding: 0px;background-color: window;border: none;font-size: 100%"><?php echo h($product['Product']['description']); ?></pre></td>
                </tr>
                <tr>
                    <td><?php echo __('Category'); ?></td><td><?php echo h($product['Category']['name']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Brand'); ?></td><td><?php echo h($product['Brand']['name']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Model'); ?></td><td><?php echo h($product['Product']['model']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Cost'); ?></td><td><?php echo h($this->Format->money($product['Product']['cost'])); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Price'); ?></td><td><?php echo h($this->Format->money($product['Product']['price'])); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Enable'); ?></td><td><?php echo h($product['Product']['enable']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Created'); ?></td><td><?php echo h($product['Product']['created']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Modified'); ?></td><td><?php echo h($product['Product']['modified']); ?></td>
                </tr>
                <tr>
                    <td><?php echo __('Version'); ?></td><td><?php echo h($product['Product']['_version']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $product['Product']['id']), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $product['Product']['id']), array('class'=>'btn btn-danger col-lg-1 col- col-xs-4 pull-right icon-bin-before'), __('Are you sure you want to delete # %s?', $product['Product']['name'])); ?>
    </div>
</div>