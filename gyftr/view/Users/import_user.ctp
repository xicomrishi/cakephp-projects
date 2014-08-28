<?php echo $this->Html->script('jquery.ocupload'); ?>
<div id="msg2" class="success2" style="margin:0 0 0 -100px"></div>
<div class="rowdd" style="position:relative">
<div class="inputdd"><label style="white-space:nowrap">Select a File from your computer :</label>   <br /> <span clas='txt'>Only .xls file is supported</span></div> 

                <div class="rowdd" align="center">         

                    <div class="profileBtnSp" style="margin-left:100px"> <a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; margin:0px !important; behavior: url(PIE.htc); text-align:center; cursor:hand;cursor:pointer; text-decoration:none; position:absolute; top:-28px; left:-114px" >Upload</span> </a></div>  
                    <div id="motif_status"></div>
                    <span id="motif_loader" style="display:none;"><img src="<?php echo SITE_URL;?>/img/ajax-loader.gif" alt="Loading..."/></span>
                    <span id="motif_progress"></span>
                    <div id="uploaded_motif"></div>
                </div> 
                <div class="rowdd"><a class="save_btn" href="<?php echo SITE_URL;?>/files/sample.xls">Download Sample File</a></div>

</div>
<script type="text/javascript">
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
        action: '<?php echo SITE_URL; ?>/users/import',
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
            {
               // show_search();
			 //  $.fancybox.close();
				//$('#msg2').removeClass('error');
				//$('#msg2').addClass('success2');
                $("#msg2").html(responseMsg);	
              setTimeout(function(){window.location.href="<?php echo SITE_URL; ?>/admin/users"},500);
			  
            }
            else if(responseType=="error")
            {
             //  $('#msg2').removeClass('success2');
			//	$('#msg2').addClass('error');
                $("#msg2").html(responseMsg);		
            }else{
             //  $('#msg2').removeClass('success2');
			//	$('#msg2').addClass('error');
                $("#msg2").html(responseMsg);
            }
        }
    });//end of upload monograms
</script>