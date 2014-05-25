<?php 

if(is_array($rows) && count($rows)>0){?>
 <section class="heading_row">
        <span class="coln1"><input type="checkbox" id="all_check" onclick="select_all_check();"/></span>
        <span class="coln2">Company Name</span>
        <span class="coln3" style="width:200px">Position Available</span>
        <span class="coln4" style="width:200px">Application Deadline</span>
        <span class="coln5" style="width:220px">Action</span>
        </section>
        
        <?php foreach($rows as $row){?>
        <section class="cmn_row">
        <span class="coln1"><input type="checkbox" name="cbox[]" onclick="objDelChecked(this); uncheck();"  class="contact_check" value="<?php echo $row['C']['id']; ?>"></span>
        <span class="coln2 color"><?php echo $row['C']['company_name'];?></span>
        <span class="coln3 color" style="width:200px"><?php echo $row['C']['position_available'];?></span>
        <span class="coln4 color" style="width:200px"><?php echo show_formatted_date($row['C']['application_deadline']); ?></span>
        <span class="coln5 color" style="width:220px"><?php if($row['C']['share_all']=='1'){?><a>Shared</a><?php }else{ ?><a href="<?php echo SITE_URL."/Agencycards/share/".$row['C']['id']."/3";?>">Share with Client</a><br /> <a href="<?php echo SITE_URL."/Agencycards/share/".$row['C']['id']."/2";?>">Share with Coach</a><?php } ?><br /><a href="javascript://" onclick="show_add(<?php echo $row['C']['id'];?>)">View/Edit Card</a><br /></span>
        </section>
        <?php }?>
<div style="float:left;margin:10px 0 0 10px;" class="delete_btn">
  <a href="javascript://" onclick="deleteCard()" >Delete</a>
</div>  
        <div id="page_navigation">
        </div>
<?php }else{?>
<div style="text-align: center; width:100%;  float:left; padding:40px 0 0 0;font-family:'onduititc'; font-weight:normal; font-size:18px; color:#757575">No record found</div>
<?php } ?>
<script type="text/javascript">
    var iDelTotalChecked=0;
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
		$('.contact_check').each(function(index, element) {
         $(this).attr('checked',true);
		objDelChecked(this);
		
     });
	 
	}else{
	$('.contact_check').each(function(index, element) {
        
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
       