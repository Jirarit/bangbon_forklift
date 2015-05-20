<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Products/index">Index</a></li>
        <li class="active">Edit</li>
    </ol>
</div>

<div class="content-body">
    <?php 
        echo $this->Form->create('Product', array('role'=>'form')); 
        echo $this->Form->input('id');
		echo $this->Form->input('name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control', 'required'));
		echo $this->Form->input('name_en', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('description', array('type'=>'textarea', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('category_id', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$category_opt, 'empty'=>'----Please Select----', 'required'));
		echo $this->Form->input('brand_id', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$brand_opt, 'empty'=>'----Please Select----', 'required'));
		echo $this->Form->input('model', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('cost', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('price', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('enable', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>array('Y'=>'Yes', 'N'=>'No'), 'empty'=>FALSE));
        
        echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo "&nbsp;";
        echo $this->Html->link(__('Back'), array('action'=>'index'), array('class'=>'btn btn-default'));
    ?>
</div>