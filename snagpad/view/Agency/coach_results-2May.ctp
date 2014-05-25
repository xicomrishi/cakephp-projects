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
        <span class="coln1" style="width:98px"><input type="checkbox" id="masterbox" class="checkall" value=""></span>
        <span class="coln2" style="text-align:left; width180px:">Name</span>
        <?php if($this->Session->read('usertype')=='1'){?>
        <span class="coln3" style="width:220px">Email</span>
        <?php }else{?>
        <span class="coln3" style="width:220px">Agency</span>
        <?php }?>
        <span class="coln4" style="width:120px"># of Clients</span>
        <span class="coln5" style="width:220px">Date Added</span>
        <span class="coln6"  style="width:100px">Action</span>
        </section>
        
        <?php foreach($coaches as $coach){
			$active=0;
			if($coach['0']['active']!='0')
				$active=1;
			?>
        <section class="cmn_row">
        <span class="coln1" style="width:98px"><input type="checkbox" name="cbox[]" class="check" onclick="check(this)" value="<?php echo $coach['Coach']['account_id']; ?>"></span>
        <span class="coln2 color" style="width:180px; text-align:left"><?php if($this->Session->read('usertype')=='1') echo $coach['Coach']['name']; else {?><a href="javascript://" onclick="viewCoach(<?php echo $coach['Coach']['account_id'];?>)"><?php echo $coach['Coach']['name'];?></a><?php }?></span>
        <?php if($this->Session->read('usertype')=='1'){?>
        <span class="coln3 color" style="width:220px"><?php echo $coach['Coach']['email'];?></span>
        <?php }else{?>
                <span class="coln3 color" style="width:220px"  id="coach_<?php echo $coach['Coach']['account_id'];?>"><?php if($coach['A']['name']!='') echo $coach['A']['name']; else echo "NA";?></span>
        <?php }?>
        <span class="coln4 color" style="width:120px"><?php echo $coach['0']['count'];?></span>
        <span class="coln5 color" style="width:220px; text-align:center"><?php echo show_formatted_datetime($coach['Coach']['reg_date']);?></span>
        <span class="coln6 color" style="width:100px">
            <ul style="width:81 !important; margin:2px 0 0 30px">
        <li><a href="<?php echo SITE_URL;?>/Agency/report/<?php echo $coach['Coach']['account_id'];?>"><?php echo $this->Html->image('report_icon.png', array('alt' => 'Report','title'=>'View Report', 'border' => '0'))?></a></li>     
        <li><a href="javascript://" onclick="change_status(<?php echo $coach['Coach']['account_id'].','.$active;?>)"><?php if((int)$coach['0']['active']!=0) echo $this->Html->image('icon_activate.gif', array('alt' => 'Deactivate','title'=>'Deactivate', 'border' => '0')); else echo $this->Html->image('icon_deactivate.gif', array('alt' => 'Activate','title'=>'Activate', 'border' => '0'));?></a></li>
        </ul>
          </span>
        </section>
<div id="coach_detail_<?php echo $coach['Coach']['account_id'];?>"></div>
        <?php }?>
<div style="float:left;margin:10px 0 0 10px;"  class="delete_btn">
  <a href="javascript://" onclick="deleteCoach()">Delete</a>
</div>  

<?php }else{?>
<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
<?php } ?>
<script type="text/javascript">
    var open_id='';
 $(function () {
    $('.checkall').click(function () {
        $(this).parents('section:eq(1)').find(':checkbox').attr('checked', this.checked);
    });
});

function check(el){
	if(el.checked==false)
		$('.checkall').attr('checked',false); 
}
</script>
	<div class="paging"><?php echo $this->Paginator->numbers(array('separator' => ''));?>	</div>
<?php echo $this->Js->writeBuffer(); ?>       