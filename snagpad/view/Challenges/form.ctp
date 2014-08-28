<section class="top_sec">
	<section class="left_sec">
		<h3> Challenge: <span><?php echo $challenge[0]['Challenge']['title'];?></span></h3>
         <p><?php echo $challenge[0]['Challenge']['description'];?></p>
          </section>
          <section class="right_sec"><span><?php echo $challenge[0]['Challenge']['points'];?></span><small>points</small></section>       
</section>
<div class="challenge_section">
	<section class="tips"><p><strong>Hints: </strong><i><?php echo $challenge[0]['Challenge']['tips'];?></i></p></section>
    <?php if($challenge[0]['Challenge']['form_title']){ ?>
    <section class="tips"><span><?php echo $challenge[0]['Challenge']['form_title'];?></span></section>
    <?php } ?>
    <div style="float:left;width:70%;">
    <div id="no_file" class="error" style="display:none;">Please select file to attach.</div>
	 <form name="frmchallenge" id="frmchallenge"  enctype="multipart/form-data" action="" ><fieldset>
     <input type="hidden" name="num" value="<?php echo $challenge[0]['Challenge']['num'];?>"/>
     <input type="hidden" name="point" value="<?php echo $challenge[0]['Challenge']['points'];?>"/>
      <?php $file_flag=0; for($i=1;$i<=$challenge[0]['Challenge']['num'];$i++){
		 $j=$i;
	 foreach($fields as $fieldtable){
		  $field=$fieldtable['Challengedetail']; 
		$id=$field['challenge_id'];		 
	 ?>
     
      <?php switch($field['field_value'])
	   { 
	  	case 'text':
			echo "<input type='text' name='field_$field[id][$i]' id='field_$field[id][$i]' placeholder='$field[field_name] $j' ";
		if($id!='37' || $i==1)
			echo "class='required' ";
		 if(isset($data[$field['id']][$i])) echo "value='".$data[$field['id']][$i]."'";
		echo " $status>";
		break;
		case 'email': 
			echo "<input type='text' name='field_$field[id][$i]' id='field_$field[id][$i]' placeholder='$field[field_name] $j' ";
		//if($id!='37' || $i==1)
			echo "class='required email' ";
		 if(isset($data[$field['id']][$i])) echo "value='".$data[$field['id']][$i]."'";
			echo " $status >";
			break;
		case 'url': 
			echo "<input type='text' name='field_$field[id][$i]' id='field_$field[id][$i]' placeholder='$field[field_name] $j' ";
		//if($id!='37' || $i==1)
			echo "class='required url' ";
		 if(isset($data[$field['id']][$i])) echo "value='".$data[$field['id']][$i]."'";
			echo " $status >";
			break;
		case 'textarea': 		 
			 if($id=='63')
			 {
				  echo "<textarea name='field_$field[id][$i]' id='field_twit' class='required' $status onKeyDown='textCounter()' onKeyUp='textCounter()' placeholder='$field[field_name] $j' >";
			if(isset($data[$field['id']][$i])) echo $data[$field['id']][$i];
			 echo"</textarea>";
			 echo '<input readonly type="text" name="remLen" size="3" value="125" style="width:30px;">';	
			 }
			 else
			 {
				 echo "<textarea name='field_$field[id][$i]' id='field_$field[id][$i]' class='required' placeholder='$field[field_name] $j' $status >";
			 if(isset($data[$field['id']][$i])) echo $data[$field['id']][$i];
			 echo"</textarea>";
			}
			break;
			case 'date':?> 
	     <input type="text" class='required text date' name="<?php echo "field_$field[id][$i]";?>" id="<?php echo "field_$field[id]_$i";?>" value="<?php if(isset($data[$field['id']][$i])) echo $data[$field['id']][$i];?>" placeholder='<?php echo $field['field_name'].' '.$j?>' readonly>
 <?php if(!$status) {?>
<script type="text/javascript">
$(document).ready(function(){
	//var year=new Date.getFullYear();
	//var y1=parseInt(year)+1;
	$("#<?php echo "field_$field[id]_$i";?>").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: 'c:+1',
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				$("#<?php echo "field_$field[id]_$i";?>").datepicker( "option", "minDate", selectedDate );
			}
			//showOn: ("focus")
		});
		
		$('#<?php echo "field_$field[id]_$i";?>').keyup(function(e) {
   		 if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    	}
		});			
});
</script>
<?php } ?>
	   <?php break;
	   case 'time': if(isset($data[$field['id']][$i])) { ?>
       <input type="text" name="<?php echo "field_$field[id][$i]";?>" id="datetime<?php echo $i;?>" value="<?php echo $data[$field['id']][$i];?>" readonly="readonly" class="datetime"/><?php } else {?><select id='hour<?php echo $i;?>' onchange="datetime('<?php echo $i;?>');"><?php for($j=1;$j<=12;$j++) if($j<10) {echo "<option value='0$j'>0$j</option>"; }else if($j==10){ echo "<option value='$j' selected='selected'>$j</option>"; } else{ echo "<option value='$j'>$j</option>"; }?></select> : <select id="minute<?php echo $i;?>" onchange="datetime('<?php echo $i;?>');"><?php for($j=0;$j<=50;$j+=10) if($j<10) echo "<option value='0$j'>0$j</option>"; else echo "<option value='$j'>$j</option>";?></select> <select id="am<?php echo $i;?>" onchange="datetime('<?php echo $i;?>');" ><option value='AM'>AM</option><option value='PM'>PM</option></select>
       <input type="hidden" name="<?php echo "field_$field[id][$i]";?>" id="datetime<?php echo $i;?>" value="10:00 AM" />
	   <?php } 
	   		$time=1;
	   		break;
	    case 'file': 		
		echo '<input type="hidden" id="field_id" value="'.$field['id'].'" />';
			$file_flag=1; 		
		echo $this->Html->css('nanoscroller');
		echo $this->Html->script('jquery.nanoscroller.min');
		?>
        <input type="hidden" id="check_value" value="0"/>
        <ul class="indexSkills1">
              <li style="text-align:left !important; padding: 10px 3% 10px 65px!important; width: 86%!important;">   
              	  	<div id="div_error"></div>		
                      <div class="clearfix">
                     <span id="loader" style="display:none;"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                     <div class="nano">
						<div class="challenge_file_listing" style="height:110px !important;overflow:hidden">
                     			<div id="file_listing"></div>
                     	</div>
                     </div>
                 </li>                         
              </ul>       
         <?php 
		 break;
		 ?>
		   
     <?php } } } ?>
           <input type="hidden" name="challenge_id" id="challenge_id" value="<?php echo $id;?>" />
         <div class="common_btn">        
         <?php if(!$status) {?><a href="javascript://" onclick="submitForm();" >Save</a><?php } ?>
         <a href="javascript://" onclick="attemptLeter()" > <?php if($status) echo "Close"; else echo "Atempt Later"; ?></a></div>
         
          </fieldset></form>
          </div>
          <div style="float:left; width:29%;padding-top:25px;">
          <ul class="indexSkills1">
          <li style=" text-align:left !important;padding: 16px 0 16px 40px!important; width:80% !important;">
               <?php if($file_flag && !$status){ echo $this->Html->script('jquery.ocupload');  ?>
               <h4>Upload New Files : </h4> 
               
                  <div class="rowdd" align="left">         
                     <div class="profileBtnSp"> <a href="javascript://" class="rtMargin uploadbtn"  id="upload_motif" title="Select a File from your computer" ><span style="width:auto;cursor:pointer; background:#00C;-webkit-border-radius:5px;border-radius:5px; color:#fff; font-weight:bold; font-size:13px; line-height:17px; padding:5px 10px;z-index:99; behavior: url(PIE.htc); text-align:center; text-decoration:none; text-decoration:none; position:absolute; top:-20px; left:150px" >Upload</span> </a></div>  
                        <div id="motif_status"></div>
                        <span id="motif_loader" style="display:none;"><?php echo $this->Html->image('loading.gif',array('escape'=>false,'alt'=>'loading...'));?></span>
                        <span id="motif_progress"></span>
                        <div id="uploaded_motif"></div>
                   </div> 
                   <?php }?>      
                 </li>
                 </ul>
          </div>       
