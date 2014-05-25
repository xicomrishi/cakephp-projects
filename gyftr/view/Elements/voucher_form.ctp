<section class="right_header">
<form id="voucher_form" name="voucher_form" method="post">
    <span><input type="text" name="voucher_code" placeholder="Check your voucher details" id="voucher_code"></span>
    <input type="button" value="check" onclick="return check_voucher();">
    </form>
</section>

<script type="text/javascript">

$(document).ready(function(e) { 
     
	    $('input:text').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
		 });		
  
});
function check_voucher(){
	
	var code=$('#voucher_code').val();
	if(code==""){
		$('#voucher_code').css('border','1px solid #FF0000');
		$('#voucher_code').css('box-shadow','0 0 8px #FF0000');
		$('#voucher_code').effect( "bounce", "fast" );
	}else{
		$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '900',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: '<?php echo $this->webroot; ?>info/check_voucher/'+code,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);		
	}
}
</script>