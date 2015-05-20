<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Products/index">Index</a></li>
        <li><a href="/Products/view_property/<?php echo $product_id ?>">Property</a></li>
        <li class="active">Edit</li>
    </ol>
</div>

<div class="content-body">
    <?php
    echo $this->Form->create('Property', array('role'=>'form'));
    echo $this->Form->hidden('id');
    switch ($product['Category']['code']) {
        case 'forklifts':
            echo $this->element('ProductProperty/Forklift/edit');
            break;
        default:
            echo "<h4 class='text-center'>{$product['Category']['code']} property not found</h4>";
            break;
    }
    
    echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
    echo "&nbsp;";
    echo $this->Html->link(__('Back'), array('action'=>'view_property', $product_id), array('class'=>'btn btn-default'));

    ?>
</div>