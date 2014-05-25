<?php echo $this->Html->script('jquery.ocupload');?>

<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<?php if($field=='resume'){ ?>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
 </div>
  </div>
<?php }else{ ?>
 <p class="full"><?php echo $check['Checklist']['description'];?></p>
<?php } ?>  
  </div>
  
  
  <div class="submit_right">
  
 <form id="step7Form" name="step7Form" action="" enctype="multipart/form-data">
<div id="no_file" class="error" style="display:none;">Please select file to attach.</div>
 			             
              <?php //echo $this->Form->create('Client',array('id'=>'profileStep2'));?>
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
               <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  				 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
                  <input type="hidden" id="check_value" name="<?php echo $field;?>" value="0"/>
            <!--  <input type="file"/><br/>
              <input type="submit" value="SUBMIT"/>-->

        

              <ul class="indexSkills1" style="height:auto; text-align:left">
              	<li class="first" style=" text-align:left !important">   
              	  <div class="foo"></div><div id="div_error"></div>		
                      <div class="clearfix">
                     <span id="loader" style="display:none;"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                     <div class="nano" style="width:220px !important">
<div class="strategy_pop_up" style="height:154px !important">
                     <div id="file_listing"></div>
                     </div>
                     </div>
                 </li>
                
               <li class="last" style=" text-align:left !important"><h4>Upload New Files : </h4> 
                <div class="rowdd" style="position:relative">
                     <div class="inputdd">Select a File from your computer :</div> 
                   </div>
                  <div class="rowdd" align="right">         
                     <div class="profileBtnSp"> <a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; behavior: url(PIE.htc); text-align:center; text-decoration:none; text-decoration:none; position:absolute; top:-28px; right:0px" >Upload</span> </a></div>  
                        <div id="motif_status"></div>
                        <span id="motif_loader" style="display:none;"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                        <span id="motif_progress"></span>
                        <div id="uploaded_motif"></div>
                   </div>       
                 </li>	
              
              </ul>
             
              
                          
              <div class="submit_row">
              <!--<input type="button" class="save_btn" value="Complete" onclick="complete_step7();"/>-->
              <a class="save_btn" href="javascript://" onclick="submit_file();">SAVE</a>
              <!--<a href="#" class="skip_btn">SKIP ></a>-->
              </div>
              
       </form>      
     </div>
   


<script language="javascript">

function submit_file()
{
	$('input:checked').each(function(){
		if($(this).attr('checked'))
		{
			var ch=$(this).val();
			$('#check_value').val(ch);
		}
	});
	if($('#check_value').val()==0)
	{
		$('#no_file').show();	
		setTimeout(function(){$('#no_file').hide();},4000);
	}else{	
	var check_id=$('#check_id').val();
	$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',$('#step7Form').serialize(),function(data) {
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	}
}	

function fileList()
{	
	$('#loader').show();
	$("#file_listing").hide();
	var frm=$("#step7Form").serialize();		
		$.post("<?php echo SITE_URL; ?>/strategies/profile_file_list",frm ,function(data){			
		 	$("#file_listing").html(data);			 
			$('#file_listing').slideDown(); 
			$('#loader').hide();	
			setTimeout(function(){ $('.nano').nanoScroller({alwaysVisible: false, contentClass: 'strategy_pop_up',sliderMaxHeight: 70});},1000);
	});	
	
	
}
function motifMessage(msg, show_hide){

	if(show_hide=="show"){
		$('#motif_loader').show();
		$('#motif_progress').show().text(msg);
		$('#uploaded_motifs').html('');
	}else if(show_hide=="hide"){
		$('#motif_loader').hide();
		$('#motif_progress').text('').hide();
	}else{
		$('#motif_loader').hide();
		$('#motif_progress').text('').hide();
		$('#uploaded_motifs').html('');
	}
}


		//upload motifs ---------------------------------------------------------
		var myUpload1 = $('#upload_motif').upload({		
		   name: 'data[TR_file]',
		   action: '<?php echo SITE_URL;?>/clients/show_file_upload',
		   enctype: 'multipart/form-data',
		   params: {upload:'Upload'},
		   autoSubmit: true,
		   onSubmit: function() {		   
		   		$('#motif_status').html('').hide();
				motifMessage('please wait File is uploading', 'show');
		   },
		   onComplete: function(response) {
			   
		   		motifMessage('', 'hide');
				response = unescape(response);
				//alert(response);
				var response = response.split("|");
				var responseType = response[0];
				var responseMsg = response[1];
				
				//alert(responseMsg);
				if(responseType=="success")
				{	
					
					fileList();
					$("#div_error").html(responseMsg);	
					$("#div_error").removeClass('error');
					$("#div_error").addClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);				
				}
				else if(responseType=="error")
				{
					$("#div_error").html(responseMsg);	
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);					
				}else{
					$("#div_error").html(responseMsg);
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);	
				}
		   	}
		   });//end of upload monograms
		   
		   
fileList();
//$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up',sliderMaxHeight: 70});

</script>