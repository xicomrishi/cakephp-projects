<style>
.dataTabs{ text-align:center !important;} 
.dataTabs span{background: none repeat scroll 0 0 #E3E7F4;border: medium none;border-radius: 6px 6px 6px 6px;cursor: pointer;float: right;font-family: 'MuseoSlabRegular';font-size: 15px;line-height: 18px;padding: 6px 0;text-align: center;width: 95px;}
.dataTabs span:hover{background: none repeat scroll 0 0 #808080;}
.dataTabs span:hover a{color:#fff !important;}
.dataTabs span.current{ background: none repeat scroll 0 0 #808080; }
.dataTabs span.current a{color:#fff !important;}
.add_benchmark .filter_row p { width:21% !important;}
</style>
<?php if(!isset($sysData)){ ?>
<div class="invite"><span>Add New Country Data for <?php echo $data['Company']['company']; ?></span><a href="javascript://" onclick="add_bc_data('<?php echo $data['Company']['id']; ?>');"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
<?php } ?>

<div class="compTitle"><?php if(!isset($sysData)) echo 'Benchmark'; else if($sysData=='1') echo 'System Generated'; else if($sysData=='2') echo 'Aggregate'; ?> Data for <?php echo $data['Company']['company']; ?></div>

<section class="add_benchmark">
				
            	<div class="filter_row">
                 <p><label><?php echo __('Year'); ?><span>*</span></label>
                	<select id="year_list_inp" name="data[BenchmarkData][year]" onchange="show_filter_data('<?php echo $data['Company']['id']; ?>',0,<?php if(isset($sysData)){ echo $sysData; }else{ echo 0; }?>);">
                    	
                    	<option value="<?php echo ''; ?>">Select Year</option>
                        
                        	<option value="000">All Years</option>    
                            <?php if(isset($sysData)){ if($sysData!=1){ ?>                   
                        	<option value="999">Unassigned Year</option>                       	
                       		<?php }} ?>
                        <?php foreach($allyears as $ayr){ ?>
                        	<option value="<?php echo $ayr; ?>"><?php echo $ayr; ?></option>
						<?php } ?>
                    </select>                	
                </p>  
                <p><label><?php echo __('Country'); ?><span>*</span></label>
                	<select id="country_list_inp" name="data[BenchmarkData][country_id]" onchange="show_filter_data('<?php echo $data['Company']['id']; ?>',0,<?php if(isset($sysData)){ echo $sysData; }else{ echo 0; }?>);">
                    	<option value="">Select Country</option>
                        <option value="000">All Countries</option>
                        <?php if(isset($sysData)){ ?>                        		
                        	<option value="0">General Data</option>
                         <?php } ?>     
                        <?php foreach($countries as $cont){ ?>
                        	<option value="<?php echo $cont['C']['country_id']; ?>"><?php echo $cont['C']['country_name']; ?></option>
						<?php } ?>
                    </select>
                	
                </p>
            	<p><label><?php echo __('Role'); ?><span>*</span></label>
                	<select id="role_list_inp" name="data[BenchmarkData][role_id]" onchange="show_filter_data('<?php echo $data['Company']['id']; ?>',0,<?php if(isset($sysData)){ echo $sysData; }else{ echo 0; }?>);">
                    	<option value="">Select Role</option>
                        <option value="000">All Roles</option>
                        <option value="3">Project Manager</option>
                        <option value="4">Team Member</option>
                        <option value="5">Manager of Project Managers</option>
                    </select>
                </p>
                <p class="last"><label><?php echo __('Industry'); ?><span>*</span></label>
                	<select id="industry_list_inp" name="data[BenchmarkData][industry_id]" onchange="show_filter_data('<?php echo $data['Company']['id']; ?>',0,<?php if(isset($sysData)){ echo $sysData; }else{ echo 0; }?>);">
                    	<option value="">Select Industry</option>
                        <option value="000">All Industries</option>
						
                        <?php foreach($industries as $ind){ ?>
                        	<option value="<?php echo $ind['I']['id']; ?>"><?php echo $ind['I']['industry']; ?></option>
						<?php } ?>
                    </select>                	
                </p>
                                                          
              </div>              
           <div class="specificData">              
              <div style="text-align:center; height:100px; margin-top:50px;">Please select role and industry.</div>  
                </div>              
                <!--<div class="comn_row last"><input type="submit" value="Save"/></div>-->        
            </section>
           

