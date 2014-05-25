<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">Home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">Select gift type</a></li>
                  <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');">Recipient</a></li>
				<?php } ?>
				<li><a href="javascript://" onclick="return nextStep('step-3','<?php $sess=$this->Session->read('Gifting.type'); if($sess=='me_to_me') echo 'meTome'; else echo $sess; ?>');">Select Gift</a></li> 
                <li><a href="javascript://" onclick="return select_product('0');">Basket</a></li>                
                <li class="last">Delivery</li>
              </ul>
			</div>
<div id="form_section">
			            
            <span class="select_dele">/ / Delivery <strong>Details</strong>
            </span>
            <form id="deliveryForm" method="post" action="" onsubmit="return submit_deliveryForm();">
            <input type="hidden" id="incomp_deliver" name="incomplete_deliver" value="0"/>
             <label>Select Occasion</label>
            	<span class="text_box">
                <select name="occasion" onchange="occasion_value(this.value);">
                <?php foreach($arr as $ar){ ?>
                <option value="<?php echo $ar['value']; ?>" <?php if($this->Session->check('Gifting.delivery_details.occasion')){ if($this->Session->read('Gifting.delivery_details.occasion')==$ar['value']) { echo 'selected'; }} ?>><?php echo $ar['name']; ?></option>
                <?php } ?>
                	
                    <option value="other">Other</option>
                </select>
            		
                </span>
             <div class="text_box" id="other_textbox" style="display:none">
            <input type="text" name="other_occasion" class="validate[required]" style="width:39%; border-radius:6px; -webkit-border-radius:6px; padding:0 5px"/>
            </div>
                
                <span class="date_textbox">
                	<input type="text" id="delivery_date" placeholder="Date and Time of Delivery" name="delivery_time" class="text_date validate[required]" onclick="removeClass('#ui-datepicker-div','register'); $('html, body').animate({ scrollTop: $('body').position().top += 100 }, 600);" value="<?php if($this->Session->check('Gifting.delivery_details.delivery_time')){ echo $this->Session->read('Gifting.delivery_details.delivery_time'); } ?>" readonly="readonly"/>
                </span>
           <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
            <h3>Would you like to send a Partial Gift?</h3>
            <div class="action">
            	<a href="javascript://"  class="yes check_delivery <?php if($this->Session->check('Gifting.delivery_details.incomplete_deliver')){ if($this->Session->read('Gifting.delivery_details.incomplete_deliver')=='1') { echo 'active'; }} ?>" id="delivery_yes">Yes - Send Partial Gift</a>
                <a href="javascript://"  class="no check_delivery <?php if($this->Session->check('Gifting.delivery_details.incomplete_deliver')){ if($this->Session->read('Gifting.delivery_details.incomplete_deliver')=='0') { echo 'active'; }} ?>" id="delivery_no">No - Send Complete Gift Only</a>
            </div>
            <h3 style="font-size:12px !important;">In Partial Gift, the gift is shared even if the contribution towards the gift is not complete and the recipients can contribute the little shortfall.</h3>
           <?php }?> 
             <div class="text_box"  <?php if($this->Session->read('Gifting.type')=='me_to_me'){ echo 'style="margin-top:26px;"'; }?>>
            <input class="done" type="submit" value="SUBMIT" style="margin-top:0px;">
            </div>
             </form>
            <div class="bottom">
            	<span class="left_img">
                <?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
       </div>
<script type="text/javascript">
$(document).ready(function(e) {
	
	 <?php if(!$this->Session->check('Gifting.delivery_details')) { ?>

        $('input[placeholder]').each(function(){  
			var input = $(this);        
			
			$(input).val(input.attr('placeholder'));
						
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			   setTimeout(function(){ $('input').css('border','1px solid #ABD0E9'); },100);
			   
			});
		});
    
  <?php } ?>  
	
	$("#deliveryForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	$('.check_delivery').click(function(e) {
       		
				if($(this).attr('id')=='delivery_yes')
				{
					$('#delivery_no').removeClass('active');
					$('#delivery_yes').addClass('active');
					$('#incomp_deliver').val('1');
					//submit_deliveryForm();	
				}else{
					$('#delivery_yes').removeClass('active');
					$('#delivery_no').addClass('active');
					$('#incomp_deliver').val('0');
					//submit_deliveryForm();
				}
    });
	var to_day=new Date();
    $('.text_date').datetimepicker({
			showOn: 'both',
            buttonImage: '<?php echo SITE_URL; ?>/img/calender_search_bg.png',
			dateFormat:"dd-mm-yy",
			currentText:'Send Gift Now',
			 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
			//timeFormat: "hh:mm",
		showMinute: true,
            buttonImageOnly: true,
			onSelect: function(dateText, inst) {
					$('#delivery_date').val(dateText);
					//$(this).datetimepicker('hide');
				}
			});
});

function occasion_value(val)
{
	if(val=='other')
	{
		$('#other_textbox').show();	
		addClass('#ui-datepicker-div','other');
	}else{
		$('#other_textbox').hide();
		removeClass('#ui-datepicker-div','other');
	}
}
</script>          