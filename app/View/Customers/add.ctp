<div class="content-header">
    <h1 class="page-header"><?php echo __('Customer'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Customers/index">Index</a></li>
        <li class="active">Create customer</li>
    </ol>
</div>

<div class="content-body">
    <?php 
        echo $this->Form->create('Customer', array('role'=>'form')); 
        echo $this->Form->input('name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('name_en', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('enable', array('div'=>array('class'=>'form-group'), 'class'=>'form-control', 'options'=>array('Y'=>'Yes', 'N'=>'No')));
        echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo "&nbsp;";
        echo $this->Html->link(__('Back'), array('action'=>'index'), array('class'=>'btn btn-default'));
    ?>
</div>