
	<section class="main_container none">
    <section class="title" style="margin:0 0 10px 0">Manage Tag</section>
    <table class="forward" cellpadding="0" cellspacing="0" border="0" width="100%">						
        	<thead>
            	<tr>
                	<th>&nbsp;</th>
                    <th>Tags</th>
                    <th class="last">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $i=0; foreach($tagDetails as $tags){?>
            <tr id="<?php echo $tags['ProfessionalTag']['tag_name'].'_'.$i;?>">
                	<td><input type="checkbox" value="<?php echo $tags['ProfessionalTag']['tag_name'];?>" onchange="updateTagStatus1(this,'<?php echo $tags['ProfessionalTag']['id'];?>');" <?php if($tags['ProfessionalTag']['tag_status']=='Yes'){ ?> checked="checked" <?php }?>></td>
                    <td id="tagName_<?php echo $i;?>"><?php echo $tags['ProfessionalTag']['tag_name'];?></td>
                    <td class="last">
                    	<div class="edit"><a href="#">Edit</a>
                    		<span class="tooltip">
                            	<span class="tt">
                                    <input type="text" value="<?php echo $tags['ProfessionalTag']['tag_name'];?>" id="tagEdit_<?php echo $i;?>">
                                    <a href="javascript://" onclick="return editTags('<?php echo $tags['ProfessionalTag']['id'];?>','tagEdit_<?php echo $i;?>','tagName_<?php echo $i;?>');"><img src="<?php echo $this->webroot;?>img/yes.png" alt="" title="Post it"></a>
                                 </span>
                                 <span class="arrow"> </span>
                            </span>
                         </div>
                         <a href="javascript://" onclick="return removeTags('<?php echo $tags['ProfessionalTag']['id'];?>','<?php echo $tags['ProfessionalTag']['tag_name'].'_'.$i;?>');">Delete</a></td>
                </tr>
            <?php $i++; }?>
            	
              
            </tbody>
        </table>
    </section>
<script type="text/javascript">
 $(document).ready(function(){
	 $('.edit a').click(function(e) {
		 e.stopPropagation();
		 $(this).next().show();
	 });
	 $('.tooltip').click(function(e) {
		  e.stopPropagation();
	 });
	 $('body').click(function(e) {
	 $('.tooltip').hide();
	 });
 });
function removeTags(id,trId)
{
	
	
		$('#'+trId).append('<img id="indiactor1" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/manage_tags/'+id+'/delete',function(data){
			$('#indiactor1').remove();
			
			$('#'+trId).remove();
			
		});
		
	
}
function editTags(id,inputId,tdId)
{
	var tagName=$('#'+inputId).val();
	
		$('tbody').append('<img id="indiactor1" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/manage_tags/'+id+'/edit',{tagName:tagName},function(data){
			$('#indiactor1').remove();
			
			$('#'+tdId).html(tagName);
			
		});
		
	
}
function updateTagStatus1(obj,id)
{
	
	
	if($(obj).is(":checked")) {
		$(obj).parent().append('<img id="indiactor2" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/update_tag_status/'+id+'/Yes',function(data){
			$('#indiactor2').remove();
			/*alert(data);*/
		});
	}else{
		$(obj).parent().append('<img id="indiactor2" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/update_tag_status/'+id+'/No',function(data){
			$('#indiactor2').remove();
			/*alert(data);*/
		});
	}
}
</script>