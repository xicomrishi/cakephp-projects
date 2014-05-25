<table width="100%" cellpadding="0" cellspaing="0" border="0" id="afterlogin">
	  <tr><td colspan="2" align="center">
      <div id='progressImg' style='display:none'>
      <?php echo $this->Html->image("ajax-loader.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?>
      </div>
 <div class='msg' id="div_msg" ></div>
</td></tr>
<tr><td width="60%" valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="5">
          <tr>
            <td><strong style="font-size:16px; line-height:18px">COMPANY NAME:</strong></td><td><input type="text" name="company_name" id="company_name" <?php if(isset($arr['jobCompany'])) echo "class='normal'"; else echo"class='novalue'";?> onFocus="if(this.value=='Data not found. Enter manually.'){this.value=''; this.className='normal'}" onBlur="if(this.value==''){this.className='novalue'; this.value='Data not found. Enter manually.';}" value="<?php if(isset($arr['jobCompany'])) echo $arr['jobCompany']; else echo "Data not found. Enter manually.";?>" /></td>
			<td><strong style="font-size:16px; line-height:18px"> POSITION AVAILABLE:</strong></td><td><input type="text" name="job_title" id="job_title" <?php if(isset($arr['jobTitle'])) echo "class='normal'"; else echo"class='novalue'";?> onFocus="if(this.value=='Data not found. Enter manually.'){this.value=''; this.className='normal'}" onBlur="if(this.value==''){this.className='novalue'; this.value='Data not found. Enter manually.';}" value="<?php if(isset($arr['jobTitle'])) echo $arr['jobTitle']; else echo 'Data not found. Enter manually.';?>"  /></td>
			</tr>
            <?php if(isset($arr['job_detail']) && $arr['job_detail']!=''){?>
			<tr><td valign="top"><strong style="font-size:16px; line-height:18px">JOB DETAIL: </strong><td colspan="3"><textarea name="description"  cols="45" rows="5" id="description" <?php if($arr['job_detail']!='') echo "class='normal'"; else echo"class='novalue'";?> onFocus="if(this.value=='Data not found. Enter manually.'){this.value=''; this.className='normal'}" onBlur="if(this.value==''){this.className='novalue'; this.value='Data not found. Enter manually.';}"><?php if($arr['job_detail']!='') echo $arr['job_detail']; else echo 'Data not found. Enter manually.';?></textarea></td>
                </tr>
                <tr>
                  <td  valign="top"><strong style="font-size:16px; line-height:18px">ADD NOTES</strong>:</td>
                  <td  colspan="3"valign="top"><textarea id="notes" name="notes"  cols="45" rows="5"  class="novalue" onFocus="if(this.value=='Enter your notes about the job opportunity here'){this.className='normal'; this.value='';}" onBlur="if(this.value==''){this.className='novalue'; this.value='Enter your notes about the job opportunity here';}">Enter your notes about the job opportunity here </textarea></td>
               
          <tr>
            <td valign="top"><strong style="font-size:16px; line-height:18px">APPLICATION EMAIL:</strong></td>
        
            <td valign="top" colspan="3"><input name="contact_email" type="text" id="contact_email"  onchange="if(this.value=='Data not found. Enter manually.') this.className='novalue'; else this.className='normal';" <?php if(isset($arr['contact_email'])) echo "class='normal'"; else echo"class='novalue'";?> onFocus="if(this.value=='Data not found. Enter manually.'){this.value=''; this.className='normal'}" onBlur="if(this.value==''){this.className='novalue'; this.value='Data not found. Enter manually.';}" value="<?php if(isset($arr['contact_email'])) echo $arr['contact_email']; else echo 'Data not found. Enter manually.';?>" /></td>
          </tr>
		  <?php }else{?>
          <tr><td colspan="4">
		<iframe style="width:100%;text-align:center;height:178px" id="jsb_content_iframe" name="jsb_content_iframe" src=""></iframe>
        </td></tr>
        <?php }?>
        
		  <tr><td colspan="4" align="center"><a href="javascript://" onClick="submitDescription()" class="add_jobcard">Add to Job Card Basket                            
			</a></td></tr>
        </table>
        </td><td id="jsb_basket" valign="top">
        </td>
		</tr>
</table>
	  <input type='hidden' id='location' value="<?php if(isset($jobLocation)) echo $jobLocation;?>" />
      	  <input type="hidden" name="token" id="token" value="<?php echo $this->Session->read('Client.Client.id'); ?>" />

<script type="text/javascript">          
          <?php if($arr['job_detail']==''){?>
window.frames['jsb_content_iframe'].document.location.href='<?php echo $url;?>';
$(window).load(function(){
    $('#jsb_content_iframe').contents().find('a').click(function(event) {
        event.preventDefault();
    }); 
});
<?php }?>

function fillBasket() {
		jsb_token=$('#token').val();
		$('#progressImg').show();
		$.post('<?php echo SITE_URL;?>/Snagplugin/filled_basket','token='+jsb_token+'&act=basket',function(p){
		document.getElementById('jsb_basket').innerHTML=p;
		$('#progressImg').hide();
		});

	}
$('#logout').html('<a href="javascript://" onClick="Logout();" style="color:#134E68;text-decoration:none"><strong>Logout</strong></a> (<?php echo $this->Session->read('Client.Client.name'); ?>)');
fillBasket();
</script>
