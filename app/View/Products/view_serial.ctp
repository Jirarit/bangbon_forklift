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
            <li><a href="/Products/index/">Info</a></li>
            <li><a href="/Products/view_property/<?php echo $product_id; ?>">Property</a></li>
            <li class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Serial</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <a class="pull-right" data-toggle="modal" data-target="#addSerial"><i class="fa fa-plus-circle fa-fw fa-3x" data-toggle="tooltip" data-placement="left" title="Add Serial"></i></a>
            
            <table class="table table-striped table-condensed table-data-list">
                <thead>
                    <th class="text-center" style="width: 1px;">#</th>
                    <th class="sorting"><?php echo $this->Paginator->sort('serial_no', 'Serial'); ?></th>
                    <th class="sorting hidden-sm hidden-xs data-date"><?php echo $this->Paginator->sort('manufacture_date', 'MFG'); ?></th>
                    <th class="sorting hidden-sm hidden-xs data-date"><?php echo $this->Paginator->sort('age'); ?></th>
                    <th class="sorting"><?php echo $this->Paginator->sort('status'); ?></th>
                    <th class="hidden-sm hidden-xs"><?php echo $this->Paginator->sort('modified'); ?></th>
                    <th id="colAction" class="hidden-sm hidden-xs"><?php echo __('Actions'); ?></th>
                </thead>
                <?php 
                    foreach ($serials as $k => $serial): 
                        $age = ($serial['ProductSerial']['age'] === '00:00:00') ? "0 day" : $serial['ProductSerial']['age'];
                ?>
                <tr data-toggle="modal" data-target="#recordAction" data-id="<?=$serial['ProductSerial']['id']?>" data-serial="<?=$serial['ProductSerial']['serial_no']?>" data-date="<?=$serial['ProductSerial']['manufacture_date']?>" data-status="<?=$serial['ProductSerial']['status']?>">
                    <td class="text-center"><?php echo h($k+1); ?></td>
                    <td><?php echo h($serial['ProductSerial']['serial_no']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs"><?php echo h($serial['ProductSerial']['manufacture_date']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs"><?php echo h($age); ?>&nbsp;</td>
                    <td class="fit-content data-status"><?php echo h($this->Flag->serialStatus($serial['ProductSerial']['status'])); ?></td>
                    <td class="hidden-sm hidden-xs fit-content"><?php echo h($serial['ProductSerial']['modified']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs text-center" style="width: 180px">
                        <div class="btn-group" role="group" aria-label="...">
                        <?php
                            echo $this->Html->link(__('Edit'), '#', array('class'=>'btn btn-default btn-action','data-toggle'=>"modal", 'data-target'=>"#editSerial", 'data-id'=>$serial['ProductSerial']['id'], 'data-serial'=>$serial['ProductSerial']['serial_no'], 'data-date'=>$serial['ProductSerial']['manufacture_date'], 'data-status'=>$serial['ProductSerial']['status']));
                            //echo $this->Html->link(__('Activity'), array('action' => 'activity', $product_id, $serial['ProductSerial']['id']), array('class'=>'btn btn-default btn-action'));
                            echo $this->Html->link(__('Delete'), array('action' => 'delete', $product_id, $serial['ProductSerial']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $serial['ProductSerial']['serial_no']), 'class'=>'btn btn-default btn-action'));
                        ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="editSerial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit serial</h4>
      </div>
      <div class="modal-body">
        <?php
        echo $this->Form->create('Serial', array('url'=>array('controller'=>'Products', 'action'=>'update_serial', $product_id),'role'=>'form'));
        echo $this->Form->hidden('id', array('id'=>'editId'));
        echo $this->Form->input('serial_no', array('id'=>'editNo', 'label'=>'Serial', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'required'));
        echo $this->Form->input('manufacture_date', array('id'=>'editDate', 'label'=>'MFG', 'div'=>array('class'=>'form-group'), 'class'=>'form-control datePicker', 'style'=>'background-color:white;', 'required'));
        echo $this->Form->input('status', array('id'=>'editStatus', 'div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->serialStatus()));
        echo $this->Form->button(__('Update'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo $this->Form->end();
        ?>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
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
        echo $this->Form->create('Serial', array('url'=>array('controller'=>'Products', 'action'=>'create_new_serial', $product_id),'role'=>'form'));
        echo $this->Form->input('no', array('label'=>'Serial', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'required'));
        echo $this->Form->input('date', array('label'=>'MFG', 'div'=>array('class'=>'form-group'), 'class'=>'form-control datePicker', 'default'=>date('Y-m-d'), 'style'=>'background-color:white;', 'required'));
        echo $this->Form->input('status', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->serialStatus()));
        echo $this->Form->button(__('Add'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo $this->Form->end();
        ?>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<!--/* Modal for mobile action */-->
<div class="modal fade" id="recordAction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="exampleModalLabel">Brand</h2>
            </div>
            <div class="modal-body text-center">
                <?php
                    echo $this->Html->link(__('Edit'), '#', array('id'=>'btnEdit', 'class'=>'btn btn-default btn-lg btn-block icon-pencil-before','data-toggle'=>"modal", 'data-target'=>"#editSerial", 'data-id'=>'', 'data-serial'=>'', 'data-date'=>'', 'data-status'=>''));
                    //echo $this->Html->link(__('Activity'), '#', array('id'=>'btnActivity', 'class'=>'btn btn-default btn-lg btn-block icon-list-before'));
                    echo $this->Html->link(__('Delete'),  '#', array('id'=>'btnDel', 'class'=>'btn btn-danger btn-lg btn-block icon-bin-before', 'style'=>'margin-top:5px'));
                ?>
            </div>
        </div>
    </div>
</div>

<script>
if ($('#colAction').is(':hidden') === false) {
    $('#recordAction').removeAttr('id');
}
$('#recordAction').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id');
    var serial = button.data('serial');
    var date = button.data('date');
    var status = button.data('status'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(serial);
    modal.find('#btnEdit').attr('data-id', id);
    modal.find('#btnEdit').attr('data-serial', serial);
    modal.find('#btnEdit').attr('data-date', date);
    modal.find('#btnEdit').attr('data-status', status);
    modal.find('#btnActivity').attr('href','/Products/activity/'+<?=$product_id?>+'/'+id);
    modal.find('#btnDel').attr('href','/Products/delete_serial/'+<?=$product_id?>+'/'+id);
});

$('#btnDel').on('click', function(){
    if (confirm("Are you sure you want to delete # "+$('#btnEdit').attr('data-serial')+"?")) { 
        return true; 
    }
    return false;
});

$('#addSerial').on('show.bs.modal', function (event) {
  var modal = $(this);
});

$('#editSerial').on('show.bs.modal', function (event) {
    $('#recordAction').modal('hide');
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var serial = button.data('serial');
    var date = button.data('date');
    var status = button.data('status');

    var modal = $(this);
    modal.find('#editId').val(id);
    modal.find('#editNo').val(serial);
    modal.find('#editDate').val(date);
    modal.find('#editStatus').val(status);
    $('#editDate').data('DateTimePicker').date(date);
});
</script>