<div class="content-header">
    <h1 class="page-header"><?php echo __('Contract'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Contracts/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <table class="table">
        <tr>
            <td><?php echo __('ID'); ?></td><td><?php echo h($contract['Contract']['id']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Contract No.'); ?></td><td><?php echo h($contract['Contract']['contract_no']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Contract Date'); ?></td><td><?php echo h($contract['Contract']['contract_date']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Contract Expire'); ?></td><td><?php echo h($contract['Contract']['contract_expire']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Product'); ?></td><td><?php echo h($contract['Product']['name']); ?><br></td>
        </tr>
        <tr>
            <td><?php echo __('Customer'); ?></td><td><?php echo h($contract['Customer']['name']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Ref. Car No.'); ?></td><td><?php echo h($contract['Contract']['ref_car_no']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Ref. Quotation No.'); ?></td><td><?php echo h($contract['Contract']['ref_quotation_no']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Ref. PR No.'); ?></td><td><?php echo h($contract['Contract']['ref_pr_no']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Ref. PO No.'); ?></td><td><?php echo h($contract['Contract']['ref_po_no']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Price'); ?></td><td><?php echo h(number_format($contract['Contract']['price'], 2)); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Status'); ?></td><td><?php echo h($this->Flag->ContractStatus($contract['Contract']['status'])); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Created'); ?></td><td><?php echo h($contract['Contract']['created']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Modified'); ?></td><td><?php echo h($contract['Contract']['modified']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Version'); ?></td><td><?php echo h($contract['Contract']['_version']); ?></td>
        </tr>
    </table>
    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contract['Contract']['id']), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contract['Contract']['id']), array('class'=>'btn btn-danger col-lg-1 col- col-xs-4 pull-right icon-bin-before'), __('Are you sure you want to delete # %s?', $contract['Contract']['contract_no'])); ?>
    </div>
</div>