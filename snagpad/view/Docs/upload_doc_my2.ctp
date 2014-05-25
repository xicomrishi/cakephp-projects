<style type="text/css">

#FileUpload {
    position:relative;
}

#FileField {
    width:155px;
    height:22px;
    margin-right:85px;
    border:solid 1px #000;
    font-size:16px;
}

#up_file {
    position:relative;
    width:240px;
    height:26px;
    text-align: right;
    -moz-opacity:0;
    filter:alpha(opacity: 0);
    opacity: 0;
    z-index: 2;
}
</style>

<section class="document_search">
         	<div id="success" style="display:none;">File uploaded successfully.</div> 
          <form id="FileUploadForm" name="FileUploadForm" method="post" action="<?php echo SITE_URL; ?>/docs/upload_doc" onsubmit="return upload_submit();" enctype="multipart/form-data">
          <fieldset>
          <input type="hidden" name="clientid" value="<?php echo $clientid;?>"/>
          <section class="upload_section">
         
           <span class="file"><?php if(isset($file)) {echo $file['Clientfile']['filename']; } ?></span>
         <div id="FileUpload">
          <input type="file" size="24" id="up_file" name="data[filename]" onchange="getElementById('FileField').value = getElementById('up_file').value;" />
		
			 <div id="BrowserVisible"><input type="text" id="FileField"/></div>
        </div>
          </section>
          <section class="description_sec">
          <textarea cols="0" rows="0" id="doc_desc" name="data[Clientfile][description]" onblur="if(this.value=='')this.value='Description'" onfocus="if(this.value=='Description')this.value=''"><?php if(isset($file)) { echo $file['Clientfile']['description']; }else{ echo 'Description'; } ?></textarea>
          <textarea cols="0" rows="0" id="doc_tags" name="data[Clientfile][tags]" onblur="if(this.value=='')this.value='Tags'" onfocus="if(this.value=='Tags')this.value=''"><?php if(isset($file)) { echo $file['Clientfile']['tags']; }else{ echo 'Tags'; } ?></textarea>
          </section>
          
          <section class="submit_sec">
          <span class="row pad1">
          <?php //if($clientinfo['Client']['counselor']=='0') { ?>
          <label>SHARE WITH COACH</label>
          <input type="checkbox" name="data[Clientfile][shared]" value="Y"/>
          <?php //} ?>
          </span>
           
          <span class="row">
          <button id="px-submit" type="submit">Upload/Save</button>

         
          </span>
          </section>
          </fieldset>
          </form>
         </section>
<script type="text/javascript">

$(document).ready(function(e) {
   // alert(2);
	$('#up_file').change(function(){
   var filename = $(this).val();
   //alert('1');
   $('.file').html(filename);
   
  
});
});
function upload_submit()
{
	var up_file=$('#up_file').val();
		
	if(up_file=='')
	{
		alert('Please select file to upload');
		return false;
	}else{
		var fileName=up_file;
		var ext = fileName.substring(fileName.lastIndexOf('.')+1);
		if(ext=='pdf'||ext=='doc'||ext=='docx'||ext=='txt')
		{
			return true;
			
			}else{
				alert('Only pdf/txt/doc/docx files are allowed.');
				return false;
				}
		
		}
	
}

function getfile()
{
	
    document.getElementById("up_file").click();
		
   	
}

	


</script>         