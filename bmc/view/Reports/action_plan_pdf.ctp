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

$tcpdf->xfootertext = '<table><tr><td style="font-size:8px; text-align:left;">'.__('Action Plan').'</td><td style="font-size:8px; text-align:right;">'.__('Created').': '.show_formatted_date(date("Y-m-d")).'</td></tr></table>';
$tcpdf->AddPage(); // Front Page

$html_front = __('Action Plan').'<br><br>'.__('Participant').': '.$participant['User']['first_name'].' '.$participant['User']['last_name'].'<br><br>'.__('Group Name').': '.$participant['Course']['course_name'].'<br><br>'.__('Company').': '.$participant['User']['Company']['company'];
$tcpdf->SetY(-270);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 18);
$tcpdf->writeHTMLCell(-250, '', '', '', $html_front, 0, 0, false, true, 'C');


$tcpdf->AddPage(); // Front Page
$html_1='';
$html_1.= '<div class="wrapper">
  <section id="body_container">
  	<div class="details"> 
         	<h3 class="report" style="background-color:#132540; color:#FFFFFF;">&nbsp;&nbsp;'.__('DIRECTIONS').'</h3>'.$intro_text.'</div>';

		 
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html_1, true, false, true, false, '');		 
$tcpdf->AddPage();
$html='<style>
    td.top {
    border-bottom: 1px solid #EAEAEA;    
}
table{ padding: 5px; }
   </style>';

$html.= '<div class="details">
    	<h3 class="report center" style="background-color:#132540; color:#FFFFFF;">&nbsp;&nbsp;'.__('THE ACTION PLAN').'</h3>';       
        for($i=1;$i<7;$i++){ 		
			if($i==1) $plan=__('Planning'); else if($i==2) $plan=__('Organizing and Staffing'); else if($i==3) $plan=__('Directing and Leading'); else if($i==4) $plan=__('Controlling'); else if($i==5) $plan=__('Reporting'); else if($i==6) $plan=__('Risk Management'); 
		
$html.= '<div class="common_section">
        	<h3 class="section report" style="background-color:#132540; color:#FFFFFF;">&nbsp;&nbsp;'.__('Key Result Area').': '.$plan.'</h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>';
                $j=1; foreach($questions as $ques){ 
					if($j%2==0) $class='even'; else $class='odd';
$html.= '<tr class="'.$class.'">
                    <td align="left" width="5%" valign="top">'.$j.')</td>
                    <td align="left" width="88%" valign="top">
                    	<table class="summery_details none">';
					if($ques['APquestion']['question_key']==1||$ques['APquestion']['question_key']==4)
						$question=$ques['APquestion']['question'].' '.$plan.'?';
					else
						$question=$ques['APquestion']['question'];
							
$html.= '<tr><td valign="top">'.$question.'</td></tr>';
          if($ques['APquestion']['question_key']==4){ 
             $html.= '<tr><td><table width="100%" class="formTable"><tr><td valign="top" width="64.8%" class="full">&nbsp;</td><td valign="top" width="20%">'.__('By When').'?</td><td valign="top" width="20%">'.__('By Whom').'?</td></tr></table></td></tr>';
                       } 
                        
                for($m=1; $m<($ques['APquestion']['ans_count']+1); $m++){ 
					if($m==1) $number='a)'; else if($m==2) $number='b)'; else if($m==3)  $number='c)'; 
					if($ques['APquestion']['question_key']==4){ 
					
					  $html.= '<tr><td><table width="100%" style="padding:2px;"><tr><td valign="top" width="64.8%" class="full top">'.$number.'.&nbsp;</td><td valign="top"  class="top"width="20%">&nbsp;</td><td valign="top" class="top" width="20%">&nbsp;</td></tr></table></td></tr>';
                              }else{                                        
                     $html.= '<tr><td valign="top" class="top">'.$number.'.&nbsp;</td></tr>';
                        }
					} 
    $html.= '</table>
                     </td>
                  </tr>';                  
                  
                  $j++; }
     $html.= '</tbody>
                
               </table>
        	</div>
        </div>';
         } 
      
       
         $html.= '</div>
  </section>
</div>';

//pr($html); die;
$tcpdf->setY(-300);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 8);

// output the HTML content
$tcpdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$tcpdf->lastPage();

echo $tcpdf->Output('ActionPlan.pdf', 'D');
?>  		 