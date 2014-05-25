 
<div class="breadcrumb">
<ul>
<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
<li><a href="javascript://" onclick="return nextStep('step-2','<?php echo $this->Session->read('Gifting.type');?>');">select gift type</a></li>
<li class="last">Recipient</li>
</ul>
</div>
<div class="step_3_com">
<?php echo $this->Html->image('step3_com_img.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
</div>
<div class="friend_detail">


<form id="friendForm" name="friendForm" action="" onsubmit="return frndSubmit();">
<input type="hidden" id="google_click" value="0"/>
<input type="hidden" id="gifting_type" value="<?php echo $this->Session->read('Gifting.type');?>"/>
<input type="text" id="friend_name" placeholder="Recipient Name" class="validate[required]" value="<?php if($this->Session->check('Gifting.friend_name')) echo $this->Session->read('Gifting.friend_name');?>" onfocus="show_fb_connect();" />

<input type="text" id="friend_email" placeholder="E-mail ID" class="validate[custom[email]]" value="<?php if($this->Session->check('Gifting.friend_email')) echo $this->Session->read('Gifting.friend_email');?>" />
<input type="text" id="friend_phone" placeholder="Mobile" class="validate[minSize[10],maxSize[10]]" maxlength="10" value="<?php if($this->Session->check('Gifting.friend_phone')) echo $this->Session->read('Gifting.friend_phone');?>" />
</form>
<div class="instruction_box" style="display:none;">
<h3 style="font-size:12px !important;">Type the name and email ID of the recipient manually or use Facebook / Gmail friend list.</h3>
<div class="separator">
<span class="overlay"> or </span>
<hr>
</div>
<a href="javascript://" onclick="connect_fb('1','1');"><?php echo $this->Html->image('facebook_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
<a href="javascript://" id="get_google" onclick="<?php //if($this->Session->check('User.Google.contacts')){ echo 'show_google_friends();'; }else{ echo 'handleAuthClick();'; } ?>"><?php echo $this->Html->image('gmail_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
</div>
<div class="friend"><?php echo $this->Html->image('friend_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></div>
</div>

            <div class="action">
             
            <a href="javascript://"  class="no" onclick="frndSubmit();">Next</a>
                <a href="javascript://"  class="yes" onclick="return nextStep('step-2','<?php echo $this->Session->read('Gifting.type');?>');">Previous</a>
            
            </div>

<script type="text/javascript">
  var clientId = '<?php echo Google_ID; ?>';
      var apiKey = '<?php echo Google_KEY;?>';
      var scopes = 'https://www.google.com/m8/feeds';
$(document).ready(function(e) {	
   
	$("#friendForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});    
	
	$('#get_google').click(function(e) {
		
         <?php if($this->Session->check('User.Google.contacts')){ ?>
		 	show_google_friends();
		 <?php }else{ ?>		
		 	 $('#google_click').val(1);	
			handleAuthClick();
			 	
		  <?php } ?>
		  
       });	
	   
	  <?php if(!$this->Session->check('Gifting.friend_name')) { ?>

        $('input[placeholder]').each(function(){  
			var input = $(this);        
			
			$(input).val(input.attr('placeholder'));
						
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			   setTimeout(function(){ $('input').css('border','1px solid #ABD0E9'); },100);
			   
			});
		});
    
  <?php } ?>  
	   
		
});

function frndSubmit()
{
	var email=$('#friend_email').val();
	var mobile=$('#friend_phone').val();
	if(email=='E-mail ID')
		$('#friend_email').val('');
	if(mobile=='Mobile')
		$('#friend_phone').val('');	
	var valid = $("#friendForm").validationEngine('validate');
			if(valid)
			{
				var gifting=$('#gifting_type').val();
				get_friend_name(gifting);
				//nextStep('step-3','one_to_one');
			}
			else{
				$("#friendForm").validationEngine({scroll:false,focusFirstField : false});
				shakeField();
			}
	return false;		
  
}
function show_fb_connect()
{
	$('.instruction_box').slideDown(200);
	//$('#inst_'+num).slideDown(200);	
}


function handleClientLoad() {
		 
gapi.client.setApiKey(apiKey);
window.setTimeout(checkAuth,1);	
}

      function checkAuth() {
		
			 gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);						  
	   }
	   
	   
	    function handleAuthResult(authResult) { 
        var authorizeButton = document.getElementById('get_google');
        if (authResult && !authResult.error) {
          //authorizeButton.style.visibility = 'hidden';
		  var authParams=gapi.auth.getToken();
			
			authParams.alt = 'json';
			makeAPIcall(authParams);
			
        
			
        } else {
        
          authorizeButton.onclick = handleAuthClick;
        }
      }
	  
	  function handleManualAuthResult(authRes)
	  {
			 var authorizeButton = document.getElementById('get_google');
        if (authRes && !authRes.error) {
        
			checkAuth();
			$('#google_click').val(1);
			
	  	 } else {
          //authorizeButton.style.visibility = '';
		 //$('#google_click').val(1);
          authorizeButton.onclick = handleAuthClick;
        }
	  }
	  
	  function makeAPIcall(authParams)
	  {   var authorizeButton = document.getElementById('get_google');
			 $.ajax({
			
			  url: 'https://www.google.com/m8/feeds/contacts/default/full',
			  dataType: 'jsonp',
			  data: authParams,
			  success: function(data) {  
			  	 //console.log(data);
				
					$.post(site_url+'/home/get_google_friends',{resp:data},function(fr){	
						//$('#google_click').val(2);
						if($('#google_click').val()==1)
						     show_google_friends();							
						else
						  	authorizeButton.onclick=show_google_friends;		 
														
					});	
					
			  }
			});  
	  }
	  

      function handleAuthClick(event) {
		
		gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleManualAuthResult);
		return false;		
      }  
	  
	  function show_google_friends()
	  {
			
				$.fancybox.open(
				{
					'autoDimensions'    : false,
					'autoSize'     :   false,
					'width'             : 450,
					'type'				: 'ajax',
					'height'            : 550,
					'href'          	: site_url+'/home/show_google_friends'
				}
				);   
	  }   
</script>
