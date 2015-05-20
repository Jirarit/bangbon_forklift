<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Products/index">Index</a></li>
        <li class="active">Create product</li>
    </ol>
</div>

<div class="row">
    <div class="col-xs-offset-1 col-lg-offset-2 col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-info btn-circle fa fa-check" style="cursor: default;"></i><br>General
    </div>
    <div class="col-xs-2 col-lg-2" style="padding: 0px">
        <hr>
    </div>
    <div class="col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-default btn-circle" style="cursor:default;">2</i><br>Property
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
    echo $this->Form->create('Property', array('role'=>'form'));
    echo $this->Form->hidden('code');
    switch ($this->data['Property']['code']) {
        case 'forklifts':
            echo $this->element('ProductProperty/Forklift/add');
            break;
        default:
            echo "<h4 class='text-center'>{$this->data['Property']['code']} property not found</h4>";
            break;
    }

    echo $this->Html->link(__('Back'), array('action'=>'add'), array('class'=>'btn btn-default'));
    echo $this->Form->button(__('Next'), array('type'=>'submit', 'class'=>'btn btn-default pull-right'));
    ?>
</div>