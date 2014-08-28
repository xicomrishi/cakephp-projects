<div id="returnMsg" align="center" style=" display:none;top:5px;"></div>
<div id="flashmsg" align="center" style="margin-top:10px;"><?php echo $this->Session->flash(); ?></div>
<section class="box" style="padding:0px; width:955px">
    <form id="settingsForm" name="settingsForm" action="" method="post">
        <input type="hidden" id="coachid" name="data[Agency][id]" value="<?php echo $agencyid; ?>"/>
        <fieldset>
            <section class="row">
                <label>Name</label>
                <input type="text" name="data[Agency][name]" id="ag_name" class="required" value="<?php echo $coach['Agency']['name']; ?>">
            </section>
            <section class="row">
                <label>URL</label>
                <input type="text" class="none" name="data[Agency][title]" value="<?php echo SITE_URL . '/' . $coach['Agency']['title'] ?>" readonly="readonly" disabled="disabled" style="width:370px">
            </section>
            <section class="row" >
                <label>Email</label>
                <input class="none" type="text" value="<?php echo $coach['Agency']['email']; ?>" readonly="readonly" disabled="disabled"/>
            </section>
            <section class="row">
                <label>Address</label>
                <textarea name="data[Agency][address]" id="ag_address" class="required"><?php echo $coach['Agency']['address']; ?></textarea>
            </section>
			
            <section class="row">
                <label>Description</label>
                
            </section>
           <textarea name="data[Agency][description]" id="ag_descrip" class="ckeditor"><?php echo $coach['Agency']['description']; ?></textarea>
            <section class="row">
                <label>More Info</label>
               
            </section>
             <textarea name="data[Agency][specification]" id="ag_info" class="ckeditor"><?php echo $coach['Agency']['specification']; ?></textarea>
           
            <section class="row"><label>Logo</label>
                <div style="float:left">
                    <div class="profileBtnSp" style="margin:8px 0 0 27px"> <a href="javascript://" class=""  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; margin:8px 0 0 0 !important; behavior: url(PIE.htc); text-align:center; text-decoration:none; top:9px; left:-85px" >Upload</span> </a></div>
                  <div id="remove_logo" style="margin:-29px 0 0 122px; float:left;" <?php if(!isset($coach['Agency']['logo'])){ ?> style="display:none;"<?php } ?>><a href="javascript://" onclick="remove_logo();" class="submitbtn">Remove</a></div>
                    <div id="motif_status"></div>
                    <span id="motif_loader" style="display:none;"><img src="<?php echo SITE_URL; ?>/img/loading.gif" alt="Loading..."/></span>
                    <span id="motif_progress"></span>
                    <div id="uploaded_motif" style="margin:10px 0 0 0; display:inline-block"><?php if (isset($coach['Agency']['thumb']) && $coach['Agency']['thumb'] != '')
    echo "<img src='" . SITE_URL . "/logo/" . $coach['Agency']['thumb'] . "'>"; ?></div></div>
            </section>
            <section class="row last" style="text-align:center">
                <input type="hidden" name="data[Agency][logo]" id="logo" value="<?php if (isset($coach['Agency']['logo']))
    echo $coach['Agency']['logo']; ?>" />
                <input type="hidden" name="data[Agency][thumb]" id="thumb" value="<?php if (isset($coach['Agency']['thumb']))
    echo $coach['Agency']['thumb']; ?>" />
				<!--<a href="javascript://" onclick="updateDetails();" class="submitbtn" style="margin:20px 25px 0 0; display:inline-block !important;  float:none !important">Update</a>-->
                <input type="button" value="Update" onclick="updateDetails();" class="submitbtn" style="margin:20px 25px 0 0; display:inline-block !important;  float:none !important"/>
            </section>
        </fieldset>
    </form>
</section>
<script type="text/javascript">        
    function updateDetails()
    {	
       var name=$('#ag_name').val();
	   var address=$('#ag_address').val();
	   if(name==''){ error_message('Please enter Agency Name'); 
	   }else if(address==''){ error_message('Please enter Agency Address'); 
	   }else{
          // alert($('#specs').val());
		  for ( instance in CKEDITOR.instances )
			    CKEDITOR.instances[instance].updateElement();
		    $.post("<?php echo SITE_URL; ?>/Agency/settings_details",$('#settingsForm').serialize(),function(data){
                var respons=data.split("|");
                $('#user_name').html(respons[1]);
                $('#returnMsg').html(respons[0]);
                $('#returnMsg').removeClass('error');
                $('#returnMsg').fadeIn('slow');
				 $("html, body").animate({ scrollTop: 0 }, 600);
                setTimeout(function(){$('#returnMsg').fadeOut('slow')},3000);

            });
	   }
        	
    }
	
	function error_message(message){
		
		$('#returnMsg').addClass('error');
		$('#returnMsg').html(message);
		$('#returnMsg').show();
		 $("html, body").animate({ scrollTop: 0 }, 600);
		
	}

    $(document).ready(function(e) {
		

    });
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


    //upload motifs ---------------------------------------------------------
    var myUpload1 = $('#upload_motif').upload({		
        name: 'data[TR_file]',
        action: '<?php echo SITE_URL; ?>/agency/uploadlogo',
        enctype: 'multipart/form-data',
        params: {upload:'Upload',logo_id:$('#logo_id').val()},
        autoSubmit: true,
        onSubmit: function() {
            this.params({logo: $('#logo').val()});
            $('#motif_status').html('').hide();
			$('#uploaded_motif').html('');
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
                $('#uploaded_motif').html('<img src="<?php echo SITE_URL; ?>/logo/'+responseMsg+'">');
                $('#logo').val(responseMsg);
                $('#thumb').val(responseMsg);
				$('#remove_logo').show();
            }
            else if(responseType=="error")
            {
                motifMessage(responseMsg,'display');					
            }else{
               motifMessage(responseMsg,'display');
            }
        }
    });//end of upload monograms
	
function remove_logo()
{
	var y=confirm("Are you sure you want to delete Agency Logo?");
	if(y){
		$('#logo').val('');
		$('#thumb').val('');
		$('#remove_logo').hide();
		$('#uploaded_motif').html('Logo Deleted!');
		
	}
}
</script>
<?php echo $this->Js->writeBuffer(); ?>	        