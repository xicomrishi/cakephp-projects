<?php 

if(is_array($rows) && count($rows)>0){
	$this->Paginator->options(array(
'url' => $this->data,
    'update' => '#search_section',
    'evalScripts' => true,
    
));

	?>
 <section class="heading_row">
 <?php if($this->Session->read('usertype')!='4'){?>
        <span class="coln1" style="width:60px"><input type="checkbox" id="all_check" class="checkall" /></span>
<?php }?>        
        <span class="coln2" style="width:260px">Company Name</span>
        <span class="coln3" style="width:218px">Position Available</span>
        <span class="coln4" style="width:200px">Application Deadline</span>
        <span class="coln5" style="width:220px">Action</span>
        </section>
        
        <?php foreach($rows as $row){?>
        <section class="cmn_row">
        <?php if($this->Session->read('usertype')!='4'){?>
        <span class="coln1" style="width:60px"><input type="checkbox" name="cbox[]" onclick="uncheck();"  class="contact_check" value="<?php echo $row['Agencycard']['id']; ?>"></span>
        <?php }?>
        <span class="coln2 color" style="width:260px"><?php echo $row['Agencycard']['company_name'];?></span>
        <span class="coln3 color" style="width:218px"><?php echo $row['Agencycard']['position_available'];?></span>
        <span class="coln4 color" style="width:200px"><?php echo show_formatted_date($row['Agencycard']['application_deadline']); ?></span>
        <span class="coln5 color" style="width:220px"><?php if(isset($employer)) {?>
		<a href="javascript://" onclick="approve_card(<?php echo $row['Agencycard']['id'];?>,1)">Approve Card</a>	|| 	<a href="javascript://" onclick="approve_card(<?php echo $row['Agencycard']['id'];?>,2)">Decline Card</a><br />
		<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL."/cards/job_info/".$row['Agencycard']['id'];?>')">View Card</a>
		<?php  }else{if($this->Session->read('usertype')=='4'){?><a href="javascript://" onclick="show_add(<?php echo $row['Agencycard']['id'];?>)">Copy Card</a> <?php }else { if($this->Session->read('usertype')==1){ if($row['Agencycard']['share_all']=='1'){?><a>Shared</a><?php }else{ ?><a href="<?php echo SITE_URL."/Agencycards/share/".$row['Agencycard']['id']."/3";?>">Share with Client</a><br /> <a href="<?php echo SITE_URL."/Agencycards/share/".$row['Agencycard']['id']."/2";?>">Share with Coach</a><?php } ?><br /><?php }?><a href="javascript://" onclick="show_add(<?php echo $row['Agencycard']['id'];?>)">View/Edit Card</a><?php } }?><br /></span>
        </section>
        <?php }if($this->Session->read('usertype')!='4'){?>
<div style="float:left;margin:10px 0 0 10px;" class="delete_btn">
  <a href="javascript://" onclick="deleteCard()" >Delete</a>
</div>  
<?php }?>
           <div class="paging">
	<?php
	echo $this->Paginator->numbers(array('separator' => ''));
	?>
	</div>

               
<?php  }else{?>
<div style="text-align: center; width:100%;  float:left; padding:40px 0 0 0;font-family:'onduititc'; font-weight:normal; font-size:18px; color:#757575">No record found</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(e) {
$("html, body").animate({ scrollTop: 0 }, 600);
});
function uncheck()
{
	if($('#all_check').attr('checked'))
		$('#all_check').attr('checked',false);
}
$(function () {
    $('.checkall').click(function () {
        $(this).parents('section:eq(1)').find(':checkbox').attr('checked', this.checked);
    });
});

</script>
<?php  echo $this->Js->writeBuffer(); ?>