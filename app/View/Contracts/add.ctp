<div class="content-header">
    <h1 class="page-header"><?php echo __('Contract'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Contracts/index">Index</a></li>
        <li class="active">Create contract</li>
    </ol>
</div>
<div style="position: relative;"></div>
<div class="content-body">
    <?php 
        echo $this->Form->create('Contract', array('role'=>'form')); 
		echo $this->Form->input('contract_no', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('contract_date', array('type'=>'text', 'div'=>array('class'=>'form-group', 'style'=>'position: relative;'), 'class'=>'form-control datePicker'));
        echo $this->Form->input('contract_expire', array('type'=>'text', 'div'=>array('class'=>'form-group', 'style'=>'position: relative;'), 'class'=>'form-control datePicker'));
        echo '<div class="form-group">';
        echo $this->Form->button('Select Product', array('type' => 'button', 'class'=>'btn btn-default', 'onclick'=>'return false;', 'data-toggle'=>'modal', 'data-target'=>'#selectProduct'));
        echo $this->Form->hidden('product_id', array('id'=>'ContractProductID'));
		echo $this->Form->hidden('product_serial_id', array('id'=>'ContractProductSerialID'));
        echo ' <span id="productSelected"></span>';
        echo '</div>';
        echo '<div class="form-group">';
        echo $this->Form->button('Select Customer', array('type' => 'button', 'class'=>'btn btn-default', 'onclick'=>'return false;', 'data-toggle'=>'modal', 'data-target'=>'#selectCustomer'));
        echo $this->Form->hidden('customer_id', array('id'=>'ContractCustomerID'));
		echo $this->Form->hidden('customer_location_id', array('id'=>'ContractCustomerLocationID'));
		echo ' <span id="customerSelected"></span>';
        echo '</div>';
        echo $this->Form->input('ref_car_no', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('ref_quotation_no', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('ref_pr_no', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('ref_po_no', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('price', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('status', array('div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->contractStatus()));
        echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo "&nbsp;";
        echo $this->Html->link(__('Back'), array('action'=>'index'), array('class'=>'btn btn-default'));
        echo $this->Form->end();
    ?>
</div>





<div class="modal fade" id="selectProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Select Product</h2>
            </div>
            <div class="modal-body">
                <input id="searchProduct" placeholder="Search" class="form-control">
                <table id="table-product" class="table table-striped table-condensed table-data-list">
                    <tr>
                        <th>Serial</th><th>Product</th><th>Brand</th><th></th>
                    </tr>
                    <?php foreach($products as $p){ ?>
                    <tr data-keysearch="<?php echo $p[0]['serial_no'] . '|'. $p[0]['name'] . '|' . $p[0]['brand'] ; ?>">
                        <td><?php echo $p[0]['name'] ?></td>
                        <td><?php echo $p[0]['serial_no'] ?></td>
                        <td><?php echo $p[0]['brand'] ?></td>
                        <td class="width-auto"><?php echo $this->Form->button('Select', array('type' => 'button', 'class'=>'btn btn-default btn-sm', 'onclick'=>"selectProduct('{$p[0]['product_id']}', '{$p[0]['product_serial_id']}', '{$p[0]['name']}', '{$p[0]['serial_no']}');")); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="selectCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Select Customer</h2>
            </div>
            <div class="modal-body">
                <input id="searchCustomer" placeholder="Search" class="form-control">
                <table id="table-customer" class="table table-striped table-condensed table-data-list">
                    <tr>
                        <th>Customer</th><th>Branch</th><th>Zone</th><th></th>
                    </tr>
                    <?php foreach($customers as $c){ ?>
                    <tr data-keysearch="<?php echo $c[0]['customer_name'] . '|'. $c[0]['branch_name'] . '|' . $c[0]['zone_name'] ; ?>">
                        <td><?php echo $c[0]['customer_name'] ?></td>
                        <td><?php echo $c[0]['branch_name'] ?></td>
                        <td><?php echo $c[0]['zone_name'] ?></td>
                        <td class="width-auto"><?php echo $this->Form->button('Select', array('type' => 'button', 'class'=>'btn btn-default btn-sm', 'onclick'=>"selectCustomer('{$c[0]['customer_id']}', '{$c[0]['customer_location_id']}', '{$c[0]['customer_name']}', '{$c[0]['branch_name']}', '{$c[0]['zone_name']}');")); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    
function selectProduct(product_id, product_serial_id, product_name, serial_no){
    document.getElementById("ContractProductID").value = product_id;
    document.getElementById("ContractProductSerialID").value = product_serial_id;
    document.getElementById("productSelected").innerHTML = '<strong>Product: </strong>' + product_name + ' <strong>Serial: </strong>' + serial_no;
    $('#selectProduct').modal('hide');
}

$( "#searchProduct" ).keyup(function() {
    var text = $(this).val().toLowerCase();
    if(text === ''){
        $("table#table-product tr").show();
    }else{
        $("table#table-product tr").not(':first').hide();
        $("table#table-product tr[data-keysearch]").filter(function(){return $(this).attr('data-keysearch').toLowerCase().indexOf(text) >= 0;}).show();
    }
});


    
function selectCustomer(customer_id, location_id, customer_name, branch, zone){
    document.getElementById("ContractCustomerID").value = customer_id;
    document.getElementById("ContractCustomerLocationID").value = location_id;
    document.getElementById("customerSelected").innerHTML = customer_name + ' ' + branch + ' ' + zone;
    $('#selectCustomer').modal('hide');
}

$( "#searchCustomer" ).keyup(function() {
    var text = $(this).val().toLowerCase();
    if(text === ''){
        $("table#table-customer tr").show();
    }else{
        $("table#table-customer tr").not(':first').hide();
        $("table#table-customer tr[data-keysearch]").filter(function(){return $(this).attr('data-keysearch').toLowerCase().indexOf(text) >= 0;}).show();
    }
});

</script>