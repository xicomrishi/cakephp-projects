<style>
.detail_row .Contri_deatil .col.sec_last{ width:30% !important; }
.detail_row .Contri_deatil .col.medium{ width:18.8%; text-align:center;} 
</style>
<?php  echo $this->Html->script('jquery.ocupload'); ?>
           
            
            <form action="#" class="profile">
			<input type="hidden" id="user_id" value="<?php echo $user['User']['id'];?>"/>
            <div class="comn_box gift">
            <!--<div class="main_heading"><span><strong>Recipient: </strong><?php echo $dat['order']['Order']['to_name']; ?></span></div>-->
            <div class="detail_row">
            <label>First Name:</label>
            <span class="detail"><?php echo $user['User']['first_name']; ?></span>
            </div>        
            <div class="detail_row">
            <label>Last Name:</label>
            <span class="detail"><?php echo $user['User']['last_name']; ?></span>
            </div>
            <div class="detail_row">
            <label>Email: </label>
          	 <span class="detail"><?php echo $user['User']['email']; ?></span>
            </div>
              <div class="detail_row">
            <label>Mobile No.: </label>
          	 <span class="detail"><?php if(!empty($user['User']['phone'])) echo $user['User']['phone']; else echo 'N/A'; ?></span>
            </div>
            
             <div class="detail_row">
            <label>Date of Birth: </label>
          	 <span class="detail"><?php if(!empty($user['User']['dob'])) echo $user['User']['dob']; else echo 'N/A'; ?></span>
            </div>
            
             <div class="detail_row">
            <label>Gender: </label>
          	 <span class="detail"><?php if($user['User']['gender']==1) echo 'Female'; else if($user['User']['gender']==0) echo 'Male'; else echo 'N/A'; ?></span>
            </div>
           
             <div class="detail_row last">
            <label>Points: </label>
          	 <span class="detail"><?php echo $user['User']['points']; ?></span>
            </div>
              <div class="detail_row last">
             <label>Update Profile: </label>
            <span class="detail"><a href="javascript://" onclick="get_edit_profile();" class="edit">Edit</a></span>
            </div>
        </div>
           
            </form>
             <div class="other_login none" id="profile_image">
      			<?php 
					if(!empty($user['User']['thumb']))
					{	
						echo '<img src="'.$this->webroot.'files/ProfileImage/'.$user['User']['id'].'/'.$user['User']['thumb'].'" alt="'.$user['User']['first_name'].'" title="'.$user['User']['first_name'].' '.$user['User']['last_name'].'">';
						 
					}else if(!empty($user['User']['fb_id'])){
						echo $this->Html->image('http://graph.facebook.com/'.$user['User']['fb_id'].'/picture?type=large',array('alt'=>'Profile picture','escape'=>false));
					}else{
						echo $this->Html->image('avatar.jpg',array('alt'=>'Profile picture','escape'=>false));	
						
					}
					?>
             </div>
			<div class="rowdd" align="center" style="position:relative; float:left">         

                    <div class="profileBtnSp" style="margin-left:100px;"> <a href="javascript://" class="rtMargin uploadbtn cancel"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:3px;border-radius:3px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px ;z-index:99; margin:0px !important; behavior: url(PIE.htc); text-align:center; text-decoration:none; top:9px; left:-85px" >change Image</span> </a></div>  
                    <div id="motif_status"></div>
                    <span id="motif_loader" style="display:none;"><img src="<?php echo SITE_URL;?>/img/ajax-loader.gif" alt="Loading..."/></span>
                    <span id="motif_progress"></span><br/>
                    <div>
                    <span style="font-size:10px; margin-left:10px;">Max. allowed file size is 1 Mb.</span><br/>
                    <span style="font-size:10px; margin-left:10px;"> Only jpg,png,jpeg,gif files allowed.</span>
                    </div>
                </div>
                
                
              <div id="form_section">  
            <form>      
            <div class="comn_box Contributing">
            <div class="main_heading"><span>My Promo <strong>Codes</strong></span></div>
            <div class="detail_row full last">
            <div class="Contri_deatil">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr class="head_row">
            <td class="col medium"><strong>S.No.</strong></td>
            <td class="col medium"><strong>Promo Code</strong></td>
            <td class="col medium sec_last"><strong>Details</strong></td>
            <td class="col medium last"><strong>Valid Upto</strong></td>
                     
            </tr>
            <?php $i=1; foreach($user['UserPromo'] as $pr){ ?>
            <tr class="comn_row">
            <td class="col medium"><?php echo $i; ?></td>
            <td class="col medium"><?php echo $pr['promo_code']; ?></td>
            <td class="col medium sec_last"><?php 
					if($pr['Promocode']['discount_type']=='PureValue')
							$discount='Rs. '.$pr['Promocode']['value'];
					else		
						$discount=$pr['Promocode']['value'].'%';
						
					echo 'Discount of '.$discount;
					if(!empty($pr['Order']))
					{
						if($user['User']['gender']=='0') $gend='his '; else $gend='her '; 
						echo ' on gift to '.$pr['Order']['to_name'].' on occasion of '.$gend.$pr['Order']['occasion'];	
					}else{
						echo ' any gift';	
					}	
			
			?></td>
            <td class="col medium last"><?php echo show_formatted_datetime($pr['valid_upto']); ?></td>
            </tr>
            <?php $i++; } ?>                
       
            </table>
            </div>
            </div>
           
            </div> 
            </form>
            </div>  
                
<script type="text/javascript">


//upload motifs ---------------------------------------------------------
    var myUpload1 = $('#upload_motif').upload({		
        name: 'data[TR_file]',
        action: site_url+'/users/upload_profile_pic',
        enctype: 'multipart/form-data',
        params: {upload:'Upload',user_id:$('#user_id').val()},
        autoSubmit: true,
		/*onSelect: function(){				
				var re = new RegExp("(jpg|jpeg|gif|png)$", "i"); 
				alert(myUpload1.filename());
				if (!re.test(myUpload1.filename())) {
			
					alert("Only JPG, JPEG, GIF, or PNG image file can be uploaded"); 
					
				} else {					
					myUpload1.submit(); 			
				} 			
			},*/
        onSubmit: function() {
			//this.params({logo: $('#logo').val()});
            $('#motif_status').html('').hide();
            motifMessage('please wait File is uploading', 'show');
        },
        onComplete: function(response) {
			   
            motifMessage('', 'hide');
          // $('#profile_image').html(response);
		    response = unescape(response);
            var response = response.split("|");
            var responseType = response[0];
            var responseMsg = response[1];
				
            //alert(responseType);
            if(responseType=="success")
            {
				$('#profile_image').html('<img src="'+site_url+'/files/ProfileImage/'+$('#user_id').val()+'/thumb_'+responseMsg+'">');
				update_user_pic();
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
           
                       
             