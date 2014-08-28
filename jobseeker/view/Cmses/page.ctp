<div class="wrapper">

  <section id="content">
  <div class="row">
  
<div class="span12">
<?php if($PageContent['Cmse']['page_slug']){ ?>
<h1><?php echo $PageContent['Cmse']['page_title']; ?></h1>
<?php if($PageContent['Cmse']['page_slug']=='faqs'){?>
<script type="text/javascript"> 
$(document).ready(function(){
  $(".flip").click(function(){
    $(this).next().slideToggle("slow");
	$(this).toggleClass('active');
  });
});
function searchFunction() {
          var searchTerm = document.searchBox.keyword.value;
		  $(".flip").hide();
		 
          $(".flip").each(function(){ 
		 	if(($(this).text()).toLowerCase().contains(searchTerm)){
				$(this).show();
			}
			
            });
		   return false;

}
</script>
 <form class="search_box" name="searchBox" action="#" method="post" onsubmit="return searchFunction();">
<input type="text" value="Search here" onfocus="if(this.value=='Search here')this.value=''" onblur="if(this.value=='')this.value='Search here'" name="keyword" onkeyup="return searchFunction();">
<input type="submit" class="search" value="">
</form>
<?php }?>
<?php if($PageContent['Cmse']['page_sub_title']){echo '<h4>'.$PageContent['Cmse']['page_sub_title'].'</h4>';} ?>
</div>

<?php /*?><div class="detail_row">
<div class="sub_title"><?php if($PageContent['Cmse']['page_sub_title']){echo '<h2>'.$PageContent['Cmse']['page_sub_title'].'</h2>';} ?></div><?php */?>

<?php echo html_entity_decode($PageContent['Cmse']['page_content']); }else{
	 echo '<h4>Sorry, Page not found.</h4>';
	} ?>




</div>
  
  
  </section>
</div>













