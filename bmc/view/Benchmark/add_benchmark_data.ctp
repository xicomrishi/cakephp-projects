<style>
.fancybox-inner #body_container .add_benchmark .filter_row p {
    width: 16% !important;
}
</style>  
  <section id="body_container">
  	
    <section class="container">
   
    <form id="AddBenchmarkForm" name="AddBenchmarkForm" method="post" onsubmit="return benchmark_form_submit();"  action="<?php echo $this->webroot; ?>benchmark/save_benchmark_data">
    <fieldset>
    <div class="tab_detail">
    	<h3 class="title"><?php echo __('Add Benchmark Data'); ?></h3>
            
             	
            <section class="add_benchmark">
            	<div class="filter_row">
                 <p><label><?php echo __('Year'); ?><span>*</span></label>
                	<select name="data[BenchmarkData][year]">
                    	<option value="">Unassigned Year</option>
                    	<?php foreach($allyears as $ayr){ ?>
                        	
                        	<option value="<?php echo $ayr; ?>"><?php echo $ayr; ?></option>
                        <?php } ?>
                    </select>
                </p>
            	<p><label><?php echo __('Company'); ?><span>*</span></label><input type="text" id="comp_lgt_inp" class="validate[required]" name="data[BenchmarkData][company]" value="<?php if(!empty($company)) echo $company['Company']['company'];?>" <?php if(!empty($company)) { ?> readonly="readonly"<?php } ?>/></p>
                <p><label><?php echo __('Country'); ?><span>*</span></label>
                	<select id="country_list_inp" name="data[BenchmarkData][country_id]">
                    	<option value="">Select Country</option>
                        <?php foreach($countries as $cont){ ?>
                        	<option value="<?php echo $cont['Country']['country_id']; ?>"><?php echo $cont['Country']['country_name']; ?></option>
						<?php } ?>
                    </select>
                	
                </p>
                <p><label><?php echo __('Role'); ?><span>*</span></label>
                	<select name="data[BenchmarkData][role_id]">
                    	<option value="3">Project Manager</option>
                        <option value="4">Team Member</option>
                        <option value="5">Manager of Project Managers</option>
                    </select>
                </p>
                <p class="last"><label><?php echo __('Industry'); ?><span>*</span></label><input type="text" id="industry_lgt_inp" class="validate[required]" name="data[BenchmarkData][industry]" /></p> 
               
                
                             
              </div>
              <div class="nano">
              <section class="dataEntrySection">
              
              
              <?php for($i=1;$i<7;$i++){ ?>
              	<div class="comn_row">
                <div class="title"><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); else if($i==5) echo __('Reporting'); else if($i==6) echo __('Risk Management'); ?></div>
                <table width="50%">               
                	<thead>
                    	<th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>                       
                    </thead>
                    <tbody>                    	
                    	<tr>
                        	<td><input type="text" name="data[val][<?php echo $i; ?>][num_a]"/></td>
                            <td><input type="text" name="data[val][<?php echo $i; ?>][num_b]"/></td>
                            <td><input type="text" name="data[val][<?php echo $i; ?>][num_c]"/></td>
                            <td><input type="text" name="data[val][<?php echo $i; ?>][num_d]"/></td>
                            <td><input type="text" name="data[val][<?php echo $i; ?>][num_e]"/></td>                            
                        </tr>
                    </tbody>
                </table>
                </div>
                <?php } ?>                
               <!-- <div class="comn_row last"><input type="submit" value="Save"/></div> -->
                </section>
                
                </div> 
                <div class="comn_row last"><input type="submit" value="Save"/></div>       
            </section> 	
            </div>
            </fieldset>
            </form>
         
    </section>
  </section>


<script type="text/javascript">
$(document).ready(function(e) {
	$("#AddBenchmarkForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});	
	setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'dataEntrySection',sliderMaxHeight: 70 }),2000});
			
});

var availableTags=[<?php 
			$last=count($all_comps); 
			$m=1;
			foreach($all_comps as $j ){ 
				if($m==$last){
					echo '"'.$j['label'].'"';
					}else{
						echo '"'.$j['label'].'",'; } $m++; }?>];
						
	$("#comp_lgt_inp").autocomplete({
			source: function( request, response ) {
				var matches = $.map( availableTags, function(tag) {
				  if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
					return tag;
				  }
				});
				response(matches);
			  },
			select: function( event, ui ) {
					$("#comp_lgt_inp").val( ui.item.label );
					return false;
			}
	}); 						


var availableindustryTags=[<?php 
			$last=count($all_industry); 
			$m=1;
			foreach($all_industry as $j ){ 
				if($m==$last){
					echo '"'.$j['label'].'"';
					}else{
						echo '"'.$j['label'].'",'; } $m++; }?>];
						
	$("#industry_lgt_inp").autocomplete({
			source: function( request, response ) {
				var matches = $.map( availableindustryTags, function(tag) {
				  if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
					return tag;
				  }
				});
				response(matches);
			  },
			select: function( event, ui ) {
					$("#industry_lgt_inp").val( ui.item.label );
					return false;
			}
	}); 						

function benchmark_form_submit()
{
	var valid = $("#AddBenchmarkForm").validationEngine('validate');
	if(valid)
	{
		document.forms['AddBenchmarkForm'].submit();			
	}else{
		$("#AddBenchmarkForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;
}
</script>