<?php echo $this->Html->script('jquery.ocupload'); ?>
<div class="head_row">
  
  <p>You have chosen to send your resume directly to the employer for this position. Below, enter the email address, a message and link your resume.</p>
  </div>
  
  
  <div class="pop_up_detail">
  <div class="setting_section" style="width:798px; position:relative">
  
  
  	<div class="box" style="width:50%; padding:0px">
 
 		 <form id="appply_directlyForm" name="appply_directlyForm" action="" enctype="multipart/form-data">	
             <input type="hidden" id="cardid" value="<?php echo $card_id;?>"/>
              <input type="hidden" id="check_value" name="resume" value=""/>
             <div class="row">
                <label style="width:72px; padding: 13px 18px 0 10px;">To: </label>
                <input type="text" name="to_email" class="required email"/>
             </div>
			<div class="row">
<label style="width:72px; padding: 13px 18px 0 10px;">Message to employer</label>

<textarea name="message"  class="required">To whom it may concern,

I am extremely interested in applying for the position of <?php echo $card['Card']['position_available'];?> within your organization. I believe that my background and qualifications match closely to what you're looking for in a candidate. Please find attached my resume and cover letter for your perusal.

Should you have any questions, please do not hesitate to call me to schedule an interview.

Regards,
<?php echo $name; ?></textarea>
</div>
        
<div class="row">
<a class="already_sub" href="javascript://" onclick="already_submit();">I've already submitted</a>
<input type="submit" value="submit" class="submitbtn" onclick="return send_resume();" style="margin:0px"/>
</div>
</form>
</div>


<div class="box" style="width:399px !important; padding:0px">
<div style="border:0px;  float:left">
   <ul class="indexSkills1" style="height:auto; text-align:left; width:399px !important;">
   <li style="text-align:left !important; width:100% !important; padding:3px 0 0 0 !important">
   			<h4>Upload New Files : </h4> 
                <div class="rowdd" style="position:relative">
                     <div class="inputdd">Select a File from your computer :</div> 
                   </div>
                  <div class="rowdd" align="right"  style="padding:0 30px 0 0">         
                     <div class="profileBtnSp"> 
                     	<a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer"><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; behavior: url(PIE.htc); text-align:center; text-decoration:none; text-decoration:none; position:absolute; top:-18px; right:50px">Upload</span></a>
                      </div>  
                        <div id="motif_status"></div>
                        <span id="motif_loader" style="display:none;"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                        <span id="motif_progress"></span>
                        <div id="uploaded_motif"></div>
                   </div>       
                 </li>
                 
                 
   <li style=" text-align:left !important; width:100%  !important">   
              	  <div class="foo"></div><div id="div_error" style="top:-19px !important; left:0px !important"></div>		
                      <div class="clearfix">
                     <span id="loader" style="display:none; padding:0 10px 0 0"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                     <div class="nano" style="width:360px !important">
<div class="strategy_pop_up" style="height:108px !important; width:360px !important">
                     <div id="file_listing"></div>
                     </div>
                     </div>
                     </div>
                 </li>
   </ul>
        


</div>
</div>

</div>            
         
</div>              
             
      

 
 
 

<script type="text/javascript">

$(document).ready(function(e) {
	
	$("html, body").animate({ scrollTop: 0 }, 600);

});

function fileList()
{	
	$('#loader').show();
	$("#file_listing").hide();
	var frm=$("#appply_directlyForm").serialize();		
		$.post("<?php echo SITE_URL; ?>/strategies/profile_file_list/1",frm ,function(data){			
		 	$("#file_listing").html(data);			 
			$('#file_listing').slideDown(); 
			$('#loader').hide();
			setTimeout(function(){ $('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up',sliderMaxHeight: 70});},2000);	
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
				var respons = unescape(response);
				//alert(response);
				var resp = respons.split("|");
				var responseType = resp[0];
				var responseMsg = resp[1];
				
				//alert(responseMsg);
				if(responseType=="success")
				{	
					
					fileList();
					$("#div_error").addClass('success');
					$("#div_error").removeClass('error');	
					$("#div_error").html(responseMsg);	
								
				}
				else if(responseType=="error")
				{
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');	
					$("#div_error").html(responseMsg);					
				}else{
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');
					$("#div_error").html(responseMsg);
				}
		   	}
		   });//end of upload monograms
		   
		   
fileList();

function send_resume()
{
	
	$('#appply_directlyForm').validate({
		submitHandler: function(form){
			var cardid=$('#cardid').val();
			var ch=new Array();
			var i=0;
			$('input:checked').each(function(){
				ch[i]=$(this).val();
				i++;
			});
			$('#check_value').val(ch);
			$.post('<?php echo SITE_URL;?>/strategies/send_resume_directly',$('#appply_directlyForm').serialize(),function(data){
					//if(data=='success')
					disablePopup();
					loadCardPopup('<?php echo SITE_URL;?>/strategies/apply_job',cardid,0);
					$("html, body").animate({ scrollTop: $('.row_'+cardid).offset().top - 80}, 100);	
					
				});
			return false;
		}
	});
	
}

function already_submit()
{
	var card_id=$('#cardid').val();
	disablePopup();
	setTimeout(function(){ loadCardPopup('<?php echo SITE_URL;?>/strategies/apply_job',card_id,0);},1500);
	//loadCardPopup('<?php echo SITE_URL;?>/strategies/apply_job',card_id,0);
	$("html, body").animate({ scrollTop: $('.row_'+card_id).offset().top - 80}, 100);
}

</script>