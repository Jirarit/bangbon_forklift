<div class="content-header">
    <h1 class="page-header"><?php echo __('Customer'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Customers/index">Index</a></li>
        <li class="active">Info</li>
    </ol>
</div>

<div class="content-body">
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li><a href="/Customers/view/<?php echo $customer_id; ?>">Info</a></li>
            <li class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Locations</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="col-xs-12 text-right">
                <a href="/Customers/add_location/<?php echo $customer_id ?>"><i class="fa fa-plus-circle fa-fw fa-3x" data-toggle="tooltip" data-placement="left" title="Add location"></i></a>
            </div>
            <table class="table">
                <?php 
                if(!empty($locations)){
                    $branch = '';
                    foreach($locations as $location){
                        echo '<tr>';
                        $id = $location['CustomerLocation']['id'];
                        $zone = $location['CustomerLocation']['zone_name'];
                        if($branch != $location['CustomerLocation']['branch_name']){
                            $branch = $location['CustomerLocation']['branch_name'];
                            echo "<th class='fit-content'>{$branch}</th>";
                        }else{
                            echo "<td style='border-top-style: none;'></td>";
                        }
                        $edit = "<a href='/Customers/edit_location/{$customer_id}/{$id}'><i class='fa fa-pencil fa-fw'></i></a>";
                        $delete = "<a href='/Customers/del_location/{$customer_id}/{$id}'><i class='fa fa-trash fa-fw'></i></a>";
                        echo "<td class='fit-content'>- {$zone}</td><td>{$edit} {$delete}</td>";
                        echo '</tr>';
                    }
                }else{
                    echo "<tr><td style='border-top-style: none;' class='text-center'>No data</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <div class="row" style="margin: 0px">
        <?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class'=>'btn btn-default col-lg-1 col-xs-4 icon-back-before')); ?>
    </div>
</div>