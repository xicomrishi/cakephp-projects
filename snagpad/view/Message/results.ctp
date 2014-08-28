<?php 

if(is_array($mails) && count($mails)>0){?>
<input type="hidden" name="release" value="" id="release" />
 <section class="heading_row">
        <span class="coln1" ><input type="checkbox" id="all_check" onclick="select_all_check();"/></span>
        <span class="coln2" style="width:230px"><?php if($type==0) echo "From"; else echo "To";?></span>
        <span class="coln3" style="width:200px">Date</span>
        <span class="coln4" style="width:240px">Subject</span>
        <?php if($type==0){?>
        <span class="coln5" style="width:160px">Action</span>
        <?php }?>
        </section>
        
        <?php foreach($mails as $mail){
			if($this->Session->read('usertype')==2 && $type=='1'){ $id= $mail['M']['multiple_message_id']; }else  $id= $mail['M']['id'];
			?>
        <section class="cmn_row <?php if($mail['M']['read_flag']=='1'){ echo 'visited'; }?>">
        <span class="coln1" ><input type="checkbox" name="cbox[]" onclick="objDelChecked(this); uncheck();" class="card_check" value="<?php echo $id; ?>"></span>
        <span class="coln2 color" style="width:230px"><a href="javascript://" onclick="view_mail(<?php echo $id.",".$type;?>)"><?php echo $mail[0]['name'];?></a></span>
        <span class="coln3 color"  style="width:200px"><a href="javascript://" onclick="view_mail(<?php echo $id.",".$type;?>)"><?php echo show_formatted_datetime($mail['M']['send_date']);?></a></span>
        <span class="coln4 color" style="width:240px"><a href="javascript://" onclick="view_mail(<?php echo $id.",".$type;?>)"><?php echo $mail['M']['subject'];?></a></span>
        <?php if($type==0){?>
        <span class="coln5 color" style="width:160px"><a href="javascript://" class="submitbtn" style="margin:0 40px 0 0 !important" onclick="show_add(<?php echo $mail['M']['id'];?>,<?php echo $mail['M']['from_userid'];?>)">Reply</a></span>
        <?php }?>
        </section>
  		<div id="email_detail_<?php echo $id;?>"></div>
		

        <?php }?>
<div class="delete_btn space">
  <a href="javascript://" onclick="deleteMail(<?php echo $type;?>)" >Delete</a>
</div>  
        <div id="page_navigation">
        </div>
<?php }else{?>
<div style="text-align: center; width:100%;  float:left; padding:40px 0 0 0;font-family:'onduititc'; font-weight:normal; font-size:18px; color:#757575">No record found</div>
<?php } ?>
<script type="text/javascript">
    var iDelTotalChecked=0;
	var open_id='';

 function objDelChecked(chk)
 {
     if(chk.checked==true)
     iDelTotalChecked=iDelTotalChecked+1
 else
  iDelTotalChecked=iDelTotalChecked-1
}

function select_all_check()
{
	if($('#all_check').attr('checked'))
	{
		$('.card_check').each(function(index, element) {
         $(this).attr('checked',true);
		objDelChecked(this);
		
     });
	 
	}else{
	$('.card_check').each(function(index, element) {
        
		$(this).attr('checked',false);
		objDelChecked(this);
		
    });
	}
}
function uncheck()
{
	if($('#all_check').attr('checked'))
	{
		$('#all_check').attr('checked',false);
	}	
}
</script>
       