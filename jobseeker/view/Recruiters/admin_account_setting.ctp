<div class="actions">
<span class="img_box">
                    <?php if($Recruiter['Recruiter']['profile_photo']!=''){?>
                    <img src="<?php echo $this->webroot;?>files/recruiter_images/<?php echo $Recruiter['Recruiter']['profile_photo'];?>" alt="" width="150" height="160"/>
                    <?php }else{?>
                    	<img src="<?php echo $this->webroot;?>images/profile_pic.png" alt=""/>
                    <?php }?>
                    	
        </span>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Delete Recruiter', true), array('action' => 'delete', $Recruiter['Recruiter']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $Recruiter['Recruiter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recruiter', true), array('action' => 'index')); ?> </li>

	</ul>
</div>
<div class="professional view">
	<h2><?php echo __('Manage Recruter Account');?></h2>
    <span>
      <p style="margin-top: 25px;">
         Account Status :
         <a href="javascript:void(0)" id="status_acc_<?php echo $setting['Recruiter']['id']?>" onclick="recu_change_status('<?php echo $setting['Recruiter']['status']?>','<?php echo $setting['Recruiter']['id']?>','status');"><?php if($setting['Recruiter']['status']=='0') echo 'Activate'; else echo 'Deactivate'; ?></a>
      </p>
      <p>
        Search Status : 
         <a href="javascript:void(0)" id="status_search_<?php echo $setting['Recruiter']['id']?>" onclick="recu_change_status('<?php echo $setting['Recruiter']['flag_search']?>','<?php echo $setting['Recruiter']['id']?>','flag_search');"><?php if($setting['Recruiter']['flag_search']=='0') echo 'Activate'; else echo 'Deactivate'; ?></a>
      </p>
    </span>  
</div>

<script type="text/javascript">

 function recu_change_status(val,id,field){
		  var status = 1;
		  var txt='Deactivate';
		  if(val==1){
		   status = 0;	   
		   txt = 'Activate'; 
		  }
	  $.ajax({
		       'url' 	  : '<?php echo $this->webroot;?>admin/recruiters/rec_change_status',
			   'type' 	  : 'post',
			   'data'     : {status:status,id:id,field:field},
			   'success'  : function(res){
					   if(field == 'status')
						 $("#status_acc_"+id).text(txt);
					   else
						 $("#status_search_"+id).text(txt);
					} 
	  });
  }

</script>
