<div class="content-header">
    <h1 class="page-header"><?php echo __('Product'); ?></h1>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-xs-8 col-md-10">
            <?php
                echo $this->Form->create('Product', array('class'=>'form-inline'));
                echo '<div class="input-group">';
                echo $this->Form->input('search', array('div'=>FALSE, 'class'=>'form-control', 'label'=>FALSE, 'placeholder'=>'Search for ...'));
                echo '<span class="input-group-btn">';
                echo $this->Form->button('<i class="fa fa-search fa-fw"></i>', array('type' => 'submit', 'class'=>'btn btn-default space-before-2'));
                echo $this->Form->end();
                echo '</span></div>';
            ?>
        </div>
        <div class="col-xs-4 col-md-2 text-right">
            <a href="/Products/add"><i class="fa fa-plus-circle fa-fw fa-3x" data-toggle="tooltip" data-placement="left" title="Create Product"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-condensed table-data-list">
                <thead>
                    <th class="text-center" style="width: 1px;">#</th>
                    <th class="sorting"><?php echo $this->Paginator->sort('name'); ?></th>
                    <th class="sorting hidden-sm hidden-xs"><?php echo $this->Paginator->sort('ProductBrand.name', 'Brand'); ?></th>
                    <th class="sorting hidden-sm hidden-xs"><?php echo $this->Paginator->sort('model'); ?></th>
                    <th class="sorting"><?php echo $this->Paginator->sort('cost'); ?></th>
                    <th class="hidden-sm hidden-xs"><?php echo $this->Paginator->sort('modified'); ?></th>
                    <th id="colAction" class="hidden-sm hidden-xs"><?php echo __('Actions'); ?></th>
                </thead>
                <?php foreach ($products as $k => $product): ?>
                <tr data-toggle="modal" data-target="#recordAction" data-name="<?php echo $product['Product']['name']; ?>" data-id="<?php echo $product['Product']['id']; ?>">
                    <td class="text-center"><?php echo h($k+1); ?></td>
                    <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs"><?php echo h($product['Brand']['name']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs"><?php echo h($product['Product']['model']); ?>&nbsp;</td>
                    <td class="data-money"><?php echo h($product['Product']['cost']); ?></td>
                    <td class="hidden-sm hidden-xs fit-content"><?php echo h($product['Product']['modified']); ?>&nbsp;</td>
                    <td class="hidden-sm hidden-xs text-center" style="width: 180px">
                        <div class="btn-group" role="group" aria-label="...">
                        <?php
                            echo $this->Html->link(__('View'), array('action' => 'view', $product['Product']['id']), array('class'=>'btn btn-default btn-action'));
                            echo $this->Html->link(__('Edit'), array('action' => 'edit', $product['Product']['id']), array('class'=>'btn btn-default btn-action'));
                            echo $this->Html->link(__('Delete'), array('action' => 'delete', $product['Product']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $product['Product']['name']), 'class'=>'btn btn-default btn-action'));
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
            echo $this->Paginator->prev(__('<<'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
            echo $this->Paginator->next(__('>>'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
        ?>
    </ul>
    <div class="pull-right">
        <?php echo $this->Paginator->counter(array('format' => __('Records out of {:count} total'))); ?>
    </div>
</div>


<!--/* Modal for mobile action */-->
<div class="modal fade" id="recordAction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="exampleModalLabel">Product</h2>
            </div>
            <div class="modal-body text-center">
                <?php
                    echo $this->Html->link(__('View'),  '#', array('id'=>'btnView', 'class'=>'btn btn-default btn-lg btn-block icon-info-before'));
                    echo $this->Html->link(__('Edit'),  '#', array('id'=>'btnEdit', 'class'=>'btn btn-default btn-lg btn-block icon-pencil-before'));
                    echo $this->Html->link(__('Delete'),  '#', array('id'=>'btnDel', 'confirm' => __('Are you sure you want to delete # %s?', $product['Product']['name']), 'class'=>'btn btn-danger btn-lg btn-block icon-bin-before', 'style'=>'margin-top:5px'));
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
  var name = button.data('name'); // Extract info from data-* attributes
  var id = button.data('id'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text(name);
  modal.find('#btnView').attr('href','/Products/view/'+id);
  modal.find('#btnEdit').attr('href','/Products/edit/'+id);
  modal.find('#btnDel').attr('href','/Products/delete/'+id);
});
</script>