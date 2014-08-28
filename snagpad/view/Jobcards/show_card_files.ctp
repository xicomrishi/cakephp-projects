<section class="submit_left">
<h4>Attachments</h4>
</section>
 
<section class="submit_right">
<div id="attechment">
        <div class="title_row">
        <span class="column1" style="width:350px">File</span>
        <span class="column2 text_indent" style="width:250px">Date Added</span>
       <!-- <span class="column3">Last Modified</span>-->
        </div>
        <?php 
		if(!isset($card_files['Card']['resume']) && !isset($card_files['Card']['cover_letter']))
		{ ?>
			<div  style=" text-align:center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No attachments found</div>
         
        <?php    
		}else{
if(isset($card_files['Card']['resume']) && (!empty($resume['Clientfile']['filename']))){ ?>
        <div class="comon_row">
        <span class="column1 colour1" style="width:350px"><a href="<?php echo $path.$resume['Clientfile']['file']; ?>" target="_blank"><?php echo $resume['Clientfile']['filename'];?></a></span>
        <span class="column2 colour2" style="width:250px"><?php echo show_formatted_date($resume['Clientfile']['reg_date']);?></span>
       <!-- <span class="column3 colour2"><?php echo $resume['Clientfile']['last_modified'];?></span>-->
         </div>
         <?php }
if(isset($card_files['Card']['cover_letter']) && (!empty($cover_letter['Clientfile']['filename']))){ ?>
         <div class="comon_row">
        <span class="column1 colour1" style="width:350px"><a href="<?php echo $path.$cover_letter['Clientfile']['file']; ?>" target="_blank"><?php echo $cover_letter['Clientfile']['filename'];?></a></span>
        <span class="column2 colour2" style="width:250px"><?php echo show_formatted_date($cover_letter['Clientfile']['reg_date']);?></span>
       <!-- <span class="column3 colour2"><?php echo $cover_letter['Clientfile']['last_modified'];?></span>-->
         </div>
         <?php }} ?>  
 </div>

</section>


