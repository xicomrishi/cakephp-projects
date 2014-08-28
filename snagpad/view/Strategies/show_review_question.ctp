<section class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </section>
  <section class="submit_right">
   <div id="opp_error"></div>
  <form id="strat_reviewForm" name="strat_reviewForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
    	<h3>Review the questions asked in this interview and consider:</h3>
        <ul>
        <li>
- Were there any questions you felt uncomfortable answering? How can you respond better and more confidently next time?</li>
<li>- Did you provide any particular answers that you felt came across really well or bad?</li>
<li>- Were any questions tricky to answer and would require additional preparation?</li>
<li>- Were there unusual questions that may be asked by other employers?</li>
<li>- Did you sense any questions may have taken you out of the running for this position?</li>
<li>- Did you sense any questions may have improved your chances for this position?</li>
<li>- Did any of your responses require follow up or clarification to strengthen your position?</li></ul>
    <div class="submit_row">
     <a href="javascript://" onclick="submit_review_question();" class="save_btn">OK</a></div>
   </form>
   
</section>

<script type="text/javascript">

function submit_review_question()
{		var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/save_review_question',$('#strat_reviewForm').serialize(),function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		
		
}	


</script>
        