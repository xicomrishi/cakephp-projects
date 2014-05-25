<section class="coach_section">
    <form id="frm" name="frm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <div id="error"></div> 
        <fieldset>
        <div class="row"><label>Name:</label>
            <input type="text" id="name" name="name" class="input required" value="<?php if(isset($agency['name'])) echo $agency['name'];?>" />
         </div>
         <div class="row"><label>Email:</label>
            <input type="text" id="email" name="email" class="input required email" <?php if(isset($agency['email'])) echo "readonly";?> value="<?php if(isset($agency['email'])) echo $agency['email'];?>"  />
         </div>
         <div class="row"><label style="float:none;">URL:</label> <span style="color:#757575">http://snagpad.com/</span>
          <input type="text" id="title" name="title" class="input required" value="<?php if(isset($agency['title'])) echo $agency['title'];?>" <?php if(isset($agency['title']) && $agency['title']!='') echo "readonly";?> style="float:none; width:300px"  />
	     </div>
       
         <div class="row"><label>Address:</label>
<textarea name="address" class="input required" style="margin:0px"><?php if(isset($agency['address'])) echo $agency['address'];?></textarea></div>
        
         <div class="row"><label>Description:</label>
         <textarea name='description' class='ckeditor'><?php if(isset($agency['description'])) echo $agency['description'];?></textarea>
         </div>
         
		<div class="row"><label>More Info:</label>
         <textarea name='specification' class='ckeditor'><?php if(isset($agency['specification'])) echo $agency['specification'];?></textarea>
         </div>  <div class="rowdd" style="position:relative">
                    <div class="inputdd"><label style="white-space:nowrap">Select a File from your computer :   <br /> <span class="txt">Only .png,.jpg,.gif file is supported</span></label>
                    
                    </div> 
</div>
<div class="rowdd" align="center" style="position:relative; float:left">         

                    <div class="profileBtnSp" style="margin-left:100px;"> <a href="javascript://" class="rtMargin uploadbtn cancel"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px ;z-index:99; margin:0px !important; behavior: url(PIE.htc); text-align:center; text-decoration:none; top:9px; left:-85px" >Upload</span> </a></div>  
                    <div id="motif_status"></div>
                    <span id="motif_loader" style="display:none;"><img src="<?php echo SITE_URL;?>/img/loading.gif" alt="Loading..."/></span>
                    <span id="motif_progress"></span>
                    <div id="uploaded_motif" style="float:left"><?php if(isset($agency['thumb']) && $agency['thumb']!='') echo "<img style='float:left;' src='".SITE_URL."/logo/".$agency['thumb']."'/>";?></div>
                </div>
			<input type="hidden" name="logo" id="logo" value="<?php if(isset($agency['logo'])) echo $agency['logo'];?>" />
            <input type="hidden" name="thumb" id="thumb" value="<?php if(isset($agency['thumb'])) echo $agency['thumb'];?>" />
            <input type="hidden" name="id" id="id" value="<?php if(isset($agency['id'])) echo $agency['id'];?>" />
           <div class="row">
            <span class="coach_submit" style="padding:40px 0 0 0; width:100% !important; float:none; display:inline-block; text-align:center">
                <input type="button" id="submitButton" value="SAVE" class="submitbtn" style="margin:0px; float:none  !important" />

            </span>
            </div>
                                    </fieldset>
    </form>

    </section>
<script type="text/javascript">
$(document).ready(function(e){
$('#submitButton').click(function(){
if ($('#frm').valid())
{
			for ( instance in CKEDITOR.instances )
			    CKEDITOR.instances[instance].updateElement();
                $.post("<?php echo SITE_URL; ?>/super/save_agency",$('#frm').serialize(),function(data){	
				if(data=='')
					show_search_agency();
				
				else
				{
                        $("#error").html(data);               
                   		$('#error').show();   
						window.scroll(0,0);
				}
                });
}
});
    });
    //upload motifs ---------------------------------------------------------
    var myUpload1 = $('#upload_motif').upload({		
        name: 'data[TR_file]',
        action: '<?php echo SITE_URL; ?>/admin/super/uploadlogo',
        enctype: 'multipart/form-data',
        params: {upload:'Upload',logo_id:$('#id').val()},
        autoSubmit: true,
        onSubmit: function() {
			this.params({logo: $('#logo').val()});
            $('#motif_status').html('').hide();
            motifMessage('please wait File is uploading', 'show');
        },
        onComplete: function(response) {
			   
            motifMessage('', 'hide');
            response = unescape(response);
            var response = response.split("|");
            var responseType = response[0];
            var responseMsg = response[1];
				
            //alert(responseMsg);
            if(responseType=="success")
            {
				$('#logo').val(responseMsg);
				$('#thumb').val('thumb_'+responseMsg);
				$('#uploaded_motif').html('<img src="<?php echo SITE_URL;?>/logo/thumb_'+responseMsg+'">');
            }
            else if(responseType=="error")
            {
                motifMessage(responseMsg,'display');					
            }else{
                motifMessage(responseMsg,'display');
            }
        }
    });//end of upload monograms

    function motifMessage(msg, show_hide){

       if(show_hide=="show"){
            $('#motif_loader').show();
            $('#motif_progress').show().text(msg);
            $('#uploaded_motifs').html('');
        }else if(show_hide=="hide"){
            $('#motif_loader').hide();
            $('#motif_progress').text('').hide();
        }else{
            $('#motif_loader').hide();   $('#motif_progress').show().text(msg);
        }
    }


</script>
<?php echo $this->Js->writeBuffer(); ?>