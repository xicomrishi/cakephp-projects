<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           
            <li class="active"><a>Send Message</a></li>
          	
          </ul>
        </section>
<section class="cms_page_detail">
<div class="online_training">
      <p><?php if($msg==1){ echo 'I have a contact at '.$company.' :'; 
	  			}else if($msg==2){ echo 'I know a similar company to '.$company.' :';
				}else if($msg==3){ echo 'I have a tip about '.$company.' :';
				}else if($msg==4){ echo 'I have some industry connections :';
				}else{ echo 'I have a job lead for you :';
				}	
	  	?></p>
       <div id="success_message" class="success" style="display:none;">Message sent successfully.</div>
       <form id="contact_usForm" name="contact_usForm" action="" method="post">
       <input type="hidden" name="req_id" value="<?php echo $req_id; ?>"/>
       <input type="hidden" name="card_id" value="<?php echo $card_id; ?>"/>
       <input type="hidden" name="msg" value="<?php echo $msg; ?>"/>
       <input type="hidden" name="text_msg" value="<?php if($msg==1){ echo 'Your SnagCast contact ( '.$from_user.' ) has a contact at '.$company.' :'; 
	  			}else if($msg==2){ echo 'Your SnagCast contact ( '.$from_user.' ) knows of a similar company to '.$company.' :';
				}else if($msg==3){ echo 'Your SnagCast contact ( '.$from_user.' ) has a tip about '.$company.' :';
				}else if($msg==4){ echo 'Your SnagCast contact ( '.$from_user.' ) has some industry connections :';
				}else{ echo 'Your SnagCast contact ( '.$from_user.' ) has a job lead for you :';
				}	
	  	?>"/>
       <input type="hidden" name="to_user_id" value="<?php echo $to_user['Account']['id'];?>"/>
       <div class="row">
       <label>Company Name : </label>
       <input type="text" name="company_name" class="input required" value="<?php if($msg!=2) echo $company;?>"/>
       </div>
       <?php if($msg==1||$msg==4||$msg==5){ ?>
       <div class="row">
       <label>Contact Name : </label>
       <input type="text" name="contact_name" class="input required" value=""/>
       </div>
       <?php } ?>
       <?php if($msg==1||$msg==4||$msg==5){ ?>
       <div class="row">
       <label>Contact Email : </label>
        <input type="text" name="contact_email" class="input email" value=""/>
        </div>
        <div class="row">
       <label>Contact Phone : </label>
        <input type="text" name="phone" class="input" value=""/>
        </div>
        <?php } ?>
         <?php if($msg==2){ ?>
           <div class="row">
           <label>Company Website : </label>
           <input type="text" name="company_website" class="input required url" value="http://"/>
           </div>
           <?php } ?>
        <?php if($msg==1||$msg==2||$msg==3){ ?>
        <div class="row">
        <label><?php if($msg==1||$msg==2){ echo "Comment";}else echo "Tip"; ?> : </label>
        <textarea name="message" class="input required" style="min-height:140px"></textarea>
        </div>
        <?php } ?>
        <div class="row">
        <label>&nbsp;</label>
        <input type="submit" value="Send" class="botton"/>
        <div id="loading" style="float:left;width:90px;text-align:center;display:none"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>
        <input type="reset" value="Reset" class="botton"/>
        </div>
      </form>
       </div>
       </section>
       </section>
 <script type="text/javascript">
 $(document).ready(function(e) {
    $('#contact_usForm').validate({
		submitHandler: function(form) {
			$('#loading').show();
			$.post('<?php echo SITE_URL;?>/info/network_contact_reply_submit',$('#contact_usForm').serialize(),function(data){
						$('#success_message').show();
						$('#loading').hide();
				});	
		}
		
	});
});
 </script>      