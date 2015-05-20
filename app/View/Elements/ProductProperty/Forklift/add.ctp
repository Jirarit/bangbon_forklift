<?php
echo $this->Form->input('type', array('label'=>'ชนิด(Type)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('capacity', array('label'=>'ขนาด(Capacity)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('mast', array('label'=>'เสาสูง(Mast)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('fork', array('label'=>'งายาว(Fork)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('gear', array('label'=>'เกียร์(Transmission)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->forkliftGear()));
echo $this->Form->input('engine', array('label'=>'เชื้อเพลิง(Engine)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control width-auto', 'options'=>$this->Flag->forkliftEngine()));
echo $this->Form->input('wheel', array('label'=>'ล้อ(Wheel)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('tire', array('label'=>'ยาง(Tire)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
echo $this->Form->input('attachment', array('label'=>'อุปกรณ์(Attachemnt)', 'div'=>array('class'=>'form-group'), 'class'=>'form-control'));
