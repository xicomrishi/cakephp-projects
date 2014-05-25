<div class="wrapper">   
  <section id="body_container">
    <section class="container">
    
    <div class="tab_detail"> 
     
        <div style="height:300px; text-align:center; font-size:14px; margin-top:150px;">Your response to the 360 assessment is successfully saved.<br><br>Please wait: Generating Report&nbsp;&nbsp;<img src="<?php echo $this->webroot; ?>img/hourglass.gif" alt="..."/></div>
    </div>
    
    </section>
  </section>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    setTimeout(function(){ window.location.href='<?php echo $this->webroot; ?>reports/project_management_report/<?php echo $pr_id; ?>'; },3000);
});
</script>