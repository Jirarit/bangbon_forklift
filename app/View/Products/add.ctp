<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Products/index">Index</a></li>
        <li class="active">Create product</li>
    </ol>
</div>

<div class="row">
    <div class="col-xs-offset-1 col-lg-offset-2 col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-default btn-circle" style="cursor: default;">1</i><br>General
    </div>
    <div class="col-xs-2 col-lg-2" style="padding: 0px">
        <hr>
    </div>
    <div class="col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-default btn-circle" style="background:window;color: black;cursor:default;">2</i><br>Property
    </div>
    <div class="col-xs-2 col-lg-2" style="padding: 0px">
        <hr>
    </div>
    <div class="col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-default btn-circle" style="background:window;color: black;cursor:default;">3</i><br>Serial
    </div>
</div>
<br>
<div class="content-body">

    <?php 
        echo $this->Form->create('Product', array('role'=>'form')); 
        echo $this->Form->input('name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control', 'required'));
		echo $this->Form->input('name_en', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('description', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('category_id', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$category_opt, 'empty'=>'----Please Select----', 'required'));
		echo $this->Form->input('brand_id', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$brand_opt, 'empty'=>'----Please Select----', 'required'));
		echo $this->Form->input('model', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('cost', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('price', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('enable', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>array('Y'=>'Yes', 'N'=>'No'), 'empty'=>FALSE));
        
        echo $this->Html->link(__('Back'), array('action'=>'index'), array('class'=>'btn btn-default'));
        echo $this->Form->button(__('Next'), array('type'=>'submit', 'class'=>'btn btn-default pull-right'));
    ?>
</div>