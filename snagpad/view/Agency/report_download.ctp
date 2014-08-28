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



$lefthtml = "<b>Date: </b>$curDate";

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

   ";
$html.='<table>
    <tr style=" border-bottom:1px solid #ccc">
        <th>Client Name</th>
        <th>Job A</th>
        <th>Employed Job A</th>
        <th>Job B</th>
        <th>Employed Job B</th>
        <th>Average Days</th>
        <th>Client SAI</th>
        <th>Movement of Cards</th>
        <th>Last Card Movement</th>
    </tr>';
$i=0;
foreach($rows as $row){ 
    if($i==0)
    {
       $html.=' <tr>
            <td><strong>'.$row['name'].'</strong></td>
            <td><strong>'.$row['job_a'].'</strong></td>
            <td><strong>'.$row['job_countA'].'</strong></td>
            <td><strong>'.$row['job_b'].'</strong></td>
            <td><strong>'.$row['job_countB'].'</strong></td>
            <td><strong>'.$row['avg'].'</strong></td>
            <td><strong>'.$row['OAI'].'</strong></td>
            <td><strong>'.$row['movement'].'</strong></td>
            <td><strong>'.show_formatted_date($row['latest_card_mov_date']).'</strong></td>
        </tr>';    

    }else{
        $html.=' <tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['job_a'].'</td>
            <td>'.$row['job_countA'].'</td>
            <td>'.$row['job_b'].'</td>
            <td>'.$row['job_countB'].'</td>
            <td>'.$row['avg'].'</td>
            <td>'.$row['OAI'].'</td>
            <td>'.$row['movement'].'</td>
            <td>'.show_formatted_date($row['latest_card_mov_date']).'</td>
        </tr>';    
    }
}
$html.="</table>";


$tcpdf->setY(-240);
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont, '', 12);

// output the HTML content
$tcpdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$tcpdf->lastPage();

echo $tcpdf->Output('CoachReport.pdf', 'D');
?>