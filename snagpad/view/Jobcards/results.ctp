<?php 
$this->Paginator->options(array(
'url' => $this->data,
    'update' => '#search_section',
    'evalScripts' => true,
    
));



if(is_array($clients) && count($clients)>0){?>
<input type="hidden" name="release" value="" id="release" />
 <section class="heading_row">
        <span class="coln1" style="width:80px"><input type="checkbox" onclick="select_all_check();"/></span>
        <span class="coln2" style="width:160px"><?php echo $this->Paginator->sort('Client.name','Client');?></span>
        <span class="coln3" style="width:160px"><?php echo $this->Paginator->sort('C.name','Coach');?></span>
        <span class="coln4"><?php echo $this->Paginator->sort('Client.count_jobA','Job A');?></span>
        <span class="coln5"><?php echo $this->Paginator->sort('Client.count_jobB','Job B');?></span>
        <span class="coln6"><b>S</b>-<b>A</b>-SI-<b>I</b>-V-J</span>
        <span class="coln7">Action</span>
        </section>
        
        <?php foreach($clients as $client){?>
        <section class="cmn_row">
        <span class="coln1" style="width:80px"><input type="checkbox" class="client_check" name="cbox[]" onclick="objDelChecked(this)" value="<?php echo $client['Client']['account_id']; ?>"></span>
        <span class="coln2 color" style="width:160px"><a href="javascript://" onclick="viewClient(<?php echo $client['Client']['account_id'];?>)"><?php echo $client['Client']['name'];?></a></span>
        <span class="coln3 color"  style="width:160px"><?php if($client['C']['name']!='') echo $client['C']['name']; else echo 'NA'?></span>
        <span class="coln4 color"><?php echo $client['Client']['count_jobA'];?></span>
        <span class="coln5 color"><?php echo $client['Client']['count_jobB'];?></span>
        <span class="coln6 color" style="color:#B3B3B3"><?php echo "<strong>".$client['Client']['count_colS']."-".$client['Client']['count_colA']."-".$client['Client']['count_colSI']."-".$client['Client']['count_colI']."-".$client['Client']['count_colV']."-".$client['Client']['count_colJ']."</strong>"; ?></span>
        <span class="coln7 color"><ul style="margin: 2px 0 0 50px; width:128px">
        <li><a href="<?php echo SITE_URL;?>/Jobcards/index/<?php echo $client['Client']['id'];?>"><?php echo $this->Html->image('sharing_icon.png', array('alt' => 'View Pad','title'=>'View Pad', 'border' => '0'))?></a></li>
        <li><a href="<?php echo SITE_URL;?>/Reports/index/<?php echo $client['Client']['id'];?>"><?php echo $this->Html->image('report_icon.png', array('alt' => 'Report','title'=>'View Report', 'border' => '0'))?></a></li></ul>
          </span>
        </section>
<div id="client_detail_<?php echo $client['Client']['account_id'];?>"></div>
        <?php }?>
<div style="float:left;margin:10px 0 0 10px;" class="delete_btn">
  <a href="javascript://" onclick="deleteClient()">Delete</a>
</div>  
	<div class="paging">
	<?php
		echo $this->Paginator->numbers(array('separator' => ''));
	?>
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
function select_all_check()
{
	$('.client_check').each(function(index, element) {
         if($(this).attr('checked')){
		$(this).attr('checked',false);
		objDelChecked(this);
		}else{
			$(this).attr('checked',true);
		objDelChecked(this);
			
			}
    });
}
</script>

<?php echo $this->Js->writeBuffer(); ?>       
       