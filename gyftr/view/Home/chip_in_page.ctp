<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">select gift type</a></li>
                 <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','group_gift');">Recipient</a></li>
				<?php } ?>
				<li><a href="javascript://" onclick="return nextStep('step-3','<?php $sess=$this->Session->read('Gifting.type'); if($sess=='me_to_me') echo 'meTome'; else echo $sess; ?>');">select gift</a></li>        
                <li><a href="javascript://" onclick="return select_product('0');">basket</a></li> 
                <li><a href="javascript://" onclick="voucherStep('get_delivery');">delivery</a></li>         
                <li class="last">Contributors</li>
            </ul>
	</div>


<div id="form_section" class="none2">
    <form id="chipinForm" name="chipinForm" method="post" action="" onsubmit="return submit_chipin_form();">
    <div class="select_dele">/ / who all are <strong>Chipping </strong>in?</div>
        <input type="hidden" id="count_fnd" value="<?php if(isset($is_friends)){ echo (count($friends)-1); }else{ echo '0'; } ?>"/>
        <input type="hidden" id="fb_frnds_done" value="0"/>
        <input type="hidden" id="google_click" value="0"/>
        <div class="all_multi_frnds"></div>
        <div class="friend_detail add_chipin">
            <div class="row">
                <span class="col">
                    <label>Name</label>
                    <input type="text" id="chip_name" class="validate[required]" onfocus="$('.instruction_box').slideDown(200);">
                </span>
                <span class="col">
                    <label>Email</label>
                    <input type="text" id="chip_email" class="validate[custom[email]]">
                 </span>
                 <div class="instruction_box" style="display:none; width:88%">
                    <h3 style="font-size:12px !important; padding-top:8px;">Type the name and email ID of the recipient manually or use Facebook / Gmail friend list.</h3>
                    <div class="separator">
                    <span class="overlay"> or </span>
                    <hr>
                    </div>
                    <a href="javascript://" onclick="connect_chip_fb('1','1');"><?php echo $this->Html->image('facebook_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
                    <a href="javascript://" id="get_google" onclick="<?php //if($this->Session->check('User.Google.contacts')){ echo 'show_google_friends();'; }else{ echo 'handleAuthClick();'; } ?>"><?php echo $this->Html->image('gmail_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
                    </div>
             </div>
            <div class="row">
                 <a href="javascript://" onclick="update_chip_list(0);" class="add_another">add another friend</a>
            </div>
            <div class="row done_button">
                 <a href="javascript://" onclick="<?php if(isset($is_friends)){ if(!empty($friends)) echo 'update_chip_list(1);'; }else{ echo 'check_input_frnd();'; } ?>" class="done orenge">done</a>
            </div>
        </div>
    </form>
    
</div>

<div class="add_sec">
    <div class="select_dele green">/ / the<strong>  Chippers</strong></div>
    <div class="chip_detail" style="padding:0px; width:100%">
    	<div class="nano_4 nano">
        <div class="detail none scroll">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="detail none">
            <tbody>
            <?php if(isset($is_friends)){ 
					$p=0;
					foreach($friends as $fr){	?>
            		<tr class="<?php if($p%2==0) echo 'even'; else echo 'odd'; ?>">
               			 <td align="left"><?php if(!empty($fr['fb_id'])){ ?><img src="https://graph.facebook.com/<?php echo $fr['fb_id']?>/picture" alt="" height="28" width="28"/><?php }else{  ?><img src="<?php echo $this->webroot; ?>img/facebook_profile_pic.jpg" alt="" height="28" width="28"/><?php } ?>
                         <?php echo $fr['name']; ?>
                         </td>
                	</tr>
                    
            <?php $p++;} } ?>
            </tbody>
           </table>
           </td>
          </div>  
    </div>
</div>

<div class="bottom">
                <span class="right_img none">
                <?php echo $this->Html->image('form_right_bg1.png',array('escape'=>false));?>
                 
                 </span>
            </div>

<script type="text/javascript">

 var clientId = '<?php echo Google_ID; ?>';
      var apiKey = '<?php echo Google_KEY;?>';
      var scopes = 'https://www.google.com/m8/feeds';

	//alert(1);
    handleClientLoad();	
	$("#chipinForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});    
	$(".nano_4").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });


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
				//$.unblockUI();
				$.fancybox.open(
				{
					'autoDimensions'    : false,
					'autoSize'     :   false,
					'width'             : 450,
					'type'				: 'ajax',
					'height'            : 550,
					'href'          	: site_url+'/home/show_google_friends/1'
				}
				);   
	  } 
	  
	  function connect_chip_fb(step,status_step) {
			FB.getLoginStatus(function(resp) {
			  	if (resp.status === 'connected') {
					$.fancybox.open(
						{
							'autoDimensions'    : false,
							'autoSize'     :   false,
							'width'             : 450,
							'type'				: 'ajax',
							'height'            : 550,
							'href'          	: site_url+'/home/get_friends/'+step+'/'+status_step+'/1',
							keys : {
										close  : null
									  },
							closeClick  : false, // prevents closing when clicking INSIDE fancybox
							helpers     : { 
								overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
							}
						}
					); 
				}else{
					
					FB.login(function(response) {
						$.fancybox.open(
							{
								'autoDimensions'    : false,
								'autoSize'     :   false,
								'width'             : 450,
								'type'				: 'ajax',
								'height'            : 550,
								'href'          	: site_url+'/home/get_friends/'+step+'/'+status_step+'/1',
								keys : {
											close  : null
										  },
								closeClick  : false, // prevents closing when clicking INSIDE fancybox
								helpers     : { 
									overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
								}
							}
						); 
					  
					}, {scope:'email,read_mailbox,publish_stream,user_location,offline_access'});
				}
			}, true);
			

}  

