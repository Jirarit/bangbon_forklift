<div class="content-header">
    <h1 class="page-header"><?php echo __('Contract'); ?></h1>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-xs-7 col-sm-5 col-md-3 col-lg-3">
            <?php
                echo $this->Form->create('Contract', array('class'=>'form-inline'));
                echo '<div class="input-group">';
                echo $this->Form->input('search', array('id'=>'ContractSearch1', 'div'=>FALSE, 'class'=>'form-control', 'label'=>FALSE, 'placeholder'=>'Search for ...'));
                echo '<span class="input-group-btn">';
                echo $this->Form->button('<i class="fa fa-search fa-fw"></i>', array('type' => 'submit', 'class'=>'btn btn-default space-before-2'));
                echo '</span></div>';
                echo $this->Form->end();
            ?>
        </div>
        <div class="col-xs-2" style="padding: 0px">
            <button class="btn btn-default" onclick="return false;" data-toggle="modal" data-target="#searchModal">...</button>
        </div>
        <a class="pull-right" href="/Contracts/add"><i class="fa fa-plus-circle fa-fw fa-3x" data-toggle="tooltip" data-placement="left" title="Create Contract"></i></a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-condensed table-data-list">
                <thead>
                    <th class="text-center" style="width: 1px;">#</th>
                    <th><?php echo __('Contract') ?></th>
                    <th class="data-date"><?php echo __('Start') ?></th>
                    <th class="data-date"><?php echo __('End') ?></th>
                    <th><?php echo __('Customer') ?></th>
                    <th><?php echo __('Product') ?></th>
                    <th class="data-money"><?php echo __('Price') ?></th>
                    <th class="data-status"><?php echo __('Status') ?></th>
                    <th id="colAction" class="hidden-sm hidden-xs"><?php echo __('Actions'); ?></th>
                </thead>
                <?php foreach ($contracts as $k => $contract): ?>
                <tr data-toggle="modal" data-target="#recordAction" data-contract="<?php echo $contract['Contract']['contract_no']; ?>" data-id="<?php echo $contract['Contract']['id']; ?>">
                    <td class="text-center"><?php echo h($k+1); ?></td>
                    <td><?php echo h($contract['Contract']['contract_no']); ?>&nbsp;</td>
                    <td><?php echo h($contract['Contract']['contract_start']); ?>&nbsp;</td>
                    <td><?php echo h($contract['Contract']['contract_expire']); ?>&nbsp;</td>
                    <td>
                        <?php echo h($contract['Customer']['name']); ?><br>
                        <small>
                            <?php echo $contract['CustomerLocation']['branch_name'] . $contract['CustomerLocation']['zone_name']; ?>
                        </small>
                    </td>
                    <td>
                        <?php echo h($contract['Serial']['serial_no']); ?><br>
                        <small>
                            <?php echo $contract['Product']['name'] . $contract['Product']['model']; ?>
                        </small>
                    </td>
                    <td class="hidden-sm hidden-xs fit-content"><?php echo h($contract['Contract']['modified']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs text-center" style="width: 180px">
                        <div class="btn-group" role="group" aria-label="...">
                        <?php
                            echo $this->Html->link(__('View'), array('action' => 'view', $contract['Contract']['id']), array('class'=>'btn btn-default btn-action'));
                            echo $this->Html->link(__('Edit'), array('action' => 'edit', $contract['Contract']['id']), array('class'=>'btn btn-default btn-action'));
                            echo $this->Html->link(__('Delete'), array('action' => 'delete', $contract['Contract']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $contract['Contract']['login']), 'class'=>'btn btn-default btn-action'));
                        ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <ul class="pagination pagination-sm" style="vertical-align: middle;">
        <?php
            //echo $this->Paginator->prev(__('<<'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            //echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
            //echo $this->Paginator->next(__('>>'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
        ?>
    </ul>
    <div class="pull-right">
        <?php //echo $this->Paginator->counter(array('format' => __('Records out of {:count} total'))); ?>
    </div>
</div>


<!--/* Modal for mobile action */-->
<div class="modal fade" id="recordAction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="exampleModalLabel">Contract</h2>
            </div>
            <div class="modal-body text-center">
                <?php
                    echo $this->Html->link(__('View'), '#', array('id'=>'btnView', 'class'=>'btn btn-default btn-lg btn-block icon-info-before'));
                    echo $this->Html->link(__('Edit'), '#', array('id'=>'btnEdit', 'class'=>'btn btn-default btn-lg btn-block icon-pencil-before'));
                    echo $this->Html->link(__('Delete'), '#', array('id'=>'btnDel', 'confirm' => __('Are you sure you want to delete # %s?', $contract['Contract']['login']), 'class'=>'btn btn-danger btn-lg btn-block icon-bin-before', 'style'=>'margin-top:5px'));
                ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Filter</h2>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('Contract', array('role'=>'form')); ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo $this->Form->input('search', array('id'=>'ContractSearch2', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'label'=>'Keyword', 'placeholder'=>'PO, PR, Serial ...')); ?>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <?php
                        echo '<label for="ContractStartFrom">Start Date</label>';
                        echo '<div class="input-group input-group-date">';
                        echo $this->Form->input('start_from', array('label'=>FALSE, 'div'=>FALSE, 'class'=>'form-control datePicker datePicker-readonly'));
                        echo '<span class="input-group-addon addon-to-date">To</span>';
                        echo $this->Form->input('start_to', array('label'=>FALSE, 'div'=>FALSE, 'class'=>'form-control datePicker datePicker-readonly'));
                        echo '</div>';
                        ?>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <?php
                        echo '<label for="ContractExpireFrom">Expire Date</label>';
                        echo '<div class="input-group input-group-date">';
                        echo $this->Form->input('expire_from', array('label'=>FALSE, 'div'=>FALSE, 'class'=>'form-control datePicker datePicker-readonly'));
                        echo '<span class="input-group-addon addon-to-date">To</span>';
                        echo $this->Form->input('expire_to', array('label'=>FALSE, 'div'=>FALSE, 'class'=>'form-control datePicker datePicker-readonly'));
                        echo '</div>';
                        ?>
                    </div>
                </div>
                <?php
                
                echo $this->Form->input('status', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->contractStatus()));
                
                ?>
            </div>
            <div class="modal-footer">
                <?php
                echo $this->Form->button(__('Search'), array('type'=>'submit', 'class'=>'btn btn-default pull-right'));
                echo $this->Form->end();
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
  var login = button.data('login'); // Extract info from data-* attributes
  var id = button.data('id'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text('Login: ' + login);
  modal.find('#btnView').attr('href','/Contracts/view/'+id);
  modal.find('#btnEdit').attr('href','/Contracts/edit/'+id);
  modal.find('#btnDel').attr('href','/Contracts/delete/'+id);
});

$('#searchModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('#ContractSearch2').val($('#ContractSearch1').val());
});
//$('.datePicker').data('DateTimePicker').widgetPositioning ({horizontal:'left'});
//$(".bootstrap-datetimepicker-widget").css('left', 0);
$('.datePicker').on("dp.show", function(e) {
    
    if($('.bootstrap-datetimepicker-widget').position().left < 0){
        $(this).data('DateTimePicker').widgetPositioning ({horizontal:'left'});
    }
    console.log($('.bootstrap-datetimepicker-widget').position());
    
    //$(this).data('DateTimePicker').widgetPositioning({horizontal:'left'});
    //console.log($(this).data('DateTimePicker').widgetPositioning());
});
</script>
