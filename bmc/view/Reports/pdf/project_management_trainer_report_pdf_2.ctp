<?php
$html='';
$html.= '<div class="wrapper">  
  <section id="body_container">
  <div class="login_detail right">
  
  	<div class="company_id  full">Trainer Name:<span>'.$user['User']['first_name'].' '.$user['User']['last_name'].'</span></div>
    <div class="company_id full">Course Id:<span>'.$course['Course']['course_id'].'</span></div>
    </div>
  	<div class="details"> 
         	<h3 class="report" style="background-color:#132540;display: block; margin-top:2px;color: #FFFFFF;padding: 7px;">Introduction</h3>
            <p>Guidelines when reading your 360 feedback</p>
            <p>When reviewing this report, please remember that you have asked your colleagues for their honest, frank feedback about
how they perceive you in relation to the competence areas covered in this report.</p>
			<p>Respondents were asked to give ratings and additional comments regarding what you are good at, and what you could
improve. Please review their responses in this context. You invited their perceptions, rather than necessarily deep insights;
how you come across to them, not necessarily the objective truth.</p>
			<p>The report has been prepared by collating, anonymising and randomising the feedback from all your colleagues so</p>
			<p><strong>Read through your report initially to gain an overview. Then read it again, working through each competency area looking
at the individual items.</strong></p>
			<ul class="points">
				<li>You will receive both positive and some negative feedback. Get the two in balance.</li>
				<li>Look for the overall flavour of the feedback. You will see different perceptions, since different people see you in
different contexts. This is natural and does not constitute a reason to discount the data.</li>
				<li>Don’t overly focus on the negatives</li>
				<li>Consider your strengths: Could they be more adequately used in the business?</li>
				<li>There is a natural tendency to attribute feedback to individuals. Resist blaming others or trying to pin some
comments/ratings on others.</li>
				<li>Ask: \'Why might different individuals see me differently?\'</li>
				<li>Look for general trends in the feedback, both positive and negative. Focus on what part you may play in the emerging
pattern, rather than focusing on external factors.</li>
				<li>Put individual comments in context – focus on general trends.</li>
				<li>Start to think about what you might do differently.</li>
				<li>Try and remove your own emotion. Think of the report as someone else’s!</li>
            </ul>
            <p class="bottom">Subject: '.$course['Course']['course_name'].'Report <span class="right">Created: '.show_formatted_date(date("Y-m-d")).'</span></p>
         </div>
    <div class="details">
    	<h3 class="report">Section Averages Summary</h3>
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>';
                  $i=1; foreach($section_data as $section){ 
                  	if($i%2==0) $class='even'; else $class='odd';
          $html.='<tr class="'.$class.'">
                    <td>';
					
			if($i==1) $secti='Planning'; else if($i==2)  $secti='Organizing &amp; Staffing'; else if($i==3)  $secti='Directing &amp; Leading'; else if($i==4)  $secti='Controlling'; if($i==5)  $secti='Reporting'; if($i==6)  $secti='Risk Management'; 
         $html.=$secti.'</td>
                    <td>                    	
                        <table class="summery_details">';                      
                     
					  	for($j=3;$j<6;$j++){
							if($j==3) $ut='Project Manager:'; else if($j==4) $ut='Team member:'; else if($j==5) $ut='Manager of Project Managers:';
							if(isset($section['usertype'][$j]['avg'])) $avg=number_format($section['usertype'][$j]['avg']*20,0); else $avg=0;
							if(isset($section['usertype'][$j]['avg'])) $avg_num=number_format($section['usertype'][$j]['avg'],0); else $avg_num=0;
        $html.='<tr>
                   <td><span class="points" style="font-size:12px;">'.$ut.'</span><span class="img_border"><img src="'.APP.'/webroot/img/pixel_img_'.$j.'.png" width="'.$avg.'" height="15"/></span>(.'.$avg_num.')</td>
                            </tr>';                       
                         }   
        $html.='</table>                        
                     </td>
                  </tr>';
                  
                $i++; }                  
                                   
       $html.='</tbody></table>
        </div>
    </div>
    <div class="details">
    	<h3 class="report">Feedback Summary</h3>';
        
        $p=1; foreach($question_data as $ques){ 
			if($p==1) $sect='Planning'; else if($p==2)  $sect='Organizing &amp; Staffing'; else if($p==3)  $sect='Directing &amp; Leading'; else if($p==4)  $sect='Controlling'; if($p==5)  $sect='Reporting'; if($p==6)  $sect='Risk Management'; 
      $html.='<div class="common_section">
        	<h3 class="section report">'.$p.'. '.$sect.'</h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>';
           $q=1; foreach($ques as $ind=>$usertype_data){ 
		   			if($q%2==0) $cl='even'; else $cl='odd'; 
      $html.='<tr class="'.$cl.'">
                    <td>'.$ind.'. '.$usertype_data['question'].'</td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">&nbsp;</span><div class="boxes none"><small>1</small><small>2</small><small>3</small><small>4</small><small>5</small></div></td>
                            </tr>';
                         
			for($r=3;$r<6;$r++){ 
				if($r==3) $uts='Project Manager:'; else if($r==4) $uts='Team member:'; else if($r==5) $uts='Manager of Project Managers:'; else $uts='Self: ';
       $html.='<tr>
                            	<td>
                                <span class="points">'.$uts.'</span>
                                
                    <div class="boxes">';
			for($l=1;$l<6;$l++){ 
					if(!isset($usertype_data['usertype'][$r]['count'][$l]))  $count_cl='none'; else $count_cl='';
					if(!isset($usertype_data['usertype'][$r]['count'][$l]))  $count_d='&nbsp;'; else $count_d=$usertype_data['usertype'][$r]['count'][$l];
						
		$html.='<span class="'.$count_cl.'">'.$count_d.'</span>';
			}
              if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi=$usertype_data['usertype'][$r]['avg']*20; else $avg_indi=0; 
			  if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi_num=number_format($usertype_data['usertype'][$r]['avg'],2); else $avg_indi_num=0;    
        $html.='</div>
                   <div class="color"><span><img src="'.APP.'/webroot/img/pixel_img_'.$r.'.png" width="'.$avg_indi.'" height="15"/></span></div><span class="pad">('.$avg_indi_num.')</span></td>
                            </tr>';
                            }                             
                           
        $html.='</table>
                     </td>
                  </tr>';
                  
                $q++; }  
				  
        $html.='</tbody>
                </table>
        	</div>
        </div>';
       $p++; } 
   $html.='</div>
  </section>
</div>';

echo $html;