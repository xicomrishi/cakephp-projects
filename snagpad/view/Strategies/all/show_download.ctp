<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
   <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
   <form id="strat_downForm" name="strat_downForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
     
   		<?php if($flag=='2'){ ?>
        <h3>
        Whether this is your Job A or Job B, the need to tap into your new job network is critical to your success.<br/> 
	If you can succeed at becoming a top social networker you're more likely to accomplish your goals. The key to your success is to</h3>
	<ol><li> Be clear on what you hope to accomplish,</li><li>Link your goals to people who can help you,</li><li>Develop connections strategies and</li><li> Create win-win relationships.</li></ol> <p>If you would like to take a short course on becoming a top social networker, click on the button below.</p>
		<?php } ?>
        <div class="submit_row<?php if($flag!='2'){ echo '1';} ?>">
       <a href="<?php echo $path; ?>" target="_blank" onclick="submit_download();" class="save_btn"><?php echo $action_button_text;?></a></div>

   </form>
   
</div>

<script type="text/javascript">
function submit_download()
{
	<?php if($disabled==""){?>
	var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',$('#strat_downForm').serialize(),function(data) {
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	<?php }?>		
			
}
</script>
      