	<?php
$this->Paginator->options(array(
'url' => $this->data,
    'update' => '.contact_section',
    'evalScripts' => true,
    
));

?>
<div id="msg" class="success"></div>
    <section class="title_row">
             <span class="column1">
            <small><?php echo $this->Paginator->sort('name','Title');?></small></span>

            <span class="column2"><?php echo $this->Paginator->sort('email','Email');?></span>
            <span class="column3" style="width:140px"><?php echo $this->Paginator->sort('reg_date','Date Added');?></span>
            <span class="column4" style="width:140px"><?php echo $this->Paginator->sort('plan_due_date','Due Date');?></span>
            <span class="column5">Action</span>
        </section>
        <?php foreach($agency as $ag){ ?>
         <section class="comon_row" style="min-height:25px">
          <span class="column1"><small><a href="javascript://" onclick="show_add_agency(<?php echo $ag['Agency']['account_id'];?>)"><?php echo $ag['Agency']['name']; ?></a></small></span>
        <span class="column2 colour2"><a href="mailto:<?php echo $ag['Agency']['email']; ?>"><?php echo $ag['Agency']['email']; ?></a></span>
        <span class="column3 colour3" style="width:140px"><?php echo show_formatted_date($ag['Agency']['reg_date']); ?></span>
        <span class="column4 colour3" style="width:140px"><?php echo show_formatted_date($ag['Agency']['plan_due_date']); ?></span>
        <span class="column5 colour4">
          <ul>
        <li><a href="javascript://" onclick="change_status(<?php echo $ag['Agency']['account_id'].','.$ag['0']['active'];?>)"><?php if((int)$ag['0']['active']!=0) echo $this->Html->image('icon_activate.gif', array('alt' => 'Deactivate','title'=>'Deactivate', 'border' => '0','id'=>'stat_'.$ag['Agency']['account_id'])); else echo $this->Html->image('icon_deactivate.gif', array('alt' => 'Activate','title'=>'Activate', 'border' => '0','id'=>'stat_'.$ag['Agency']['account_id']));?></a></li>
        </ul></span>
        </section>
        <div id="agency_detail_<?php echo $ag['Agency']['account_id'];?>"></div>
        <?php } ?>
        <!--div style="float:left;margin:10px 0 0 10px;" class="delete_btn">
  <a href="javascript://" onclick="deleteAgency()">Delete</a>
</div -->  

       <div class="paging">
	<?php
		//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
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
</script>    
<?php echo $this->Js->writeBuffer(); ?>