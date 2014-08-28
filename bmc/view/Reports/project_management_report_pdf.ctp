<?php
App::import('Vendor','xtcpdf'); 

$tcpdf = new XTCPDF(); 
$html='';
$slno=1;
$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans'
$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintHeader(false);
$tagvs = array('h1' => array(0 => array('h' => 1, 'n' => 3), 1 => array('h' => 1, 'n' => 2)),
               'h2' => array(0 => array('h' => 1, 'n' => 2), 1 => array('h' => 1, 'n' => 1)),
			   'h3' => array(0 => array('h' => 1, 'n' => 2), 1 => array('h' => 1, 'n' => 1)));
$tcpdf->setHtmlVSpace($tagvs);
$tcpdf->xfootertext = '<table><tr><td style="font-size:8px; text-align:left;">'.__('BMC Assessment Inventory of Project Management Report').'</td><td style="font-size:8px; text-align:right;">'.__('Created').': '.show_formatted_date(date("Y-m-d")).'</td></tr></table>';

$tcpdf->AddPage(); // Front Page

$html_front = __('Project Management Assessment Report').'<br><br>'.__('Participant').': '.$user['User']['first_name'].' '.$user['User']['last_name'].'<br><br>'.__('Group').': '.$course['Course']['course_name'].'<br><br>'.__('Company').': '.$section_data[1]['company']['name'];
$tcpdf->SetY(-270);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 18);
$tcpdf->writeHTMLCell(-250, '', '', '', $html_front, 0, 0, false, true, 'C');

