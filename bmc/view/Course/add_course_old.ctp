<style>
#login_container form a.anch_comp {margin: -28px 4px 12px 0;}
</style>
<section id="login_container" class="none">
	<div class="login_details">	
		<h3 class="title"><?php if(isset($course)) echo __('Edit Group'); else echo __('Add New Group'); ?></h3>	
		<form id="AddCourseForm" name="AddCourseForm" method="post" action="" onsubmit="return save_course(<?php if(isset($course)) echo 1; else echo '0'; ?>);">
			<fieldset>
            	<?php if(isset($course)){ ?>
                <input type="hidden" name="data[Course][id]" value="<?php echo $course['Course']['id']; ?>"/>
                <?php } ?>
            	<input type="hidden" name="data[Course][trainer_id]" value="<?php echo $trainer_id; ?>"/>
                <input type="hidden" id="company_count" value="<?php if(isset($company)){ echo count($company); }else echo '1'; ?>"/>
        		<span class="input_bg"><input class="course validate[required]" type="text" name="data[Course][course_name]" placeholder="<?php echo __('Group Name'); ?>" value="<?php if(isset($course)) echo $course['Course']['course_name']; ?>"/>
                <input class="date validate[required]" id="from_date" name="data[Course][start_date]"  type="text" placeholder="<?php echo __('Start Date'); ?>" value="<?php if(isset($course)) echo $course['Course']['start_date']; ?>"/>
                <input class="date validate[required]" id="to_date" name="data[Course][end_date]"  type="text" placeholder="<?php echo __('End Date'); ?>" value="<?php if(isset($course)) echo $course['Course']['end_date']; ?>"/>
                <?php if(isset($company)){ $i=1;
						foreach($company as $comp){
				?>
                <input class="company validate[required]" id="inp_comp_<?php echo $i; ?>"  type="text" placeholder="<?php echo __('Company Name'); ?>" value="<?php echo $comp['Coursecompany']['company']; ?>" readonly="readonly"/>
                
                <?php $i++; }}else{ ?>                
                 <input class="company comp_list_inp validate[required]" id="inp_comp_1"  type="text" name="data[company][1][name]" placeholder="<?php echo __('Company Name'); ?>"/></a>
                 <?php } ?>
                 </span>
                 <p><a href="javascript://" onClick="add_company();">+ <?php echo __('Add Another Company'); ?></a></p>
            	<span class="login_bg"><input type="submit" value="<?php echo __('Set Up Group'); ?>"></span>
    		</fieldset>
		</form>
     </div>
</section>

<script type="text/javascript">
var availableTags=[<?php 
			$last=count($all_comps); 
			$m=1;
			foreach($all_comps as $j ){ 
				if($m==$last){
					echo '"'.$j['label'].'"';
					}else{
						echo '"'.$j['label'].'",'; } $m++; }?>];
						//alert(availableTags);
						
autocomp(1);						

$(document).ready(function(e) {
    $("#AddTrainerForm").validationEngine({scroll:false,focusFirstField : false});
		var to_day=new Date();
    $( "#from_date" ).datepicker({
		defaultDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
		 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
		changeMonth: true,
		changeYear: true,
		dateFormat:"yy-mm-dd",
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
		$( "#to_date" ).datepicker({
		defaultDate: "+1d",
		minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
		changeMonth: true,	
		changeYear: true,
		dateFormat:"yy-mm-dd",	
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});	
	
	
});

function autocomp(num)
 {			
	$(".comp_list_inp").autocomplete({
			source: function( request, response ) {
				var matches = $.map( availableTags, function(tag) {
				  if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
					return tag;
				  }
				});
				response(matches);
			  },
			focus: function( event, ui ) {
				//$("#inp_comp_"+num).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
						//alert(num);
					$("#inp_comp_"+num).val( ui.item.label );
					return false;
			}
	}); 
} 

function add_company()
{
	var count=$('#company_count').val();
	count=parseInt(count)+1;
	$('.input_bg').append('<input type="text" id="inp_comp_'+count+'" name="data[company]['+count+'][name]" class="company comp_list_inp validate[required]" placeholder="<?php echo __('Company Name'); ?>"/><a href="javascript://" id="anch_'+count+'" class="anch_comp" title="<?php echo __('Delete'); ?>" onclick="remove_comp(\''+count+'\');"><img src="<?php echo $this->webroot; ?>img/cross.png" alt=""/></a>');
	$('#company_count').val(count);	
	autocomp(count);
}

function remove_comp(num)
{
	$('#inp_comp_'+num).remove();
	$('#anch_'+num).remove();	
}
</script>