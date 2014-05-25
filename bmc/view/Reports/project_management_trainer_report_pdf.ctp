<?php
App::import('Vendor','xtcpdf'); 
//echo $this->Html->css('style');
$tcpdf = new XTCPDF(); 
$html='';
$slno=1;
$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans'

$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$tcpdf->setPrintHeader(false);
$tagvs = array('h1' => array(0 => array('h' => 1, 'n' => 3), 1 => array('h' => 1, 'n' => 2)),
               'h2' => array(0 => array('h' => 1, 'n' => 2), 1 => array('h' => 1, 'n' => 1)),
			   'h3' => array(0 => array('h' => 1, 'n' => 2), 1 => array('h' => 1, 'n' => 1)));
$tcpdf->setHtmlVSpace($tagvs);
$title_data='';
if(isset($fi_company)){
	$title_data.='<br><br>'.__('Company').': '.$fi_company['Company']['company'];
}
if(isset($fi_company_location)){
	$title_data.='<br><br>'.('Company Location').': '.$fi_company_location['Country']['country_name'];
}
if(isset($fi_industry)){
	$title_data.='<br><br>'.__('Industry').': '.$fi_industry['Industry']['industry'];
}
if(isset($fi_role)){
	$title_data.='<br><br>'.__('Role').': '.$fi_role;
}
if(isset($fi_country)){
	$title_data.='<br><br>'.__('Country').': '.$fi_country['Country']['country_name'];
}
if(isset($fi_year)){
	$title_data.='<br><br>'.__('Year').': '.$fi_year;
}

$tcpdf->xfootertext = '<table><tr><td style="font-size:8px; text-align:left;">'.__('BMC Assessment Inventory of Project Management Report').'</td><td style="font-size:8px; text-align:right;">'.__('Created').': '.show_formatted_date(date("Y-m-d")).'</td></tr></table>';
$tcpdf->AddPage(); // Front Page

$html_front = __('Project Management Assessment Report').'<br><br>'.__('Trainer').': '.$user['User']['first_name'].' '.$user['User']['last_name'].'<br><br>'.__('Group').': '.$course['Course']['course_name'].$title_data;
$tcpdf->SetY(-270);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 18);
$tcpdf->writeHTMLCell(-250, '', '', '', $html_front, 0, 0, false, true, 'C');


$tcpdf->AddPage(); // Front Page
$html_1='';
$html_1.= '<div class="wrapper">  
  <section id="body_container">
  
  	<div class="details"> 
         	<h3 class="report" style="background-color:#132540; color:#FFFFFF;">&nbsp;&nbsp;'.__('Introduction').'</h3>'.$intro_text.'</div>';
		 
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html_1, true, false, true, false, '');	
	 
