<?php 

if(is_array($clients) && count($clients)>0){?>
<input type="hidden" name="release" value="" id="release" />
<ul class="legends_row">
<li><?php echo $this->Html->image('red.png',array('escape'=>false));?> No job card movement in 5 days</li>
<li><?php echo $this->Html->image('green.png',array('escape'=>false));?> No job card movement in 3 days</li>
<li><?php echo $this->Html->image('yellow.png',array('escape'=>false));?> Active job card movement</li>
</ul>
 <section class="heading_row">
        <span class="coln1"><!--<input type="checkbox" onclick="select_all_check();"/>-->Select</span>
        <span class="coln2">Title</span>
        <span class="coln3">Job A</span>
        <span class="coln4">Job B</span>
        <span class="coln5">S-A-SI-I-V-J</span>
        <span class="coln6"># of Weeks</span>
        <span class="coln7">Action</span>
        </section>
        
        <?php foreach($clients as $client){?>
        <section class="cmn_row">
        <span class="coln1"><input type="checkbox" class="client_check" name="cbox[]" onclick="objDelChecked(this)" value="<?php echo $client['C']['id']; ?>"></span>
        <span class="coln2 color"><a href="<?php echo SITE_URL."/Jobcards/index/".$client['C']['id'];?>"><?php echo $client['C']['name'];?></a></span>
        <!--<span><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/coach/coach_client_notes/<?php echo $client['C']['id'];?>')">View Notes</a></span>-->
        <span class="coln3 color"><?php echo $client['tot_a'];?></span>
        <span class="coln4 color"><?php echo $client['tot_b'];?></span>
        <span class="coln5 color"><?php echo $client['col_o']."-".$client['col_a']."-".$client['col_s']."-".$client['col_i']."-".$client['col_v']."-".$client['col_j']; ?></span>
        <span class="coln6 color"><?php if($client['0']['diff']!='') echo $client['0']['diff']; else echo 0;?></span>
        <span class="coln7 color">
            <ul><li><?php echo $this->Html->image('msg_icon.png', array('alt' => 'Send Messsage','title'=>'Send Message', 'border' => '0'))?></li>
        <li><a href="javascript://" onclick="releaseClient(<?php echo $client['C']['id'];?>)"><?php echo $this->Html->image('relese_icon.png', array('alt' => 'Release','title'=>'Release', 'border' => '0'))?></a></li>
        <li><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/coach/view_shared_files/<?php echo $client['C']['id'];?>');"><?php echo $this->Html->image('sharing_icon.png', array('alt' => 'View Shared File','title'=>'View Shared File', 'border' => '0'))?></a></li>
        <li><a href="<?php echo SITE_URL;?>/Reports/index/<?php echo $client['C']['id'];?>"><?php echo $this->Html->image('report_icon.png', array('alt' => 'Report','title'=>'View Report', 'border' => '0'))?></a></li></ul>
          </span>
        </section>
        <?php }?>
<div style="float:left;margin:10px 0 0 10px;">
  <a href="javascript://" onclick="deleteClient()" class="submitbtn">Delete</a>
</div>  
        <div id="page_navigation">
        </div>
<?php }else{?>
<div style="text-align: center; width:100%">No record found</div>
<?php } ?>
<script type="text/javascript">
    var iDelTotalChecked=0;
 function objDelChecked(chk)
 {
     if(chk.checked==true)
    {  iDelTotalChecked=(iDelTotalChecked+1); }
	
 else
 { iDelTotalChecked=(iDelTotalChecked-1); }
}

function select_all_check()
{
	$('.client_check').each(function(index, element) {
        $(this).attr('checked',true);
		objDelChecked(this);
    });
}
</script>
       