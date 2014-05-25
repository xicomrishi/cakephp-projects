<style>
input{ width:88%; }
</style>
<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <form id="questionsForm" name="questionsForm" method="post" action="<?php echo $this->webroot; ?>questions/save_questions" class="form">
    	<fieldset>  
        <div class="comn_row">  	
    	<div class="col">
   		<label>Language: </label>
        <select name="language_id">
        <?php foreach($language as $lang){ ?>
        	<option value="<?php echo $lang['Language']['id']; ?>"><?php echo $lang['Language']['name']; ?></option>
		<?php } ?>
        </select>
        </div>
        <div class="col">
   		<label>Role: </label>
        <select name="role_id">
        <option value="3">Project Manager</option>
        <option value="4">Team Member</option>
        <option value="5">Manager of Project Managers</option>
        </select>
        </div>	
        </div>
     <?php for($i=1;$i<7;$i++){ ?>
     	<div class="comn_sec">
        <h3 class="title"><?php if($i==1) echo __('Planning'); if($i==2) echo __('Organizing &amp; Staffing'); if($i==3) echo __('Directing &amp; Leading'); if($i==4) echo __('Controlling'); if($i==5) echo __('Reporting'); if($i==6) echo __('Risk Management'); ?></h3>
       		<div class="inner none"> 
            <table class="table none">
              <tbody>
              <tr>
                <th class="none">&nbsp;</th>                    
              </tr>
              <?php 
				  
				  for($j=1;$j<11;$j++){ ?>
                  	
                  	<tr class="<?php if($j%2==0) echo 'even'; else echo 'odd'; ?>">                   
                    	<td  class="none"><?php echo $j; ?>. <input type="text" name="ques[<?php echo $i; ?>][<?php echo $j; ?>]" value="" /></td>
                    </tr>
              	<?php  } ?>
              </tbody>
              </table>
              </div>
              
     	</div>
     <?php  } ?> 
     <div class="comn_sec">
     
     <input type="submit" value="Save" onclick="return questions_form_submit();" >
     </div>
        </fieldset>
        </form>
    </section>
  </section>
</div>

<script type="text/javascript">
function questions_form_submit()
{
	var all_answered=1;
	var tempname=null;
	$('input:text').each(function() {
		var name = $(this).attr("name");	
		var val = $(this).attr("value");
		if($.trim(val)!='')
		{	
			all_answered=2;	
		}else{
			tempname=name;
			all_answered=1;
			return false;		
		}
	
	}); 
	if(all_answered==2)
	{		
		document.forms['questionsForm'].submit();	
		
	}else{
				 
		setTimeout(function(){ 			
			scrollToAnchor(tempname);
		},1000);
	}	
	return false;
}

</script> 