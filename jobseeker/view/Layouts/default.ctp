<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>

<?php
echo $this->Html->meta('icon');
//echo $this->Html->css('cake.generic');
echo $this->Html->css('frontend/style');
echo $this->Html->css('frontend/jquery.fancybox');
echo $this->Html->css('frontend/extra');
echo $this->Html->css('frontend/validationEngine.jquery');
echo $this->Html->css('jquery.autocomplete');
echo $this->Html->css('jquery-ui');

?>
<!--[if IE 6]><?php echo $this->Html->script(array('frontend/jq-png-min'));?><![endif]-->
<!--[if IE]><?php echo $this->Html->script(array('frontend/ieh5fix'));?></script><![endif]-->

<?php 
echo $this->Html->script(array('frontend/jquery','frontend/ajaxupload.3.5','frontend/hoverCard','frontend/index',
'frontend/jquery.fancybox','frontend/jquery.autocomplete.min','frontend/jquery-ui','frontend/jquery.validationEngine','frontend/jquery.validationEngine-en'));
echo $scripts_for_layout;
?>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
</head>
<body>
<noscript>
<div class="notice"><p>This is a Warning Notice! You will need to enable JavaScript on your browser.</p></div>
</noscript>
<?php echo $this->element('feedback');?>
<?php echo $this->element('header_default');?>
<?php echo $content_for_layout; ?>
<?php echo $this->element('footer');?>
</body>
<script type="text/javascript">
$(function(){

$('.ui-datepicker,.ui-datepicker table,.ui-datepicker table thead tr th span,.ui-datepicker-header a,.ui-datepicker-header a span,.ui-datepicker-title select,.ui-datepicker-title select option,.ui-datepicker-title span,.ui-datepicker table tbody tr td span').click(function(e) {
	e.stopPropagation();
});
if (navigator.appName == 'Microsoft Internet Explorer'){
$('input[placeholder]').each(function(){  
			var input = $(this);
			
			if($(input).val()==''){        
			$(input).val(input.attr('placeholder'));
			if(input.attr('id')!='ProfessionalCompanyWebsite' || input.attr('id')!='RecruiterCompanyWebsite' || input.attr('id')!='RecruiterClientCompanyWebsite'){					
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			});
			}
			if(input.attr('id')=='ProfessionalCompanyWebsite' || input.attr('id')=='RecruiterCompanyWebsite' || input.attr('id')=='RecruiterClientCompanyWebsite'){	
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder') || input.val() =='') {
				   input.val('http://');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == input.attr('placeholder') || input.val() == 'http://') {
				   input.val('');
			   }
			});
			}
			}
		});
}
	
});

function insertMessage() {
    clearTimeout(insertMessage.timer);

    if ($('#ui-datepicker-div .ui-datepicker-calendar').is(':visible')){
		
		<?php 
		$str='<div id="calClose" onclick="return closeDatepicker();">X</div><div class="monthTabs">';
		$str1='<div class="switchMonth"><span>«</span><span id="currentMonth">'.date('F Y').'</span><span>»</span></div>';
		for($i=0;$i<12;$i++){
			if($i==0){
			$str.='<span class="current" id="'.date('M', strtotime(''.$i.' month')).'" onclick="return showMonth(this,&quot;'.date('F Y', strtotime(''.$i.' month')).'&quot;)">'.date('M', strtotime(''.$i.' month')).'</span>';
			}else{
				$str.='<span id="'.date('M', strtotime(''.$i.' month')).'" onclick="return showMonth(this,&quot;'.date('F Y', strtotime(''.$i.' month')).'&quot;)">'.date('M', strtotime(''.$i.' month')).'</span>';
			}
		}
		$str.='</div>';?>
		
		
        $('#ui-datepicker-div').prepend('<?php echo $str;?>');
		$('#ui-datepicker-div').append('<?php echo $str1;?>');
		
		
	}else
        insertMessage.timer = setTimeout(insertMessage, 10);
}
function insertMessage1() {
    clearTimeout(insertMessage1.timer);

    if ($('#ui-datepicker-div .ui-datepicker-calendar').is(':visible')){
		
		
			<?php 
		$str='<div id="calClose" onclick="return closeDatepicker();">X</div><div class="monthTabs">';
		$str1='<div class="switchMonth"><span>«</span><span id="currentMonth">'.date('F Y').'</span><span>»</span></div>';
		for($i=0;$i<6;$i++){
			if($i==0){
			$str.='<span class="current" id="'.date('M', strtotime(''.$i.' month')).'" onclick="return showMonth1(this,&quot;'.date('F Y', strtotime(''.$i.' month')).'&quot;)">'.date('M', strtotime(''.$i.' month')).'</span>';
			}else{
				$str.='<span id="'.date('M', strtotime(''.$i.' month')).'" onclick="return showMonth1(this,&quot;'.date('F Y', strtotime(''.$i.' month')).'&quot;)">'.date('M', strtotime(''.$i.' month')).'</span>';
			}
		}
		$str.='</div>';?>
		
        $('#ui-datepicker-div').prepend('<?php echo $str;?>');
		$('#ui-datepicker-div').append('<?php echo $str1;?>');
		
		
	}else
        insertMessage1.timer = setTimeout(insertMessage1, 10);
}
$('#ui-datepicker-div').delegate('.ui-datepicker-prev, .ui-datepicker-next', 'click', insertMessage);
function showMonth1(obj,curMonth){
	 
		var indx=$(obj).index();
		var curMon=$(obj).attr('id');
		$( "#joining_by_date" ).datepicker('setDate','+'+indx+'m');
		$( "#joining_by_date" ).datepicker("refresh");
		insertMessage1();
		$('.monthTabs span').removeClass('current');
		$('.monthTabs #'+curMon).addClass('current');
		$('.switchMonth').html('<span>«</span><span id="currentMonth">'+curMonth+'</span><span>»</span>');
		
}
function showMonth(obj,curMonth){
	 
		var indx=$(obj).index();
		var curMon=$(obj).attr('id');
		$( "#unavailable_by_date" ).datepicker('setDate','+'+indx+'m');
		$( "#unavailable_by_date" ).datepicker("refresh");
		insertMessage();
		$('.monthTabs span').removeClass('current');
		$('.monthTabs #'+curMon).addClass('current');
		$('.switchMonth').html('<span>«</span><span id="currentMonth">'+curMonth+'</span><span>»</span>');
		
}
function changeMonth()
{
	 
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
	var fullMonthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];
	
	var monthIndex=parseInt($("#unavailable_by_date").datepicker('getDate').getMonth());
	setTimeout(function(){
	$('.monthTabs span').removeClass('current');
	$('.monthTabs #'+monthNames[monthIndex]).addClass('current');
	$('.switchMonth').html('<span>«</span><span id="currentMonth">'+fullMonthNames[monthIndex]+' '+$("#unavailable_by_date").datepicker('getDate').getFullYear()+'</span><span>»</span>');
	},100);
		
		
}
function changeMonth1()
{
	 
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
	var fullMonthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];
	
	var monthIndex=parseInt($("#joining_by_date").datepicker('getDate').getMonth());
	setTimeout(function(){
	$('.monthTabs span').removeClass('current');
	$('.monthTabs #'+monthNames[monthIndex]).addClass('current');
	$('.switchMonth').html('<span>«</span><span id="currentMonth">'+fullMonthNames[monthIndex]+' '+$("#joining_by_date").datepicker('getDate').getFullYear()+'</span><span>»</span>');
	},100);
		
		
}
function closeDatepicker(){
	$('#ui-datepicker-div').hide();
}
</script>
</html>