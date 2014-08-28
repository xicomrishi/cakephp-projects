<section class="tabing_container">
<input type="hidden" id="num" value="<?php echo $num; ?>"/>
        <section class="tabing">
          <ul class="gap">
           <?php if($this->Session->read('usertype')=='3'){?> <li id="invite_contact_li" class="contacts_li"><a href="javascript://" onclick="show_invite_contact();">+ SNAGCAST</a></li><?php }?>
            <li id="add_contact_li" class="contacts_li"><a href="javascript://" onclick="show_add_contact()">+ ADD A CONTACT</a></li>
            <li id="export_contact_li" class="contacts_li"><a href="<?php echo SITE_URL; ?>/contacts/export"><span> EXPORT CONTACTS</span></a></li>
            <li class="active contacts_li" id="search_contact_li"><a href="javascript://" onclick="show_search()">SEARCH CONTACTS</a></li>
          </ul>
        </section>
        <input type="hidden" id="account_id" name="account_id" value="<?php echo $account_id;?>"/>
        <section class="top_sec">
          
         
        </section>
        <section class="contact_section">
        
       </section>
        
      </section>
<script language="javascript">
$(document).ready(function(e) {
	var num=$('#num').val();
	if(num=='1')
	{
		show_add_contact();
	}else if(num=='3'){
		show_invite_contact();
	}else{
		show_search(1);
		}
	
	
    get_index_contacts();
});

function get_index_contacts()
{
	var id=$('#account_id').val();
	//alert(id);
	$('.contact_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post("<?php echo SITE_URL; ?>/contacts/index",'account_id='+id,function(data){	
					$(".contact_section").html(data);
				
				});		
	
}

function show_search(num)
{	
	var id=$('#account_id').val();
	$('#search_contact_li').addClass('active');
	$('#add_contact_li').removeClass('active');
	$('.contact_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');		
	$.post("<?php echo SITE_URL; ?>/contacts/show_search",'account_id='+id,function(data){	
					$(".top_sec").html(data);
					$('#searchkeyword').val('');
					if(num!='1')
					{
					get_list_cont(); 
					setTimeout(function(){ $('#searchkeyword').val('Enter Contact Name');},1000);
					}
				
	});	
		
				
				
}

function get_list_cont()
{
	$.post("<?php echo SITE_URL; ?>/contacts/search_contact",$('#contactForm').serialize(),function(data){	
					$(".contact_section").html(data);
				
				});
}

function show_add_contact()
{
	$('.contacts_li').removeClass('active');
	$('#add_contact_li').addClass('active');
	
	var id=$('#account_id').val();
	$.post("<?php echo SITE_URL; ?>/contacts/show_add_contact",'account_id='+id,function(data){	
					$(".top_sec").html(data);
				
				});
	
}

function show_invite_contact()
{
	$('.contacts_li').removeClass('active');
	$('#invite_contact_li').addClass('active');
	$('.top_sec').html('<h3 style="display:inline">SnagCast your Job Search Activity</h3>');
	//$('.contact_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;">Coming Soon!</div>');
var id=$('#account_id').val();
	$.post("<?php echo SITE_URL;?>/contacts/snagcast_index",'',function(frm){
			$('.top_sec').html(frm);
		});

	$('.contact_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php  echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post("<?php echo SITE_URL; ?>/contacts/list_invited_contacts",'account_id='+id,function(data){	
					$(".contact_section").html(data);
				
				});	
	
}


</script>      