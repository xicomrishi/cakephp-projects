<?php //echo $this->Html->css('uploadify'); ?>
<?php //echo $this->Html->script('swfobject'); ?>
<?php //echo $this->Html->script('jquery.uploadify.min'); ?>
<?php echo $this->Html->script('jquery.ocupload'); ?>

<section class="submit_right" style="border:0px;">
<div id="msg2" class="success2" style="margin:0 0 0 -100px"></div>
    <form id="step7Form" name="step7Form" action="" enctype="multipart/form-data">
        <ul class="indexSkills1" style="height:auto; text-align:left">
            <li style=" text-align:left !important"><h4>Upload .xls Files : </h4> 
                <div class="rowdd" style="position:relative">
                    <div class="inputdd">Select a File from your computer :</div> 
                </div>
                <div class="rowdd" align="right">         
                    <div class="profileBtnSp"> <a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; behavior: url(PIE.htc); text-align:center; text-decoration:none; text-decoration:none; position:absolute; top:-28px; right:0px" >Upload</span> </a></div>  
                    <div id="motif_status"></div>
                    <span id="motif_loader" style="display:none;"><img src="<?php echo SITE_URL;?>/img/loading.gif" alt="Loading..."/></span>
                    <span id="motif_progress"></span>
                    <div id="uploaded_motif"></div>
                </div>       
                <div class="rowdd"><a class="save_btn" href="<?php echo SITE_URL;?>/files/sample.xls">Download Sample File</a></div>
            </li>	

        </ul>
</section>
</form>


<script language="javascript">
    $(document).ready(function(){
        //$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up',sliderMaxHeight: 70});
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
            $('#motif_loader').hide();
            $('#motif_progress').text('').hide();
            $('#uploaded_motifs').html('');
        }
    }


    //upload motifs ---------------------------------------------------------
    var myUpload1 = $('#upload_motif').upload({		
        name: 'data[TR_file]',
        action: '<?php echo SITE_URL; ?>/users/import/3',
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
           // alert(response);
            var response = response.split("|");
            var responseType = response[0];
            var responseMsg = response[1];
			
			
            //alert(responseMsg);
            if(responseType=="success")
            {	//alert(responseMsg);
                show_search();
				$('#msg2').removeClass('error');
				$('#msg2').addClass('success2');
                $("#msg2").html(responseMsg);	
              setTimeout(function(){ disablePopup();},3000);	
            }
            else if(responseType=="error")
            {	
				$('#msg2').removeClass('success2');
				$('#msg2').addClass('error');
                $("#msg2").html(responseMsg);					
            }else{
                $('#msg2').removeClass('success2');
				$('#msg2').addClass('error');
                $("#msg2").html(responseMsg);
            }
        }
    });//end of upload monograms
</script>