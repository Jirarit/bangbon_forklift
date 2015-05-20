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
        <i class="btn btn-info btn-circle fa fa-check" style="cursor:default;"></i><br>Property
    </div>
    <div class="col-xs-2 col-lg-2" style="padding: 0px">
        <hr>
    </div>
    <div class="col-xs-2 col-lg-1 text-center" style="padding: 0px;">
        <i class="btn btn-default btn-circle" style="cursor:default;">3</i><br>Serial
    </div>
</div>
<br>
<div class="content-body">
    <div class="row">
        <div class="col-xs-12">Total Serial: <?php echo count($serials) ?></div>
    <?php 
        foreach ($serials as $k => $serial): 
            $limit_char = 30;
            $serial_no = $serial['no'];
            $to_long = (strlen($serial_no) > $limit_char);
            $short = substr($serial_no, 0, $limit_char-3) . ($to_long ? '...' : '');
            $status = $this->Flag->serialStatus($serial['status']);
            $popover = 'data-toggle="popover" data-placement="top" data-content="<strong>'.$serial_no.'</strong><br>MFG: '.$serial['date'].'<br>'.$status.'"';
            $err = isset($serial['error']) ? "panel-red" : "";
    ?>
        <div class="col-lg-4 col-xs-12">
            <div class="panel panel-primary <?=$err?>" <?=$popover?>>
                <button onclick="location.href='/Products/add_serial_rm/<?php echo $k ?>'" type="button" class="close" style="padding-right: 5px;"><span aria-hidden="true">&times;</span></button>
                <div class="panel-heading">
                    <?php echo $short; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
        <div class="col-lg-4 col-xs-12">
            <div class="panel panel-primary" data-toggle="modal" data-target="#addSerial" style="cursor: pointer;">
                <div class="panel-heading text-center" style="background-color: window;color: #666666;">
                    <i class="fa fa-plus"></i> Add Serial
                </div>
            </div>
        </div>
        
    </div>
    <?php
        echo $this->Html->link(__('Back'), array('action'=>'add_property'), array('class'=>'btn btn-default'));
        echo $this->Html->link(__('Submit'), array('action'=>'submit_add'), array('class'=>'btn btn-default pull-right'));
    ?>
</div>

<div class="modal fade" id="addSerial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add new serial</h4>
      </div>
      <div class="modal-body">
        <?php
        echo $this->Form->create('Serial', array('url'=>array('controller'=>'Products', 'action'=>'add_serial_add'),'role'=>'form'));
        echo $this->Form->input('no', array('label'=>'Serial', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'required'));
        echo $this->Form->input('date', array('label'=>'MFG', 'div'=>array('class'=>'form-group'), 'class'=>'form-control datePicker', 'default'=>date('Y-m-d'), 'style'=>'background-color:white;', 'required'));
        echo $this->Form->input('status', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->serialStatus()));
        echo $this->Form->button(__('Add'), array('type'=>'submit', 'class'=>'btn btn-default'));
        ?>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<script>

$('#addSerial').on('show.bs.modal', function (event) {
  var modal = $(this);
});
</script>