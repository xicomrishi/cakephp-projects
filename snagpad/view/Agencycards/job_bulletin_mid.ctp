<?php if(is_array($cards) && count($cards)>0){?>        
<section class="heading_row">
        <span class="col1" style="width:156px;">JOB TITLE</span>
        <span class="col2" style="text-align:center; width:260px"><strong>COMPANY NAME</strong></span>
        <span class="col3" style="width:140px"><strong>COUNTRY</strong></span>
        <span class="col4 ">APPLICATION DEADLINE</span>
        <span class="col5 "><strong>ACTION</strong></span>
        </section>
		<?php 
		
		foreach($cards as $result){ ?>
        <section class="heading_row">
        <span class="col1" style="width:156px;"><?php echo $result['C']['position_available'];?></span>
        <span class="col2" style="text-align:center; width:260px"><?php echo $result['C']['company_name'];?></span>
        <span class="col3 spacer" style="width:140px"><?php echo $result['C']['country'];?></span>
        <span class="col4"><?php echo show_formatted_date($result['C']['application_deadline']);?></span>
                <span class="col5" id="div_<?php echo $result['C']['id'];?>"><a href='javascript://' onclick='add_card(<?php echo $result['C']['id'];?>)'>CREATE A JOB CARD</a></span>
		
        </section>
		<?php }?>        
<?php }else{?>
<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
<?php }?>        