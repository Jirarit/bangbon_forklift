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
            <li><a href="/Products/view/<?php echo $product_id; ?>">Info</a></li>
            <li class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Property</a></li>
            <li><a href="/Products/view_serial/<?php echo $product_id; ?>">Serial</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php
            switch ($product['Category']['code']) {
                case 'forklifts':
                    echo $this->element('ProductProperty/Forklift/view', ['property'=>$property['ProductProperty']]);
                    break;
                default:
                    echo "<h4 class='text-center'>{$product['Category']['name']} property not found</h4>";
                    break;
            }
            ?>
        </div>
    </div>

    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit_property', $product_id), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
    </div>
</div>