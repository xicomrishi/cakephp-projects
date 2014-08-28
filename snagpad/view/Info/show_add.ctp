<section class="coach_section">
    <form id="frm" name="frm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <div id="error"></div> 
        <fieldset>
        <div class="row"><label>Title:</label>
            <input type="text" id="title" name="title" class="input required" value="<?php if(isset($content['title'])) echo $content['title'];?>" />
         </div>
<div class="row"><label style="float:none;">URL:</label> <span style="color:#757575"><?php echo SITE_URL;?>/info/<?php if(!isset($content) || $content['id']>15) echo "index/";?></span>
          <input type="text" id="page_url" name="page_url" param="[A-za-z0-9_\-]+" class="input required URLRegex" value="<?php if(isset($content['page_url'])) echo $content['page_url'];?>" <?php if(isset($content['page_url']) && $content['page_url']!='') echo "readonly";?> style="float:none; width:300px"  />
	     </div>        
         <div class="row"><label>Content:</label>
         <textarea name='content' class='ckeditor'><?php if(isset($content['content'])) echo $content['content'];?></textarea>
         </div>
<input type="hidden" name="id" id="id" value="<?php if(isset($content['id'])) echo $content['id'];?>" />
           <div class="row">
            <span class="coach_submit" style="padding:40px 0 0 0; width:100% !important; float:none; display:inline-block; text-align:center">
                <input type="button" id="submitButton" value="SAVE" class="submitbtn" style="margin:0px; float:none  !important" />

            </span>
            </div>
                                    </fieldset>
    </form>

    </section>
<script type="text/javascript">
$.validator.addMethod("URLRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\_]+$/i.test(value);
    }, "URL must contain only letters, numbers,underscore or dashes.");

$(document).ready(function(e){
$('#submitButton').click(function(){
if ($('#frm').valid())
{
			for ( instance in CKEDITOR.instances )
			    CKEDITOR.instances[instance].updateElement();
                $.post("<?php echo SITE_URL; ?>/info/save_content",$('#frm').serialize(),function(data){	
				if(data=='')
					show_search();
				else
				{
                        $("#error").html(data);               
                   		$('#error').show(); 
						window.scroll(0,0);  
				}
                });
}
});
    });
</script>
<?php echo $this->Js->writeBuffer(); ?>