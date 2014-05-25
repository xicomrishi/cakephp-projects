<section class="document_search">
         	<div id="success" style="display:none;">File uploaded successfully.</div> 
          <form id="FileUploadForm" name="FileUploadForm" method="post" action="<?php echo SITE_URL; ?>/docs/edit_upload_doc" onsubmit="return upload_edit_submit();" enctype="multipart/form-data">
          <fieldset>
          <input type="hidden" name="clientid" value="<?php echo $clientid;?>"/>
           <input type="hidden" name="fileid" value="<?php echo $file['Clientfile']['id'];?>"/>
           <input type="hidden" id="already" value="<?php echo $file['Clientfile']['filename'];?>"/>
          <section class="upload_section">
         
           <span class="file"><?php echo $file['Clientfile']['filename']; ?></span>
          
         <div id="FileUpload" style="position:relative; float:left">
          <input type="file" size="24" id="up_file" name="data[filename]" onchange="getElementById('FileField').value = getElementById('up_file').value;" style="height: 26px; opacity: 0;position: relative;text-align: right;width: 240px; z-index: 2; -moz-opacity:.0; -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)'; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);opacity:.0;"/>
		
			 <div class="upload_section" style="padding:0px; width:240px;position:absolute; top:-10px; left:68px; z-index:1"><a href="#" style="z-index:1">Choose file</a></div>
        </div>
		
		
        
          </section>
          <section class="description_sec">
          <textarea cols="0" rows="0" id="doc_desc" name="data[Clientfile][description]" onblur="if(this.value=='')this.value='Description'" onfocus="if(this.value=='Description')this.value=''"><?php if(isset($file)) { echo $file['Clientfile']['description']; }else{ echo 'Description'; } ?></textarea>
          <textarea cols="0" rows="0" id="doc_tags" name="data[Clientfile][tags]" onblur="if(this.value=='')this.value='Tags'" onfocus="if(this.value=='Tags')this.value=''"><?php if(isset($file)) { echo $file['Clientfile']['tags']; }else{ echo 'Tags'; } ?></textarea>
          </section>
          
          <section class="submit_sec">
          <span class="row pad1">
          <label>SHARE WITH COACH</label>
          <input type="checkbox" name="data[Clientfile][shared]" <?php if($file['Clientfile']['shared']=='Y') { echo 'checked';} ?>/>
          </span>
           
          <span class="row">
           <?php //if($clientinfo['Client']['counselor']=='0') { ?>
          <button id="px-submit" type="submit">Upload/Save</button>
          <?php //} ?>
         
          </span>
          </section>
          </fieldset>
          </form>
         </section>
<script language="javascript">
function upload_edit_submit()
{
	//alert();
	var up_file=$('#up_file').val();
	//alert(up_file);	
	if(up_file=='')
	{
		return true;
	}else{
		
		var fileName=up_file;
		var ext = fileName.substring(fileName.lastIndexOf('.')+1);
		//alert(ext);
		if(ext=='pdf'||ext=='doc'||ext=='docx'||ext=='txt')
		{
			return true;
			
			}else{
				alert('Only pdf/txt/doc/docx files are allowed.');
				return false;
				}
		
		}
	
	
}
function upload_submit()
{
	document.forms['FileUploadForm'].submit();	
	
}


$(document).ready(function(){
	$('input[type="file"]').change(function(){
   var filename = $(this).val();
   $('.file').html(filename);
  
});
});

</script>         