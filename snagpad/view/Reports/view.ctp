<?php
$html='';
$slno=1;
$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans'
//set margins
$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$tcpdf->setHeaderFont(array($textfont, '', 18));
$tcpdf->xheadercolor = array(255, 255, 255);
$tcpdf->xheadertext = '<div style="text-align:left;"><p> <b> Job Search Report </b> </p><br><p>'.$username.'</p>';
$tcpdf->xfootertext = "<b><i>SnagPad</i></b></p>";

// add a page (required with recent versions of tcpdf)
$tcpdf->AddPage(); // Front Page

$html_1 = "<p style='text-align: left;'></p>";

$tcpdf->SetY(-270);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 12);
$tcpdf->writeHTMLCell(-250, '', '', '', $html_1, 0, 0, false, true, 'C');

$curNtDateTime = explode(' ', Date('d-m-Y H:i:s'));
$curDate = $curNtDateTime[0];
$curTime = $curNtDateTime[1];


$lefthtml = "<b>Date: </b>".$display_date;
//$lefthtml = "<b>Date: </b>$curDate";

$tcpdf->SetY(-260);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 12);
$tcpdf->writeHTMLCell(-250, '', '', '', $lefthtml, 0, 0, false, true, 'L');


//$righthtml = "<b>Time: </b>$curTime";
$righthtml = "";

$tcpdf->SetY(-260);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont('times', '', 12);
$tcpdf->writeHTMLCell(-250, '', '', '', $righthtml, 0, 0, false, true, 'R');

$html = "<style>
    table
    {
        border-collapse:collapse;
    }
    table,th, td
    {
        border: 1px solid black;
    }
   </style>

    <table  cellspacing='0' cellpadding='20'>
        <tr>
            <td ><b>S. No</b></td>
            <td ><b>Applied Date</b></td>
			<td ><b>Job</b></td>
			<td ><b>Company Name</b></td>
			<td ><b>Contact Person</b></td>
			<td ><b>Opportunity found through</b></td>
			<td ><b>Job type</b></td>
			<td ><b>Job card column</b></td>
           
        </tr>";
foreach($cards as $card){ 
		if(!empty($card['applied_date'])){ 
		$contact=null;
		if(!empty($card['contact'])) { 
									foreach($card['contact'] as $c){
										
										$contact.= $c['Contact']['contact_name'].' ';
										}
								}else{ $contact= 'NA';}
		if(!empty($card['Card']['type_of_opportunity'])){ $type_op=$card['Card']['type_of_opportunity']; }else{ $type_op='NA';}						

    $html.= '<tr>';
    $html.= '<td>' . $slno++ . '</td><td>' . show_formatted_date($card['applied_date']['Cardchecklist']['date_added']) . '</td>';
	$html.= '<td>' . $card['Card']['position_available'] . '</td>';
	$html.= '<td>' . $card['Card']['company_name'] . '</td>';
	$html.= '<td>' . $contact . '</td>';
	$html.= '<td>' . $type_op . '</td>';
	$html.= '<td>' . 'Full time'. '</td>';
	$html.= '<td>' . 'Applied' . '</td>';
    $html.= '</tr>';
}}

$html.="</table>";


$tcpdf->setY(-240);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 12);

// output the HTML content
$tcpdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$tcpdf->lastPage();

echo $tcpdf->Output('JobSearchReport.pdf', 'D');
?>