</div>

<script type="text/javascript" language="javascript">

function submitForm(){
	var clientid=$('#client_id').val();	
if($("#frmchallenge").valid()){	
<?php if($file_flag==0){?>			
		$.post('<?php echo SITE_URL;?>/challenges/form_submit',$("#frmchallenge").serialize()+'&client_id='+clientid,function(data){
			var challengeid=data;			
			show_my_challenge(clientid,challengeid);
		});	
		
		<?php }else{?>
	$('input:checked').each(function(){
		if($(this).attr('checked'))
		{
			var ch=$(this).val();
			$('#check_value').val(ch);
		}
	});
	if($('#check_value').val()==0)
	{
		$('#no_file').show();	
		setTimeout(function(){$('#no_file').hide();},4000);
		return false;
	}else{	
	$.post('<?php echo SITE_URL;?>/challenges/form_submit',$("#frmchallenge").serialize()+'&client_id='+clientid,function(data){
			var challengeid=data;
			show_my_challenge(clientid,challengeid);
		});
	}
		<?php }?>
			}
	get_intensity_meter();
	show_challenge_scroll();
}

function attemptLeter(){
	var clientid=$('#client_id').val();
	show_my_challenge(clientid);
}
function textCounter()
{
	var tot=document.getElementById('field_twit').value.length;
	var val=125-parseInt(tot);
	if(val<0)
	{
		document.frmchallenge.Submit_but.disabled = true;
		document.frmchallenge.Submit_but.setAttribute("class", "m_button1"); //For Most Browsers
		document.frmchallenge.Submit_but.setAttribute("className","m_button1"); //For IE; harmless to other browsers.
	}
	else
	{
		document.frmchallenge.Submit_but.disabled = false;
		document.frmchallenge.Submit_but.setAttribute("class", "m_button"); //For Most Browsers
		document.frmchallenge.Submit_but.setAttribute("className","m_button"); //For IE; harmless to other browsers.
	}
	document.frmchallenge.remLen.value=val;

}
function datetime(num)
{
	
	var tot=document.getElementById('hour'+num).value;
	tot+=":"+document.getElementById('minute'+num).value;
	tot+=" "+document.getElementById('am'+num).value;
	//alert(tot);
	document.getElementById('datetime'+num).value=tot;
}


