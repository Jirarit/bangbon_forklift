<div class="content-header">
    <h1 class="page-header"><?php echo __('Brand'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/ProductBrands/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <table class="table">
        <tr>
            <td style="border-top-style: none;"><?php echo __('ID'); ?></td>
            <td style="border-top-style: none;"><?php echo h($productBrand['ProductBrand']['id']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Name'); ?></td><td><?php echo h($productBrand['ProductBrand']['name']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Name (EN)'); ?></td><td><?php echo h($productBrand['ProductBrand']['name_en']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Enable'); ?></td><td><?php echo h($productBrand['ProductBrand']['enable']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Created'); ?></td><td><?php echo h($productBrand['ProductBrand']['created']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Modified'); ?></td><td><?php echo h($productBrand['ProductBrand']['modified']); ?></td>
        </tr>
        <tr>
            <td class="fit-content"><?php echo __('Version'); ?></td><td><?php echo h($productBrand['ProductBrand']['_version']); ?></td>
        </tr>
    </table>

    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productBrand['ProductBrand']['id']), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-pencil-before')); ?>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $productBrand['ProductBrand']['id']), array('class'=>'btn btn-danger col-lg-1 col- col-xs-4 pull-right icon-bin-before'), __('Are you sure you want to delete # %s?', $productBrand['ProductBrand']['name'])); ?>
    </div>
</div>