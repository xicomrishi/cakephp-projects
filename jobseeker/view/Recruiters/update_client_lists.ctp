
	<section class="main_container none">
    <section class="jobs">
    <section class="title">Add Client List</section>
			<section class="details">
            <div id="commentStatus"></div>
            <form name="AddClients" method="post" id="AddClients" action="#" onsubmit="return updateAddClients();" novalidate="novalidate">
             <?php echo $this->Form->input('RecruiterClient.recruiter_id',array('label'=>false,
                	  'type'=>'hidden','value'=>$clientdata[0]));?>
            	<section class="inputs">
                    <div class="input_row">	
                        <label>Company Name</label>
                        <?php echo $this->Form->input('RecruiterClient.company_name',array('label'=>false,'value'=>$clientdata[1],
                	  'placeholder'=>'Name of your company'));?>
                      
   					</div>
                    <div class="input_row">
                    <?php if($clientdata[2]!=''){ $clientdata[2]='http://'.$clientdata[2];}?>
                        <label>Company Website</label>
                       <?php echo $this->Form->input('RecruiterClient.company_website',array('label'=>false,'value'=>$clientdata[2],'onfocus'=>'if (this.value=="") this.value = "http://"','onblur'=>'if(this.value=="http://") this.value="";','placeholder'=>'http://www.abc.com','class'=>'company_website validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?>
                      
   					</div>
            	</section>
            	<section class="inputs">
                    <div class="input_row">
                        <label>Type of hire</label>
                        <?php echo $this->Form->input('RecruiterClient.type_of_hire',array('label'=>false,'options'=>array('Direct'=>'Direct Hire','Indirect'=>'Indirect Hire'),'value'=>$clientdata[4]));?>
                        
   					</div>
                    <div class="input_row">
                        <label>Candidate Placed</label>
                        <?php echo $this->Form->input('RecruiterClient.candidate_placed',array('label'=>false,'value'=>$clientdata[3],'class'=>'less'));?>
   					</div>
            	</section>
            	<section class="inputs">
                    <div class="add_btn">
      					<?php echo $this->Form->input('save',array('label'=>false,
          			  'type'=>'submit','class'=>'submit'));?>
<img src="<?php echo $this->webroot;?>img/ajax-loader.gif" alt="wait.." id="loader1" style="display:none" />
      				</div>	              
            	</section>
            </section>
            <?php $this->Form->end();?>
     </section>
    </section>
    
 <script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#AddClients").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});

$('input[type="text"],input[type="number"]').each(function() {
		 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
	  });
	   $( 'input[type="text"],input[type="number"]').focus(function() {
		$(this).validationEngine('hide');
		$(this).validationEngine().css({border : "1px solid #E4E1E1"});
		 $(this).validationEngine().css({'background-color' : "#ffffff"});
			});
			$( 'input[type="text"],input[type="number"]').blur(function() {
				 
				var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }else{
				 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
			 }
	
			});
		
		
var readOnlyLength = 7;
$('#RecruiterClientCompanyWebsite').on('keypress, keydown', function(event) {
    if ((event.which != 37 && (event.which != 39) && (event.which != 9))
        && ((this.selectionStart < readOnlyLength)
        || ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
        return false;
    }
});
$('#RecruiterClientCompanyWebsite').on('select', function(event) {
	 var len = this.value.length;
	this.setSelectionRange(readOnlyLength, len);
    
});
});
function updateAddClients(){
	 var validate = $("#AddClients").validationEngine('validate');
	 if(validate){
	$('#commentStatus').html('');
	$('#loader1').show();
	
	
	$.post('<?php echo $this->webroot;?>recruiters/add_client_lists',$('#AddClients').serialize(),function(data){
		$('#loader1').hide();
		var result=JSON.parse(data);
		if(result.Success){
			$('#commentStatus').html(result.Success);
			$('.update_client .client_data').append('<tr><td>'+result.company+'</td><td>'+result.type_of_hire+'</td><td class="last">'+result.candidate+'</td></tr>');
			}
	
	setTimeout(function() {
				$.fancybox.close();
		}, 2000);
	
		
	});
	
	 }
	
		
return false;
}

</script>