<?php if($file_flag==1){?>	
	
		//upload motifs ---------------------------------------------------------
	$(document).ready(function(){		
		<?php if($file_flag && !$status){ ?>
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
					$("#div_error").removeClass('error');
					$("#div_error").addClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);				
				}
				else if(responseType=="error")
				{
					$("#div_error").html(responseMsg);	
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);					
				}else{
					$("#div_error").html(responseMsg);
					$("#div_error").addClass('error');
					$("#div_error").removeClass('success');
					$("#div_error").show();
					setTimeout(function(){$("#div_error").hide();},3000);	
				}
		   	}
		   });//end of upload monograms
		   <?php }?>
		  
		   
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
function fileList()
{	
	var clientid=$('#client_id').val();	
	var challengeid=$('#challenge_id').val();
	var fieldid=$('#field_id').val();
	$('#loader').show();
	$("#file_listing").hide();
		$.post("<?php echo SITE_URL; ?>/challenges/profile_file_list",'client_id='+clientid+'&challenge_id='+challengeid+'&field_id='+fieldid+'&status=<?php echo $status; ?>',function(data){			
		 	$("#file_listing").html(data);			 
			$('#file_listing').slideDown(); 
			$('#loader').hide();	
			setTimeout(function(){ $('.nano').nanoScroller({alwaysVisible: false, contentClass: 'challenge_file_listing',sliderMaxHeight: 70});},1000);
	});	
	
	
}
 fileList();
<?php } ?>			   
 <?php if($status!='' && $id=='63'){ echo "textCounter()"; } ?>
</script> 
 <?php if(isset($time)){?>
<style>input.date{width:395px;}</style>
<?php } ?>