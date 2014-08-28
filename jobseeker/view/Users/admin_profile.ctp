<div class="actions">
	<h3><?php echo __('Profile'); ?></h3>
</div>

<div class="users form">
<?php echo $this->Form->create('User');?>
<fieldset>
<legend><?php echo __('Edit Profile'); ?></legend>

<div class="left_sec">
<h4><label>Login Info:</label></h4>
<?php
		echo $this->Form->input('email',array('disabled'=>'disabled'));
		echo $this->Form->input('password');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		//echo $this->Form->input('user_status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		echo $this->Form->input('user_description',array('style'=>'width:185px'));	
	?>
	</div>
<div class="right_sec">
<h4><label>Contact Info:</label></h4>
<?php
		echo $this->Form->input('address');
		echo $this->Form->input('phone');
		
		$states=array();
		$country=array();
		if(isset($Country)){
			foreach($Country as $Countryx){
				$country[$Countryx['Country']['country_id']]=$Countryx['Country']['country_name'];
			}
		}
		echo $this->Form->input('country_id',array('options'=>$country,'selected'=>$this->Form->value("country_id"),
		'style'=>'width:200px','onchange'=>'get_states(this.value);'));
		
		$states=array('0'=>'');
		
		$selected=$this->Form->value("state_id");
		if(isset($State) && isset($selected)){
			foreach($State as $Statex){
				$states[$Statex['State']['state_id']]=$Statex['State']['state_name'];
			}
		}
		echo $this->Form->input('state_id',array('options'=>$states,'selected'=>$selected,'style'=>'width:200px','id'=>'user_state_id'));				
		
		
		echo $this->Form->input('city');
		echo $this->Form->input('zip_code');
		echo $this->Form->input('user_id',array('type'=>'hidden'));?>

</div>

</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>
<script type="text/javascript">
function get_states(cId){
	$.post('<?php echo $this->webroot;?>common/get_states',{id:cId},function(data){						
		$("#user_state_id").html(data);
	});
}
</script>