// add a page (required with recent versions of tcpdf)
$tcpdf->AddPage(); // Front Page
$html_1='';
$html_1.='<div class="wrapper">  
  <section id="body_container">
  	<div class="details"> 
         	<h3 class="report" style="background-color:#132540; color:#FFFFFF;">&nbsp;&nbsp;'.__('Introduction').' - '.$user['User']['first_name'].' '.$user['User']['last_name'].'</h3>'.$intro_text.'</div>';
			
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html_1, true, false, true, false, '');		 
$tcpdf->AddPage();
$html='<style>
    table{border-collapse:collapse;padding:5px; }
	.last{background-color:#EAEAEA !important;}
    .even{background-color:#EAEAEA;}
	.odd{background-color:#FFFFFF;}
	td{font-size:8px;}
	.report{ background-color:#132540;color: #FFFFFF;}
	.spbox{ border:1px solid black;}
	.comments{  background: none repeat scroll 0 0 #EAEAEA;}
   </style>';		 
$html.='  <div class="details">
    	<h3 class="report">&nbsp;&nbsp;'.__('Section Averages Summary').' - '.$user['User']['first_name'].' '.$user['User']['last_name'].'</h3>
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>';
                  $i=1; foreach($section_data as $section){ 
                  	if($i%2==0) $class='even'; else $class='odd';	
                   $html.='<tr class="">
                    <td width="30%">';
					if($i==1) $secti=__('Planning'); else if($i==2)  $secti=__('Organizing &amp; Staffing'); else if($i==3)  $secti=__('Directing &amp; Leading'); else if($i==4)  $secti=__('Controlling'); if($i==5)  $secti=__('Reporting'); if($i==6)  $secti=__('Risk Management'); 
					
			$html.=$secti.'</td>
					<td width="16%">&nbsp;</td>
                    <td width="50%">                    	
                        <table class="summery_details">';                      
                      
				 for($j=3;$j<7;$j++){
					if($j==3) $ut=__('Project Manager:'); else if($j==4) $ut=__('Team member:'); else if($j==5) $ut=__('Manager of Project Managers:'); else if($j==6) $ut=__('Own Score:');
					if(isset($section['usertype'][$j]['avg'])) $avg=number_format($section['usertype'][$j]['avg']*20,0); else $avg=0;
					if(isset($section['usertype'][$j]['avg'])) $avg_num=number_format($section['usertype'][$j]['avg'],2); else $avg_num=0;
             $html.='<tr>
                        <td width="30%">'.$ut.'</td><td height="10" width="50%"><img src="'.APP.'webroot/img/pixel_img_'.$j.'.png" width="'.$avg.'" height="10px"/></td><td>('.$avg_num.')</td>
                            </tr>';                       
                   }  
            $html.='</table>                        
                     </td>
                  </tr>';
            
			if($role_id=='3') $role=__('Project Manager'); else if($role_id=='4') $role=__('Team Member'); else if($role_id=='5') $role=__('Manager of Project Manager');
			$html.='<tr  bgcolor="#CCCCCC">
                    <td width="30%">&nbsp;&nbsp;'.__('My Group').'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr><td class="boxnum" width="40%"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
				for($l1=5;$l1>0;$l1--){ 
					 if(!isset($section['group']['count_resp'][$l1])){  $gp_cl='none'; $bgcolor_gp='#fff'; }else{ $gp_cl=''; $bgcolor_gp='#999';}
					 if(!isset($section['group']['count_resp'][$l1])){ $gp_count_resp='&nbsp;'; }else{  $gp_count_resp=$section['group']['count_resp'][$l1]; }
                    $html.='<td class="'.$gp_cl.' spbox" bgcolor="'.$bgcolor_gp.'" style="color:#fff; font-size:6px;">'.$gp_count_resp.'</td>';
                 } 
            $html.='</tr></table></td><td width="10%">'.__('Average score').':</td><td height="10" width="30%"><img src="'.APP.'webroot/img/pixel_img_7.png" width="'.($section['company']['avg']*20).'" height="10px"/></td><td width="20%">('.number_format($section['group']['avg'],2).')</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  <tr  bgcolor="#CCCCCC">
                    <td width="30%">&nbsp;&nbsp;'.__('My Company (%s)',$section['company']['name']).'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr><td class="boxnum" width="40%"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
				for($l2=5;$l2>0;$l2--){ 
				if(!isset($section['company']['count_resp'][$l2])) $section['company']['count_resp'][$l2]=0;
					if(!isset($bench_data[1][$i-1]['val']['num_'.$l2])){ $bench_add=0; }else{ $bench_add=$bench_data[1][$i-1]['val']['num_'.$l2]; }
					 if(!isset($section['company']['count_resp'][$l2]) && $bench_add==0){  $cp_cl='none'; $bgcolor_cp='#fff'; }else{ $cp_cl=''; $bgcolor_cp='#999';}
					 if(!isset($section['company']['count_resp'][$l2]) && $bench_add==0){ $cp_count_resp='&nbsp;'; }else{  $cp_count_resp=intval($section['company']['count_resp'][$l2])+$bench_add; }
					  
                    $html.='<td class="'.$cp_cl.' spbox" bgcolor="'.$bgcolor_cp.'" style="color:#fff; font-size:6px;">'.$cp_count_resp.'</td>';
                 } 			
            $html.='</tr></table></td><td width="10%">'.__('Average score').':</td><td height="10" width="30%"><img src="'.APP.'webroot/img/pixel_img_7.png" width="'.($section['company']['avg']*20).'" height="10px"/></td><td width="20%">('.number_format($section['company']['avg'],2).')</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
				  
				  <tr  bgcolor="#CCCCCC">
                    <td width="30%">&nbsp;&nbsp;'.__('My Company in My Country (%s)',$section['company_location']['name']).'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr><td class="boxnum" width="40%"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
				for($l3=5;$l3>0;$l3--){
					if(!isset($section['company_location']['count_resp'][$l3])) $section['company_location']['count_resp'][$l3]=0;
					if(!isset($bench_data[2][$i-1]['val']['num_'.$l3])){ $bench_add=0; }else{ $bench_add=$bench_data[2][$i-1]['val']['num_'.$l3]; } 
					if(!isset($section['company_location']['count_resp'][$l3]) && $bench_add==0){  $clp_cl='none'; $bgcolor_clp='#fff'; }else{ $clp_cl=''; $bgcolor_clp='#999';}
					if(!isset($section['company_location']['count_resp'][$l3]) && $bench_add==0){ $clp_count_resp='&nbsp;'; }else{  $clp_count_resp=intval($section['company_location']['count_resp'][$l3])+$bench_add; }
                    $html.='<td class="'.$clp_cl.' spbox" bgcolor="'.$bgcolor_clp.'" style="color:#fff; font-size:6px;">'.$clp_count_resp.'</td>';
                 } 			
            $html.='</tr></table></td><td width="10%">'.__('Average score').':</td><td height="10" width="30%"><img src="'.APP.'webroot/img/pixel_img_7.png" width="'.($section['company_location']['avg']*20).'" height="10px"/></td><td width="20%">('.number_format($section['company_location']['avg'],2).')</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  
                 <tr  bgcolor="#CCCCCC">
                    <td width="30%">&nbsp;&nbsp;'.__('My Industry (%s)',$section['industry']['name']).'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr><td class="boxnum" width="40%">
							<table  cellpadding="4" cellspacing="0" border="0">
								<tr>';
				for($l4=5;$l4>0;$l4--){ 
					if(!isset($section['industry']['count_resp'][$l4])) $section['industry']['count_resp'][$l4]=0;
					if(!isset($bench_data[3][$i-1]['val']['num_'.$l4])){ $bench_add=0; }else{ $bench_add=$bench_data[3][$i-1]['val']['num_'.$l4]; } 
					if(!isset($section['industry']['count_resp'][$l4]) && $bench_add==0){  $ip_cl='none'; $bgcolor_ip='#fff'; }else{ $ip_cl=''; $bgcolor_ip='#999';}
					if(!isset($section['industry']['count_resp'][$l4]) && $bench_add==0){ $ip_count_resp='&nbsp;'; }else{  $ip_count_resp=$section['industry']['count_resp'][$l4]+$bench_add; }
                    $html.='<td class="'.$ip_cl.' spbox" bgcolor="'.$bgcolor_ip.'" style="color:#fff; font-size:6px;">'.$ip_count_resp.'</td>';
                 } 			
            $html.='</tr></table></td><td width="10%">'.__('Average score').':</td><td height="10" width="30%"><img src="'.APP.'webroot/img/pixel_img_7.png" width="'.($section['industry']['avg']*20).'" height="10px"/></td><td width="20%">('.number_format($section['industry']['avg'],2).')</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
				  
				  
				 <tr  bgcolor="#CCCCCC">
                    <td width="30%">&nbsp;&nbsp;'.__('Overall Benchmark Data').'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr><td class="boxnum" width="40%"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
				for($l5=5;$l5>0;$l5--){
					if(!isset($section['overall']['count_resp'][$l5])) $section['overall']['count_resp'][$l5]=0;
					if(!isset($bench_data[4][$i-1]['val']['num_'.$l5])){ $bench_add=0; }else{ $bench_add=$bench_data[4][$i-1]['val']['num_'.$l5]; } 
					if(!isset($section['overall']['count_resp'][$l5]) && $bench_add==0){  $op_cl='none'; $bgcolor_op='#fff'; }else{ $op_cl=''; $bgcolor_op='#999';}
					if(!isset($section['overall']['count_resp'][$l5]) && $bench_add==0){ $op_count_resp='&nbsp;'; }else{  $op_count_resp=intval($section['overall']['count_resp'][$l5])+$bench_add; }
                    $html.='<td class="'.$op_cl.' spbox" bgcolor="'.$bgcolor_op.'" style="color:#fff; font-size:6px;">'.$op_count_resp.'</td>';
                 } 			
            $html.='</tr></table></td><td width="10%">'.__('Average score').':</td><td height="10" width="30%"><img src="'.APP.'webroot/img/pixel_img_7.png" width="'.($section['overall']['avg']*20).'" height="10px"/></td><td width="20%">('.number_format($section['overall']['avg'],2).')</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>'; 
				  
				                  
                  
                  $i++; }                  
                                   
         $html.='</tbody></table>
        </div>
    </div>
	<br pagebreak="true">
	
    <div class="details">
    	<h3 class="report">&nbsp;&nbsp;'.__('Feedback Summary').' - '.$user['User']['first_name'].' '.$user['User']['last_name'].'</h3>';
        
        $p=1; foreach($question_data as $ques){ 
		
		if($p==1) $sect=__('Planning'); else if($p==2)  $sect=__('Organizing &amp; Staffing'); else if($p==3)  $sect=__('Directing &amp; Leading'); else if($p==4)  $sect=__('Controlling'); if($p==5)  $sect=__('Reporting'); if($p==6)  $sect=__('Risk Management'); 
		
    $html.='<div class="common_section">
        	<h3 class="section report">&nbsp;&nbsp;'.$p.'. '.$sect.'</h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>';
               $q=1; foreach($ques as $ind=>$usertype_data){  
			   		if($q%2==0) $cl='even'; else $cl='odd'; 
      $html.='<tr class="'.$cl.'">
                    <td width="30%"> 
						<table>
                        <tr>
							<td>'.$ind.'. '.$usertype_data['question'].'</td></tr>
                        <tr><td class="comment" style="border: 1px dashed #666666;">'.__('Comments').':-<br><br>'.$usertype_data['comments'].'</td></tr>
                        </table>
					</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr>
                            	<td width="25%">&nbsp;</td>
								<td class="boxnum"  style="height:10px">
									<table cellpadding="4" cellspacing="0" border="0">
										<tr>
											<td class="spbox">A</td>
											<td class="spbox">B</td>
											<td class="spbox">C</td>
											<td class="spbox">D</td>
											<td class="spbox">E</td>
										</tr>
									</table>
								</td>
								<td width="40%">&nbsp;</td>
								<td>&nbsp;</td>
                            </tr>';
                
		for($r=3;$r<8;$r++){ 
			if($r==3) $uts=__('Project Manager:'); else if($r==4) $uts=__('Team member:'); else if($r==5) $uts=__('Manager of Project Managers:'); else if($r==6) $uts='Own Score: '; else $uts=__('Overall');			
      $html.='<tr>
                    <td width="25%">'.$uts.'</td><td class="boxnum"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
                                
             for($l=5;$l>0;$l--){  
			 	if(!isset($usertype_data['usertype'][$r]['count'][$l])){  $count_cl='none'; $bgcolor='#fff'; }else{ $count_cl=''; $bgcolor='#999';}
					if(!isset($usertype_data['usertype'][$r]['count'][$l]))  $count_d='&nbsp;'; else $count_d=$usertype_data['usertype'][$r]['count'][$l];
						
				$html.='<td class="'.$count_cl.' spbox" bgcolor="'.$bgcolor.'" style="color:#fff;">'.$count_d.'</td>';
				
			}
              if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi=$usertype_data['usertype'][$r]['avg']*20; else $avg_indi=0; 
			  if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi_num=number_format($usertype_data['usertype'][$r]['avg'],2); else $avg_indi_num=0; 
			     
        $html.='</tr></table></td><td  width="40%"><img src="'.APP.'webroot/img/pixel_img_'.$r.'.png" width="'.$avg_indi.'" height="10"/></td><td class="pad">('.$avg_indi_num.')</td>
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
	

pr($html);die;
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

$tcpdf->writeHTML($html, true, false, true, false, '');
$tcpdf->lastPage();
echo $tcpdf->Output('Report.pdf', 'D');
?>