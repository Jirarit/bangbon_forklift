<div class="content-header">
    <h1 class="page-header"><?php echo __('User'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="/Users/index">Index</a></li>
        <li class="active">Create user</li>
    </ol>
</div>

<div class="content-body">
    <?php 
        echo $this->Form->create('User', array('role'=>'form')); 
        echo $this->Form->input('login', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('pass', array('type'=>'password', 'id'=>'pass1', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'label'=>__('Password')));
		echo $this->Form->input('pass', array('type'=>'password', 'id'=>'pass2', 'div'=>array('class'=>'form-group'), 'class'=>'form-control', 'label'=>__('Confirm Password')));
		echo $this->Form->input('name', array('div'=>array('class'=>'form-group'), 'class'=>'form-control'));
		echo $this->Form->input('enable', array('div'=>array('class'=>'form-group'), 'class'=>'form-control', 'options'=>array('Y'=>'Yes', 'N'=>'No')));
        echo $this->Form->button(__('Submit'), array('type'=>'submit', 'class'=>'btn btn-default'));
        echo "&nbsp;";
        echo $this->Html->link(__('Back'), array('action'=>'index'), array('class'=>'btn btn-default'));
    ?>
</div>

<script>
$( "form" ).submit(function( event ) {
    if($('#pass1').val() !== $('#pass2').val()){
        alert('Password not match');
        return false;
    }
    return true;
});
</script>