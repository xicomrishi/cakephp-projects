<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           
            <li class="active"><a><?php echo $content['title'];?></a></li>
          	
          </ul>
        </section>
<section class="cms_page_detail">
<?php if(isset($accept_terms)){ ?>
<div class="success">Please accept terms & conditions at the bottom and click continue.</div>
<?php } ?>
<div class="<?php echo $content['page_url'];?>">
        <?php echo $content['content'];?>
        <?php if(isset($accept_terms)){ ?>
        	<div class="row">
        	<input type="checkbox" id="accept_check" />&nbsp;<label style="color: #666666; font-family: 'onduititc'; font-weight: normal; font-size:17px;">I agree with terms & conditions.</label>
            </div>
            <div class="row">
            <a href="javascript://" class="submitbtn" onclick="check_accept();" style="float:left !important; margin-left:400px !important;">Continue</a>
            </div>
        <?php } ?>
       </div>
 </section>     
 </section> 

<script type="text/javascript">

function check_accept()
{
	
	if($('#accept_check').attr('checked'))
	{
		window.location.href="<?php echo SITE_URL;?>/jobcards/profileWizard";
								
	}else{
		
		alert('Please tick the checkbox for terms & conditions.');	
	}		 
}

</script>
