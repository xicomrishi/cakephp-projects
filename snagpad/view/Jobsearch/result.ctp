        <section class="heading_row">
        <span class="col1"><strong>SOURCE</strong></span>
        <span class="col2">TITLE</span>
        <span class="col3">COMPANY</span>
        <span class="col4">LOCATION</span>
        <span class="col5 none">nn</span>
        </section>
		<?php 
		//echo "<pre>";print_r($results);die;
		if(empty($results)){ ?>
			<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No Job Postings Found</div>
		<?php	}else{
		foreach($results as $result){ ?>
        <section class="heading_row">
        <span class="col1"><?php echo $this->Html->image($result['source_type'].'.jpg', array('alt' => $result['source_type'].'.com', 'border' => '0'));?></span>
        <span class="col2" onclick="<?php if($result['resource_id']=='1') { ?>loadJobPopup('<?php echo SITE_URL;?>/jobsearch/job_details','<?php echo $result['country'];?>','<?php echo $result['city']; ?>','<?php echo $result['state']; ?>','<?php echo $result['url'];?>','<?php echo $result['jobtitle']; ?>','<?php echo $result['company'];?>');" <?php }else{ ?>loadPopup('<?php echo SITE_URL;?>/jobsearch/job_details/<?php echo $result['id'];?>');"<?php } ?>><?php echo $result['jobtitle'];?></span>
        <span class="col3"><?php if(is_array($result['company']) && $result['company']['name']!='') echo $result['company']['name'];elseif(!is_array($result['company']) && $result['company']!='') echo $result['company']; else echo "NA";?></span>
        <span class="col4 spacer"><?php if($result['formattedLocation']!='') echo $result['formattedLocation']; else echo "NA";?></span>
        <span class="col5" id="div_<?php echo $result['resource_id']."_".$result['id'];?>"><?php if($result['count']=='1') echo "<a href='javascript://' class='snagged'>Snagged</a></span>"; else{ if($result['resource_id']==1) echo "<a href='javascript://' onclick='setVal(\"".urlencode($result['jobtitle'])."\",\"".urlencode($result['company'])."\",\"".urlencode($result['city'])."\",\"".urlencode($result['state'])."\",\"".urlencode($result['country'])."\",\"".urlencode($result['url'])."\",\"$result[resource_id]\",\"$result[id]\",\"$result[usertype]\");'>CREATE A JOB CARD</a></span>"; 
		else 
		echo "<a href='javascript://' onclick='setVal(\"$result[jobtitle]\",\"".$result['company']['name']."\",\"\",\"\",\"\",\"\",\"$result[resource_id]\",\"$result[id]\")'>CREATE A JOB CARD</a></span>";} ?>
        </section>
       
		<?php }} ?>        
        <ul>
		<?php 
		if($current_page-5<=0) $start=1; else $start=$current_page-5;
		if($current_page+5>$totpage) $end=$totpage; else $end=$current_page+5;
		if($start!=1)
			echo "<li><a href='javascript://' onclick='showPage(1);' alt='First Page' title='First Page'>&lt;&lt;</a></li>";
		for($i=$start;$i<=$end;$i++){
			if($current_page==$i)
				echo "<li class='active'><a href='javascript://'>$i</a></li>";
			else
				echo "<li><a href='javascript://' onclick='showPage($i);'>$i</a></li>";
				}
		 if($end!=$totpage)
		 echo "<li><a href='javascript://' onclick='showPage($totpage);' alt='Last Page' title='Last Page'>&gt;&gt;</a></li>";
		?>
        </ul>		