$tcpdf->AddPage();
$html='<style>
    table{border-collapse:collapse;padding:5px; }
	
    .even{background-color:#F8F8F8;}
	td{font-size:8px;}
	.report{ background-color:#132540;color: #FFFFFF;}
	.spbox{ border:1px solid black;}
   </style>';	 
$html.='<div class="details">
    	<h3 class="report">&nbsp;&nbsp;'.__('Section Averages Summary').'</h3>
       	<div class="inner none"> 
                <table class="table none tb_1">
                  <tbody>';
                  $i=1; foreach($section_data as $section){ 
                  	if($i%2==0) $class='even'; else $class='odd';
          $html.='<tr class="'.$class.'">
                    <td>';
					
			if($i==1) $secti=__('Planning'); else if($i==2)  $secti=__('Organizing &amp; Staffing'); else if($i==3)  $secti=__('Directing &amp; Leading'); else if($i==4)  $secti=__('Controlling'); if($i==5)  $secti=__('Reporting'); if($i==6)  $secti=__('Risk Management'); 
         $html.=$secti.'</td>
                    <td>                    	
                        <table class="summery_details">';                      
                     
					  	for($j=3;$j<6;$j++){
							if($j==3) $ut=__('Project Manager:'); else if($j==4) $ut=__('Team member:'); else if($j==5) $ut=__('Manager of Project Managers:');
							if(isset($section['usertype'][$j]['avg'])) $avg=number_format($section['usertype'][$j]['avg']*20,0); else $avg=0;
							if(isset($section['usertype'][$j]['avg'])) $avg_num=number_format($section['usertype'][$j]['avg'],2); else $avg_num=0;
        $html.='<tr>
                   <td width="30%">'.$ut.'</td><td height="10" width="50%"><img src="'.APP.'/webroot/img/pixel_img_'.$j.'.png" width="'.$avg.'" height="10px"/></td><td>('.$avg_num.')</td>
                            </tr>';                       
                         }   
        $html.='</table>                        
                     </td>
                  </tr>';                  
                $i++; }                  
                                   
       $html.='</tbody></table>
        </div>
    </div>';
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html, true, false, true, false, '');	
$tcpdf->Image($section_chart_link, '', '', 120);	 
$tcpdf->AddPage();	
$html_0=array();
	
	
        
        $p=1; foreach($question_data as $ques){ 
		$html_0[$p]=$html_1[$p]='';
		
		if($p==1)
		{
			$html_0[$p].='<div class="details">
			<h3 class="report">&nbsp;&nbsp;'.__('Feedback Summary').'</h3>';		
		}
		$html_0[$p].='<style>
		table{border-collapse:collapse;padding:5px; }
		
		.even{background-color:#F8F8F8;}
		td{font-size:8px;}
		.report{ background-color:#132540;color: #FFFFFF;}
		.spbox{ border:1px solid black;}
	   </style>';
		
			if($p==1) $sect=__('Planning'); else if($p==2)  $sect=__('Organizing &amp; Staffing'); else if($p==3)  $sect=__('Directing &amp; Leading'); else if($p==4)  $sect=__('Controlling'); if($p==5)  $sect=__('Reporting'); if($p==6)  $sect=__('Risk Management'); 
			
      $html_0[$p].='<div class="common_section">
        	<h3 class="section report">&nbsp;&nbsp;'.$p.'. '.$sect.'</h3>
        	<div class="inner none"> 
                <table class="table none" >
                <tbody>';
           $q=1; foreach($ques as $ind=>$usertype_data){ 
		   			if($q%2==0) $cl='even'; else $cl='odd'; 
      $html_0[$p].='<tr class="'.$cl.'">
                    <td width="30%">'.$ind.'. '.$usertype_data['question'].'</td>
                    <td width="70%">
                    	<table class="summery_details">
                        	<tr>
                            	<td width="25%">&nbsp;</td>
								<td class="boxnum">
									<table  cellpadding="4" cellspacing="0" border="0">
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
                         
			for($r=3;$r<6;$r++){ 
				if($r==3) $uts=__('Project Manager:'); else if($r==4) $uts=__('Team member:'); else if($r==5) $uts=__('Manager of Project Managers:'); else $uts=__('Own Score: ');
       $html_0[$p].='<tr>
                      <td width="25%">'.$uts.'</td><td class="boxnum"><table  cellpadding="4" cellspacing="0" border="0"><tr>';
			for($l=5;$l>0;$l--){ 
					if(!isset($usertype_data['usertype'][$r]['count'][$l])){  $count_cl='none'; $bgcolor='#fff'; }else{ $count_cl=''; $bgcolor='#999';}
					if(!isset($usertype_data['usertype'][$r]['count'][$l]))  $count_d='&nbsp;'; else $count_d=$usertype_data['usertype'][$r]['count'][$l];
						
		$html_0[$p].='<td class="'.$count_cl.' spbox" bgcolor="'.$bgcolor.'" style="color:#fff;">'.$count_d.'</td>';
			}
              if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi=$usertype_data['usertype'][$r]['avg']*20; else $avg_indi=0; 
			  if(isset($usertype_data['usertype'][$r]['avg'])) $avg_indi_num=number_format($usertype_data['usertype'][$r]['avg'],2); else $avg_indi_num=0; 
			     
        $html_0[$p].='</tr></table></td><td  width="40%"><img src="'.APP.'webroot/img/pixel_img_'.$r.'.png" width="'.$avg_indi.'" height="10px"/></td><td class="pad">('.$avg_indi_num.')</td>
                            </tr>';
                            }                             
                           
        $html_0[$p].='</table>
                     </td>
                  </tr>';                  
                $q++; }  
				  
        $html_0[$p].='</tbody>
                </table>
        	</div>
        </div>';
		
		if($p==6)
		{
			 $html_0[$p].='</div>
			  </section>
			</div>';	
		}

	
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html_0[$p], true, false, true, false, '');
$tcpdf->AddPage();	
$tcpdf->Image($question_chart_link[$p], '', '', 130);	 
 
 $tcpdf->setY(80);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);
$tcpdf->writeHTML($question_chart_text[$p], true, false, true, false, '');	

$tcpdf->AddPage();			
		
       $p++; } 
  
//pr($html); die;
/*$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html_0, true, false, true, false, '');*/

// reset pointer to the last page
$tcpdf->lastPage();

echo $tcpdf->Output('Report.pdf', 'D');
?>