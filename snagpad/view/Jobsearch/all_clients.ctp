<div id="success_message" style="display:none;"></div>

<div class="settings_mail">
<form id="clientselectForm" name="clientselectForm" method="post" action="">
        <input type="hidden" name="country" value="<?php echo $data['country'];?>" />
        <input type="hidden" name="city" value="<?php echo $data['city'];?>" />
        <input type="hidden" name="state" value="<?php echo $data['state'];?>" />
        <input type="hidden" name="job_url" value="<?php echo $data['job_url'];?>" />
        <input type="hidden" name="position_available" value="<?php echo $data['position'];?>" />
        <input type="hidden" name="company_name" value="<?php echo $data['company'];?>" />
         <input type="hidden" name="resource_id" value="1" />
        <input type="hidden" name="div_id" id="div_id" value="<?php echo $data['resource'];?>" />
       <fieldset>
       
       
        <section class="row">
        <label style="padding:5px 0 0 0; width:310px">Position :</label>
        <span class="notes"  style="width:395px"><?php echo $data['position']; ?></span>
        </section>
        
        <section class="row">
        <label style="padding:5px 0 0 0; width:310px">Company :</label>
        <span class="notes"  style="width:395px"><?php echo $data['company']; ?></span>
        </section>
        
         <section class="row">
    	  <label style="padding:5px 0 0 0; width:310px">Location :</label>
        <span class="notes"  style="width:395px"><?php if(!empty($data['city'])){ echo $data['city'].', '; }
														if(!empty($data['state'])){ echo $data['state'].', ';}
														echo $data['country']; ?></span>
        </section>
        
         <section class="row" style="width:760px">
        <?php if(isset($clients)){ ?>
       
        <label style="width:310px">Select Clients* :</label>
        <select name="to_users[]"  style="width:420px" id="trclient" class="required select"  multiple="multiple" size="4" onchange="changeclient()">
        <?php if(!empty($clients)){ ?><option value="0">All Clients</option><?php } ?>
        <?php foreach($clients as $cl)
        	echo "<option value='".$cl['Client']['id']."'>".$cl['Client']['name']."</option>";
		?>
        </select>
        
        </section>
       
        <br/>
         <section class="row" style="text-align:center; width:100%">
        <input type="submit" value="Add Card" class="submitbtn" style="margin:37px 0 0 0 !important; float:none !important"/>
         </section>
         <?php } ?>
        </fieldset>
        </form>
</div>        
<script language="javascript">
$(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);	
    $("#clientselectForm").validate({
		submitHandler: function(form){	
			var cl_frm=$('#clientselectForm').serialize();
			$('.settings_mail').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');		
			$.post('<?php echo SITE_URL; ?>/jobsearch/add_card_all_clients',cl_frm,function(dat){
					var div_id=$('#div_id').val();
					$('#div_1_'+div_id).html("<a href='javascript://' class='snagged'>Snagged</a>");
					$('.settings_mail').html('<div style="height:200px; margin-top:150px;text-align:center;">Card added to client(s) job board</div>');
					
					setTimeout(function(){ disablePopup()},2000);
				});	
		}
		
	});
});
function changeclient()
{
if(document.getElementById('trclient')!='undefined' && document.getElementById('trclient')!=null){
	if(document.getElementById('trclient').options[0].selected==true)
	{
		len=document.getElementById('trclient').options.length;
		for(i=0;i<len;i++)
			document.getElementById('trclient').options[i].selected=true;
		
	}
}	
}
</script>        
