<?php echo 	$this->Html->script('ckeditor/ckeditor');?>
<style>
.signup_form p{width: 100% !important;}
.signup_form p input{ float:none;}
.signup_form p select{ float:none;}
.signup_form p.last{ padding:5px; float:right;}

</style>
<div class="wrapper">  
  <section id="body_container">
	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
   
    <form id="AddCmsPageForm" name="AddCmsPageForm" method="post" onsubmit="return addpage_form_submit();"  action="<?php echo $this->webroot; ?>cms/save_cms_page/<?php if(isset($cms['Cms']['id'])) echo $cms['Cms']['id']; else echo '0'; ?>">
    <fieldset>
    <div class="tab_detail">
    	<h3 class="title"><?php echo __('CMS Page'); ?></h3>
            <?php echo $this->Session->flash(); ?> 
            <div id="infoMsg"></div>   	
            <section class="signup_form">
            	
            	<p><label><?php echo __('Page Title'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[Cms][page_title]" value="<?php if(isset($cms['Cms']['page_title'])) echo $cms['Cms']['page_title']; ?>"/></p>
                <p><label><?php echo __('Page Slug'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[Cms][page_slug]" value="<?php if(isset($cms['Cms']['page_slug'])) echo $cms['Cms']['page_slug']; ?>"/></p>
                <p><label><?php echo __('Language'); ?><span>*</span></label>
                	<select name="data[Cms][language_id]" class="validate[required]">
                    	<option value="">Select</option>
                    	<?php foreach($languages as $lang){ ?>
                        <option value="<?php echo $lang['Language']['id']; ?>" <?php if(isset($cms['Cms']['language_id'])){ if($cms['Cms']['language_id']==$lang['Language']['id']) echo 'selected'; } ?>><?php echo $lang['Language']['name']; ?></option>	
                        <?php } ?>
                    </select>
                </p>              
              
                <label><?php echo __('Content'); ?></label>
                <textarea class="ckeditor" id="cms_content" name="data[Cms][content]"><?php if(isset($cms['Cms']['content'])) echo $cms['Cms']['content']; ?></textarea>
                <p><input type="submit" value="Save"/></p>
        
            </section> 	
            </div>
            </fieldset>
            </form>
         
    </section>
  </section>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#AddCmsPageForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	
	CKEDITOR.replace('cms_content');
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
});

function addpage_form_submit()
{
	for ( instance in CKEDITOR.instances )
			  CKEDITOR.instances[instance].updateElement();
	
	var valid = $("#AddCmsPageForm").validationEngine('validate');
	if(valid)
	{
		return true;
	}else{
		
		$("#AddCmsPageForm").validationEngine();
	}
	return false;		  
			  	
}
</script>