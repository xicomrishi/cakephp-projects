<?php //echo $this->Html->css('uploadify');?>
<?php //echo $this->Html->script('swfobject');?>
<?php //echo $this->Html->script('jquery.uploadify.min');?>
<?php echo $this->Html->script('jquery.ocupload');?>
<?php echo $this->element('profile_progress');?>
<section class="head_row">
  <h3>Finally, you need to upload your resume. You can upload multiple resumes if necessary.</h3>

  </section>
  <form id="step7Form" name="step7Form" action="" enctype="multipart/form-data">
  
  <section class="pop_up_detail">
 

 			<div id="select_err" align="center" style="display:none;">Please either select or enter at least one criteria</div>
             
              <?php //echo $this->Form->create('Client',array('id'=>'profileStep2'));?>
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
            <!--  <input type="file"/><br/>
              <input type="submit" value="SUBMIT"/>-->
              <fieldset>
         

              <ul class="indexSkills1" style="height:auto;">
              	<li class="first">   
              	  <div class="foo"></div><div id="div_error"></div>		
                      <div class="clearfix">
                     <span id="loader" style="display:none;"><img src="images/loading.gif" alt="Loading..."/></span>
                     <div id="file_listing"></div>
                 </li>
                
               <li class="last" <?php if($file==0){ echo 'style="width:530px"';} ?>><h4>Upload New Files : </h4> 
                <div class="rowdd">
                     <div class="inputdd <?php if($file==0) //echo $errClass; ?>">Select a File from your computer :</div> 
                   </div>
                  <div class="rowdd" align="center">         
                     <div class="profileBtnSp" style="margin-left:80px;"> <a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer" ><span>Upload</span> </a></div>  
                        <div id="motif_status"></div>
                        <span id="motif_loader" style="display:none;"><img src="images/loading.gif" alt="Loading..."/></span>
                        <span id="motif_progress"></span>
                        <div id="uploaded_motif"></div>
                   </div>       
                 </li>	
              
              </ul>
              <section class="job_descrip_box">
              <p class="pText" align="center">TIP: When looking at jobs other then your Job A, it is important that you take a position that makes you more competitive in the future. When an employer reviews a resume they're looking for a pattern of experiences that matches the available position. You can use the criteria you establish to  determine if a Job B opportunity adds value to your work history.</p>
              
              <span class="btn_row" style="padding:0 0 45px 0">
              <!--<input type="button" class="save_btn" value="Complete" onclick="complete_step7();"/>-->
              <a href="javascript://" onclick="complete_step7();" class="save_btn">SAVE &amp; NEXT</a>
              <!--<a href="#" class="skip_btn">SKIP ></a>-->
              </span>
              </section>
             
     </section>
   </form>
 <ul class="pop_up_paging">
	<?php echo $this->element('profile_steps');?>
  </ul>

<script language="javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 40 }, 600);
});
function complete_step7()
{	
	//alert(1);
	url="<?php echo SITE_URL; ?>/clients/dashboard";
	
	window.location.href=url;
	//return;
	//alert(2);
	}
function step(num)
{
	clientid=$('#clientid').val();
	$.post("<?php echo SITE_URL; ?>/clients/profile_step"+num,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	
	
}

function fileList()
{	
	$('#loader').show();
	$("#file_listing").hide();
	var frm=$("#step7Form").serialize();		
		$.post("<?php echo SITE_URL; ?>/clients/profile_file_list",frm ,function(data){			
		 	$("#file_listing").html(data);			 
			$('#file_listing').slideDown(2500); 
			$('#loader').hide();	
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
		   action: 'show_file_upload',
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
				}
				else if(responseType=="error")
				{
					$("#div_error").html(responseMsg);					
				}else{
					$("#div_error").html(responseMsg);
				}
		   	}
		   });//end of upload monograms
		   
		   
fileList();

</script>