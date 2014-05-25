<?php if(!isset($is_not_available)){ ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php } ?>
<style>
.pdf_link { color:#333; text-decoration:none;}
.details{ float:none !important; display:inline-block;}
.benchmark_a{ font-size:10px;}
</style>

<div class="wrapper">  
  <section id="body_container">
  <div class="login_detail right">
 
  	<div class="company_id  full"><?php echo __('Trainer Name'); ?>:<span><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span></div>
    <div class="company_id full"><?php echo __('Group ID'); ?>:<span><?php echo $course['Course']['course_id']; ?></span></div>
    <?php if(isset($fi_company)){ ?>
    	<div class="company_id full"><?php echo __('Company'); ?>:<span><?php echo $fi_company['Company']['company']; ?></span></div>
    <?php } ?>
     <?php if(isset($fi_company_location)){ ?>
    	<div class="company_id full"><?php echo __('Company Location'); ?>:<span><?php echo $fi_company_location['Country']['country_name']; ?></span></div>
    <?php } ?>
     <?php if(isset($fi_industry)){ ?>
    	<div class="company_id full"><?php echo __('Industry'); ?>:<span><?php echo $fi_industry['Industry']['industry']; ?></span></div>
    <?php } ?>
     <?php if(isset($fi_role)){ ?>
    	<div class="company_id full"><?php echo __('Role'); ?>:<span><?php echo $fi_role; ?></span></div>
    <?php } ?>
     <?php if(isset($fi_country)){ ?>
    	<div class="company_id full"><?php echo __('Country'); ?>:<span><?php echo $fi_country['Country']['country_name']; ?></span></div>
    <?php } ?>
     <?php if(isset($fi_year)){ ?>
    	<div class="company_id full"><?php echo __('Year'); ?>:<span><?php echo $fi_year; ?></span></div>
    <?php } ?>
    
    <?php if(!isset($is_not_available)){ ?>
    <div id="pdf_link" class="company_id full"><?php echo __('Download Report'); ?>:<span><a href="<?php echo SITE_URL;?>/reports/project_management_trainer_report/<?php echo $course['Course']['course_id'];?>/1<?php echo $pdf_link; ?>" target="_blank" class="pdf_link"><img src="<?php echo $this->webroot; ?>img/pdf_download.jpg" alt="" height="20" width="20"/></a></span></div>
    <?php } ?>
    
    </div>
    
  	<div class="details"> 
         	<h3 class="report"><?php echo __('Introduction'); ?></h3>
        
			<?php echo $intro_text; ?>
            <p class="bottom"> <?php echo __('BMC Assessment Inventory of Project Management Report'); ?> <span class="right"><?php echo __('Created'); ?>: <?php echo show_formatted_date(date("Y-m-d")); ?></span></p>
         </div>         

	<div class="details">
    <h3 class="report"><?php echo __('Filter Report'); ?></h3>
    	<form class="filterform" id="filterForm" name="filterForm" method="post" action="<?php echo $this->webroot; ?>reports/project_management_trainer_report/<?php echo $course['Course']['course_id']; ?>">
        	<div class="col">
            <label><?php echo __('Company'); ?></label>
            <select id="re_company" name="company">
            	<option value=""><?php echo __('Select Company'); ?></option>
                <?php foreach($added_company as $company){ if(isset($company['id'])){ ?>
                	<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                <?php }} ?>
            </select> 
            </div>
            <div class="col right">
            	<label><?php echo __('Company Location'); ?></label>
                <select id="re_company_location" name="company_location">
                	<option value=""><?php echo __('Select Location'); ?></option>
                    <?php foreach($added_countries as $country){ ?>
                    	<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
                </select>
            </div>
            <div class="col">
            	<label><?php echo __('Industry'); ?></label>
                <select id="re_industry" name="industry">
                	<option value=""><?php echo __('Select Industry'); ?></option>
                    <?php foreach($added_industry as $industry){ ?>
                    	<option value="<?php echo $industry['id']; ?>"><?php echo $industry['name']; ?></option>
					<?php } ?>
                </select>
            </div>
             <div class="col right">
            	<label><?php echo __('Country'); ?></label>
                <select id="re_country" name="country">
                	<option value=""><?php echo __('Select Country'); ?></option>
                    <?php foreach($added_countries as $country){ ?>
                    	<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
                </select>
            </div>
             <div class="col">
            	<label><?php echo __('Role'); ?></label>
                <select id="re_role" name="role">
                	<option value=""><?php echo __('Select Role'); ?></option>
                    <option value="3"><?php echo __('Project Manager'); ?></option>
                    <option value="4"><?php echo __('Team Member'); ?></option>
                    <option value="5"><?php echo __('Manager of Project Managers'); ?></option>
                </select>
            </div>
            <div class="col">
            	<label><?php echo __('Year'); ?></label>
                <select id="re_year" name="year">
                	<option value=""><?php echo __('Select Year'); ?></option>
                    <?php foreach($allyears as $ayr){ ?>
                    	<option value="<?php echo $ayr; ?>"><?php echo $ayr; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col right last">
            <input type="submit" value="<?php echo __('Generate Report'); ?>" class="submit"/>
            </div>
        </form>
    </div>
   <?php if(!isset($is_not_available)){ ?>
    <div class="details">
    	<h3 class="report"><?php echo __('Section Averages Summary'); ?></h3>
         
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>
                  <?php $i=1; foreach($section_data as $section){ ?>
                  	
                    <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); if($i==5) echo __('Reporting'); if($i==6) echo __('Risk Management'); ?><?php if(isset($bench_data)){ ?><br><a class="benchmark_a" href="javascript://" onclick="$('.benchmark_<?php echo $i; ?>').slideDown('slow');">View Benchmark Data</a> <?php } ?></td>
                    <td>                    	
                        <table class="summery_details">                      
                      <?php  
					  	for($j=3;$j<6;$j++){
					 ?>
                            <tr>
                            	<td><span class="points"><?php if($j==3) echo __('Project Manager:'); else if($j==4) echo __('Team member:'); else if($j==5) echo __('Manager of Project Managers:'); ?></span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $j; ?>.png" style="width:<?php  if(isset($section['usertype'][$j]['avg'])) echo $section['usertype'][$j]['avg']*20; else echo '0'; ?>%"/></span>(<?php if(isset($section['usertype'][$j]['avg'])) echo number_format($section['usertype'][$j]['avg'],2); else echo '0'; ?>)</td>
                            </tr>
                       
                         <?php  } ?>   
                        </table>                        
                     </td>
                  </tr>
                  
       <?php if(isset($bench_data)){ ?>
                  <tr class="even last uneven benchmark_<?php echo $i; ?>"  style="display:none;">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo __('Benchmark Data for Group (%s)',$benchmark_role); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                               <td>
                                <div class="boxes">
								  <?php   for($l1=5;$l1>0;$l1--){  ?>
                                        <span class="<?php if(!isset($bench_data[0][$i-1]['val']['num_'.$l1])) echo 'none'; ?>"><?php if(!isset($bench_data[0][$i-1]['val']['num_'.$l1])) echo '&nbsp;'; else echo ($bench_data[0][$i-1]['val']['num_'.$l1]); ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $bench_data[0][$i-1]['avg']*20;  ?>%"/></span>(<?php echo number_format($bench_data[0][$i-1]['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  
                  <tr class="even last uneven benchmark_<?php echo $i; ?>"  style="display:none;">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo __('Benchmark Data for Company (%s)',$benchmark_company['Company']['company']); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                               <td>
                                <div class="boxes">
								  <?php   for($l2=5;$l2>0;$l2--){  ?>
                                        <span class="<?php if(!isset($bench_data[1][$i-1]['val']['num_'.$l2])) echo 'none'; ?>"><?php if(!isset($bench_data[1][$i-1]['val']['num_'.$l2])) echo '&nbsp;'; else echo ($bench_data[1][$i-1]['val']['num_'.$l2]); ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $bench_data[1][$i-1]['avg']*20;  ?>%"/></span>(<?php echo number_format($bench_data[1][$i-1]['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  
                  
                  <tr class="even last uneven benchmark_<?php echo $i; ?>"  style="display:none;">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo __('Benchmark Data for Industry (%s)',$benchmark_industry['Industry']['industry']); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                               <td>
                                <div class="boxes">
								  <?php   for($l3=5;$l3>0;$l3--){  ?>
                                        <span class="<?php if(!isset($bench_data[2][$i-1]['val']['num_'.$l3])) echo 'none'; ?>"><?php if(!isset($bench_data[2][$i-1]['val']['num_'.$l3])) echo '&nbsp;'; else echo ($bench_data[2][$i-1]['val']['num_'.$l3]); ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $bench_data[2][$i-1]['avg']*20;  ?>%"/></span>(<?php echo number_format($bench_data[2][$i-1]['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  
        <?php } ?>
                  
                  <?php $i++; } ?>                  
                                   
                </tbody></table>
        </div>        
    </div>
    
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <div class="details">
    	<h3 class="report"><?php echo __('Feedback Summary'); ?></h3>
        
        <?php $p=1; foreach($question_data as $ques){ ?>
        <div class="common_section">
        	<h3 class="section report"><?php echo $p.'. '; if($p==1) echo __('Planning'); else if($p==2) echo __('Organizing &amp; Staffing'); else if($p==3) echo __('Directing &amp; Leading'); else if($p==4) echo __('Controlling'); else if($p==5) echo __('Reporting'); else if($p==6) echo __('Risk Management'); ?></h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>
                <?php $q=1; foreach($ques as $ind=>$usertype_data){  ?>
                  <tr class="<?php if($q%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php echo $ind.'. '.$usertype_data['question']; ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">&nbsp;</span><div class="boxes none"><small>A</small><small>B</small><small>C</small><small>D</small><small>E</small></div></td>
                            </tr>
                            <?php 
							for($r=3;$r<6;$r++){ 
							 ?>
                        	<tr>
                            	<td>
                                <span class="points"><?php if($r==3) echo __('Project Manager: '); else if($r==4) echo __('Team Member: '); else if($r==5) echo __('Manager of Project Managers: '); else echo __('Self: '); ?></span>
                                
                    <div class="boxes">
                    <?php for($l=5;$l>0;$l--){ ?>
                      <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][$l] ?></span>
                    <?php } ?>
                      
                    </div>
                   <div class="color"><span><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $r; ?>.png" style="width:<?php if(isset($usertype_data['usertype'][$r]['avg'])) echo $usertype_data['usertype'][$r]['avg']*20; else echo 0; ?>%"/></span></div><span class="pad">(<?php if(isset($usertype_data['usertype'][$r]['avg'])) echo number_format($usertype_data['usertype'][$r]['avg'],2); else echo 0; ?>)</span></td>
                            </tr>
                            <?php } ?>                            
                           
                        </table>
                     </td>
                  </tr>
                  
                <?php $q++; } ?>  				  
                </tbody>
                </table>
                <div id="chart_div_<?php echo $p; ?>" style="width: 900px; height: 500px;"></div>
        	</div>
        </div>
        <?php $p++; } ?>       
    </div>
    <?php }else{  ?>
    	<div style="height:400px; margin-top:200px; width:960px; text-align:center;"><?php echo __('Report not available.'); ?></div>
    <?php } ?>
  </section>
</div>

<script type="text/javascript">
	<?php if(!isset($is_not_available)){ ?>
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  google.setOnLoadCallback(function(){ drawqueschart1(); drawqueschart2();drawqueschart3();drawqueschart4();drawqueschart5();drawqueschart6();
	   });
    
	  function drawChart() {
		 
        var data = google.visualization.arrayToDataTable([<?php echo $section_chart; ?>]);
        var options = {
          title: 'Overall',
		  vAxis: { ticks: [1,2,3,4,5] },
		  pointSize: 3
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  
	  function drawqueschart1()
	  {		
	  	var data = google.visualization.arrayToDataTable([<?php echo $question_chart[1]; ?>]);
		var options = {title: 'Planning',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_1'));
        chart.draw(data, options);
	  }
	  function drawqueschart2()
	  {		
	  	var data = google.visualization.arrayToDataTable([<?php echo $question_chart[2]; ?>]);
		var options = {title: 'Organizing & Staffing',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_2'));
        chart.draw(data, options);
	  }
	  function drawqueschart3()
	  {		
	  	var data = google.visualization.arrayToDataTable([<?php echo $question_chart[3]; ?>]);
		var options = {title: 'Directing & Leading',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_3'));
        chart.draw(data, options);
	  }
	  function drawqueschart4()
	  {		
	  	
		var data = google.visualization.arrayToDataTable([<?php echo $question_chart[4]; ?>]);
		var options = {title: 'Controlling',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_4'));
        chart.draw(data, options);
	  }
	  function drawqueschart5()
	  {		
	  	var data = google.visualization.arrayToDataTable([<?php echo $question_chart[5]; ?>]);
		var options = {title: 'Reporting',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_5'));
        chart.draw(data, options);
	  }
	  function drawqueschart6()
	  {		
	  	var data = google.visualization.arrayToDataTable([<?php echo $question_chart[6]; ?>]);
		var options = {title: 'Risk Management',pointSize: 3,vAxis: { ticks: [1,2,3,4,5] }};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_6'));
        chart.draw(data, options);
	  }
	   <?php } ?>
	</script>