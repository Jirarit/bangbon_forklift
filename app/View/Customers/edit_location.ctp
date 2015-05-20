<div class="content-header">
    <h1 class="page-header"><?php echo __('Customer'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Customers/index">Index</a></li>
        <li><a href="/Customers/view/<?php echo $customer_id ?>">Info</a></li>
        <li class="active">Edit location</li>
    </ol>
</div>

<div class="content-body">
    <?php 
        echo $this->Form->create('CustomerLocation', array('role'=>'form'));
        echo $this->Form->input('id');
        echo $this->Form->hidden('customer_id', array('value'=>$customer_id));
        echo $this->Form->input('branch_name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('zone_name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('enable', array('div'=>array('class'=>'form-group'), 'class'=>'form-control', 'options'=>array('Y'=>'Yes', 'N'=>'No')));
        echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo "&nbsp;";
        echo $this->Html->link(__('Back'), array('action'=>'locations', $customer_id), array('class'=>'btn btn-default'));
    ?>
</div>