function submit_chipin_form()
{
	var valid = $("#chipinForm").validationEngine('validate');
	if(valid)
	{	var frm=$('#chipinForm').serialize();
		showLoading('#banner');
		$.post(site_url+'/home/save_chipin_frnds',frm,function(data){
			//alert(data);
			get_decide_contri();
			//$('#banner').html(data);
			});
	}else{
		 $("#chipinForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField(); 
	}
	return false;
}

function update_chip_list(check)
{
	var count=$('#count_fnd').val();
	
	var name=$('#chip_name').val();
	var email=$('#chip_email').val();
	//alert(check);
	if(name!=''&&email!=''||check=='0')
	{
	var valid = $("#chipinForm").validationEngine('validate');
	if(valid)
	{		
		name = name.replace(/[^a-zA-Z0-9]/g,'');		
		email = email.replace(/[&\/\\#,+()$~%'":*?<>{}]/g,'');
		
		count=parseInt(count)+1;
		$('#count_fnd').val(count);
		$('.chip_detail').html('<div style="height:100px; margin-top:30px;text-align:center;"><img src="<?php echo SITE_URL; ?>/img/ajax-loader.gif" alt="Loading..."/></div>');
		$.post('<?php echo SITE_URL; ?>/home/update_chip_list/1',{ name:name, email:email},function(data){
			if(check==0)
			{ $('.chip_detail').html(data);
			//document.getElementById('chipinForm').reset();	
			$('#chip_name').val('');
			$('#chip_email').val('');
			}else{
				next_contri_step();
			}
		});		
		
	}else{
		 $("#chipinForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	}else{
		next_contri_step();
	}
	
}

function next_contri_step()
{
	
	$.post(site_url+'/home/save_chipin_frnds',function(data){
			//alert(data);
			get_decide_contri();
			//$('#banner').html(data);
			});	
}

function check_input_frnd()
{
	update_chip_list(1);
	//setTimeout(function(){ next_contri_step(); },1000);	
}
   
</script>
