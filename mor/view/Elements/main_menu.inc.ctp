<?php 
$rType=0;
if($this->params['action']=='recharge_now' || $this->params['action']=='profile' ){
	$rType=1;
}

if(isset($ReqData['Recharge']['type']) && !empty($ReqData['Recharge']['type'])){
	$rType=$ReqData['Recharge']['type'];
}

if(isset($_REQUEST['c_tab']) && !empty($_REQUEST['c_tab'])){
	$rType=$_REQUEST['c_tab'];
}
//echo $rType;die;
?>

<ul id="main_menu" class="tab">
	<li id="prepaid"  class="<?php if(in_array($rType,array(1,2,3))){?>active<?php }?>">	
	<a href="javascript:void(0);" onclick="return showRechargeForm(1);">Prepaid Recharge</a>
	<section class="submenu_box">       
                        
	<ul class="<?php if(in_array($rType,array(1,2,3))){?>visible<?php }else{?>hidden<?php }?>">
		<li id="re_type_1" class="re_type <?php if($rType==1 || empty($rType)){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(1);">Mobile</a></li>
		<li id="re_type_2" class="re_type <?php if($rType==2){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(2);">DTH</a></li>
		<li id="re_type_3"  class="re_type <?php if($rType==3){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(3);">Data Card</a></li>
	</ul>	
	</section>
	</li>
	
	<li id="bill_payments" class="<?php if(in_array($rType,array(4,5,6,7))){?>active<?php }?>">
	<a href="javascript:void(0);" onclick="return showRechargeForm(4);">Bill Payments</a>
	<section class="submenu_box">
 	<ul class="<?php if(in_array($rType,array(4,5,6,7))){?>visible<?php }else{?>hidden<?php }?>">
		<li id="re_type_4" class="re_type <?php if($rType==4 || empty($rType)){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(4);">Mobile</a></li>
		<li id="re_type_5" class="re_type <?php if($rType==5){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(5);">Landline</a></li>
		<li id="re_type_6" class="re_type <?php if($rType==6){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(6);">Electricity</a></li>
		<li id="re_type_7" class="re_type <?php if($rType==7){?>active<?php }?>"> 
		<a href="javascript:void(0);" onclick="return showRechargeForm(7);">Gas</a></li>
	</ul>
	</section>
	
	</li>
	
	<!--  
	<li id="insurance" class="<?php if($rType==8){?>active<?php }?>">
	<a href="javascript:void(0);" onclick="return showRechargeForm(8);">Insurance</a>
	
	<section class="submenu_box">                  
                        
	<ul class="<?php if(in_array($rType,array(8))){?>visible<?php }else{?>hidden<?php }?>">
		<li id="re_type_8" class="re_type <?php if($rType==8 || empty($rType)){?>active<?php }?>">
		<a href="javascript:void(0);" onclick="return showRechargeForm(8);">Premium Payment</a></li>
		
	</ul>	
	</section>
	
	</li>
	-->
</ul>
<?php 
if(isset($social_links)){
	echo  $this->Core->render($social_links['page_content']);
}?>

<script type="text/javascript">

function showRechargeForm(rType){

	<?php if($this->params['action']=='profile' || $this->params['action']=='recharge_now'){?>
	//fun is called from index page and by top menues
	$(".ajax_loader").show();

	/*--show sub tab--*/
	$("#main_menu > li").removeClass('active');
	$(".submenu_box ul").removeClass('visible');
	$(".submenu_box ul").addClass('hidden');
	
	if(rType==1 || rType==2 || rType==3){
		$("#prepaid ul").removeClass('hidden');
		$("#prepaid ul").addClass('visible');		
		$("#prepaid").addClass('active');
			
	}else if(rType==4 || rType==5 || rType==6 || rType==7){
		$("#bill_payments ul").removeClass('hidden');
		$("#bill_payments ul").addClass('visible');	
		$("#bill_payments").addClass('active');		
	}else{
		$("#insurance ul").removeClass('hidden');
		$("#insurance ul").addClass('visible');
		$("#insurance").addClass('active');		
	}
	/*--/show sub tab--*/
	
	var url="<?php echo $this->webroot;?>recharges/recharge_form/" +rType;
	$.get(url, function( data ) {
		  $(".ajax_loader").hide();		
		  $('#recharge_form').html(data); //#recharge_form refere on home/index page
		  $(".re_type").removeClass('active');
		  $("#re_type_"+rType).addClass('active');		  

		  //referesh jq trans
		  $('select').jqTransSelect();

		  /*--referesh datepicker--*/
		  $(".datepicker").datepicker({
				changeMonth: true,
		  		changeYear: true,
		  		dateFormat: 'yy-mm-dd'
			});
		  /*--/referesh datepicker--*/
	});	

	<?php }else{?>
		window.location.href="<?php echo $this->webroot;?>recharges/recharge_now/?c_tab="+rType;
	<?php }?>
}


function showOperatorNotes(opId){
	//#recharge_form refere on home/index page and fun is called from recharge form
	var url="<?php echo $this->webroot;?>recharges/get_operator_notes/" +opId;
	$.get(url, function( data ) { 
		 $('#recharge_form .notes').remove();
		 $('#recharge_form').append("<span class='notes error'>"+data+"</span>");
		 
	});	

	var serviceType=$("#RechargeType").val();

	/*--show/hide recharge filed for landline bill payments--*/ 
	if(serviceType==5){
		if(opId==44){
			$("#RechargeAccount").parent().parent().hide();
		}else{
			$("#RechargeAccount").parent().parent().show();
		}
	}
	/*--/show/hide recharge filed for landline bill payments--*/ 

	/*--show/hide recharge filed for landline bill payments--*/ 
	if(serviceType==6){
		if(opId==46){
			$("#RechargeAccount").parent().parent().show();
		}else{
			$("#RechargeAccount").parent().parent().hide();
		}
	}
	/*--/show/hide recharge filed for landline bill payments--*/ 
}

$(function(){
	$(".datepicker").datepicker({
		changeMonth: true,
  		changeYear: true,
  		dateFormat: 'yy-mm-dd'
	});
});

</script>