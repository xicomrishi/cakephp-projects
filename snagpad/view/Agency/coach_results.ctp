	<?php
$this->Paginator->options(array(
'url' => $this->data,
    'update' => '#search_section',
    'evalScripts' => true,
    
));

?>
<?php 
if(is_array($coaches) && count($coaches)>0){?>
<input type="hidden" name="release" value="" id="release" />
 <section class="heading_row">
        <span class="coln1" style="width:98px"><input type="checkbox" name="cbox[]" id="masterbox" onclick='check(this);' value=""></span>
        <span class="coln2" style="text-align:left; width:180px;">Name</span>
        <span class="coln3" style="width:220px">Email</span>
        <span class="coln4" style="width:120px"># of Clients</span>
        <span class="coln5" style="width:200px">Date Added</span>
        <span class="coln6"  style="width:120px">Action</span>
        </section>
        
        <?php foreach($coaches as $coach){?>
        <section class="cmn_row">
        <span class="coln1" style="width:98px"><input type="checkbox" name="cbox[]" class="check" onclick="objDelChecked(this)" value="<?php echo $coach['Coach']['account_id']; ?>"></span>
        <span class="coln2 color" style="width:180px; text-align:left"><?php echo $coach['Coach']['name'];?></span>
        <span class="coln3 color" style="width:220px"><?php echo $coach['Coach']['email'];?></span>
        <span class="coln4 color" style="width:120px"><?php echo $coach['0']['count'];?></span>
        <span class="coln5 color" style="width:200px; text-align:center"><?php echo show_formatted_date($coach['Coach']['reg_date']);?></span>
        <span class="coln6 color" style="width:135px">
            <ul style=" margin:2px 0 0 3px">
        <li><a href="<?php echo SITE_URL;?>/Agency/report/<?php echo $coach['Coach']['account_id'];?>"><?php echo $this->Html->image('report_icon.png', array('alt' => 'Report','title'=>'View Report', 'border' => '0'))?></a></li> 
            
        <li><a href="javascript://" onclick="change_status(<?php echo $coach['Coach']['account_id'].','.$coach['0']['active'];?>)"><?php if((int)$coach['0']['active']!=0) echo $this->Html->image('icon_activate.gif', array('alt' => 'Deactivate','title'=>'Deactivate', 'border' => '0')); else echo $this->Html->image('icon_deactivate.gif', array('alt' => 'Activate','title'=>'Activate', 'border' => '0'));?></a></li>
         <li><a href="<?php echo SITE_URL;?>/Agency/transfer/<?php echo $coach['Coach']['account_id'];?>"><?php echo $this->Html->image('transfer_icon.png', array('alt' => 'Transfer','title'=>'Transfer Clients', 'border' => '0'))?></a></li> 
        </ul>
          </span>
        </section>
<div id="client_detail_<?php echo $coach['Coach']['account_id'];?>"></div>
        <?php }?>
<div style="float:left;margin:10px 0 0 10px;"  class="delete_btn">
  <a href="javascript://" onclick="deleteCoach()">Delete</a>
</div>  

<?php }else{?>
<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
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
function check(el)
{
	if(el.checked==true)
	{
		$('.check').attr('checked',true);
		iDelTotalChecked=<?php echo count($coach);?>;
	}else{
		$('.check').attr('checked',false);
		iDelTotalChecked=0;
	}
}


</script>
	<?php /*?><?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p><?php */?>

	<div class="paging">
	<?php
		//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
<?php echo $this->Js->writeBuffer(); ?>       