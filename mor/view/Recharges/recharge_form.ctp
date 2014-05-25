<!-- rechrage form -->
<?php echo $this->Form->create('Recharge',array('controller'=>'recharges','action'=>'recharge_now','novalidate'=>'novalidate'));?>
<fieldset>
<?php 
echo $this->Session->flash('recharge');
?>
<ul>
	
	<?php 
	 if(isset($RechargeType['RechargeType']['input_name1'])&& !empty($RechargeType['RechargeType']['input_name1'])){ ?>
	 	
	 	<li><?php  
    	echo $this->Form->input('number', array('error'=>false,
    	'div'=>false,'label'=>$RechargeType['RechargeType']['input_label1'],
    	'type'=>'text',
    	'between' =>'<span>',
    	'after'=>"</span>{$RechargeType['RechargeType']['input_notes1']}"));
    	?></li>
    	<?php 
	 }
	?>	
	
	<li>
	<?php 
	$opt=array(''=>'Select Service Provider');
    if($Operators){
    	foreach($Operators as $op){
    		$opt[$op['Operator']['id']]=$op['Operator']['name'];
    	}
    }
    echo $this->Form->input('operator_id', array('error'=>false,'label'=>'Operator','div'=>false,'options'=>$opt,'onchange'=>'showOperatorNotes(this.value);'));
	?>
    </li>
    
    <?php 
   	$cls='';
   	
   	if($RechargeType['RechargeType']['id']==8){
   		$cls='datepicker';
   	}
	
   	if(isset($RechargeType['RechargeType']['input_name2'])&& !empty($RechargeType['RechargeType']['input_name2'])){?>
	  	 <li>
	  	<?php 
    	echo $this->Form->input($RechargeType['RechargeType']['input_name2'], array('error'=>false,'div'=>false,
    	'type'=>'text',
    	'label'=>$RechargeType['RechargeType']['input_label2'],
    	'between' =>'<span>',
    	'after'=>"</span>{$RechargeType['RechargeType']['input_notes2']}",
    	'class'=>$cls));
    	?></li><?php 
    }?>
	    
    
	<li>
	<?php 
	echo $this->Form->input('amount', array('type'=>'text','error'=>false,'div'=>false,'between' =>'<span>','after'=>'</span>','label'=>'Amount'));
	?>
	</li>
	<li>
	<?php 
	echo $this->Form->input('type', array('type'=>'hidden','value'=>$RechargeType['RechargeType']['id']));
	echo $this->Form->input('input1', array('type'=>'hidden','value'=>$RechargeType['RechargeType']['input_name1']));
	echo $this->Form->input('input2', array('type'=>'hidden','value'=>$RechargeType['RechargeType']['input_name2']));
	
	echo $this->Form->input($RechargeType['RechargeType']['button_label'],array('label'=>false,'type'=>'submit','div'=>false,'value'=>$RechargeType['RechargeType']['button_label']));
	?>
	</li>
	
</ul>
</fieldset>
<?php echo $this->Form->end();?>