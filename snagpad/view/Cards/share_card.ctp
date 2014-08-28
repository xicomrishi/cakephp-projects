<section class="tabing_container">
<section class="job_search_section" style="padding:0 15px; width:768px">
	
		<section class="heading_row">
        <span class="col2 full">Who would you like to share with?</span>
         <span class="col2">Share with all : </span>
         <span class="col3"><input type="checkbox" id="share_with_all" onclick="share_all_check();"/></span>
        </section>
        <section class="heading_row">
        <span class="col2">Coach(es) : </span>
        <span class="col3 full"><?php if(is_array($coaches)){ ?>
			<input type="checkbox" id="all_coach_check" onclick="select_all_check('0');"/> Select all<br>
        <?php
			foreach($coaches as $coach)
				echo "<input type='checkbox' class='coach_ch' name='coach[]' onclick='uncheck(0);' value='".$coach['Coach']['account_id']."'>   ".$coach['Coach']['name']."<br>" ;
		}else echo "No Coach found";?></span>
        </section>
        <section class="heading_row">
        <span class="col2">Client(s) : </span>
        <span class="col3"><?php if(is_array($coaches)){ ?>
        	<input type="checkbox" id="all_client_check" onclick="select_all_check('1');"/> Select all<br>
        <?php
			foreach($clients as $client)
				echo "<input type='checkbox' class='client_ch' name='client[]' onclick='uncheck(1);' value='".$client['Client']['account_id']."'>  ".$client['Client']['name']."<br>" ;
		}else echo "No Client found";?></span>
        </section>
        <section class="heading_row">
        <span class="col2"></span>
        <span class="common_btn"><a href="javascript://" onclick="shareCard()" class="submitbtn" style="float:none !important; display:inline-block">save</a></span>
        </section>    
</section>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 600);
	
});

function shareCard(){
	el=document.getElementsByName('coach[]');
	el1=document.getElementsByName('client[]');
	l=el.length; l1=el1.length;
	var ch='';var cl='';
	for(i=0;i<l;i++)
		if(el[i].checked==true)
			ch+=el[i].value+",";
	for(i=0;i<l1;i++)
		if(el1[i].checked==true)
			cl+=el1[i].value+",";		
$('#coach_ids').val(ch);
$('#client_ids').val(cl);
disablePopup();	
confirmCard();
}

function select_all_check(val)
{
	var che=null;
	var cl=null;
	if(val=='0'){ 
		che='#all_coach_check'; 
		cl='.coach_ch';
	}else{
		che='#all_client_check';
		cl='.client_ch';
		}
	if($(che).attr('checked'))
	{
		$(cl).each(function(index, element) {
         $(this).attr('checked',true);
				
     });
	 
	}else{
	$(cl).each(function(index, element) {
        
		$(this).attr('checked',false);
				
    });
	}
}
function uncheck(val)
{
	var chid=null;
	if(val=='0'){ 
		chid='#all_coach_check'; 
	}else{
		chid='#all_client_check';
	}
	if($(chid).attr('checked'))
	{
		$(chid).attr('checked',false);
	}	
}
function share_all_check()
{
	if($('#share_with_all').attr('checked'))
	{
		$('input:checkbox').each(function(index, element) {
         $(this).attr('checked',false);
		 $(this).attr('disabled',true);
		 $('#share_all_card').val('1');	
		 $('#share_with_all').attr('checked',true);
		 $('#share_with_all').attr('disabled',false);			
     });
	 
	}else{
	$('input:checkbox').each(function(index, element) {
         $(this).attr('checked',false);	
		 $(this).attr('disabled',false);
		 $('#share_all_card').val('0');				
     });
	}	
}
</script>