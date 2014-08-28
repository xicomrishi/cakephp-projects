
    <section class="coach_section"  style="padding:15px 0 85px 0;">
          <form id="searchForm" name="searchForm" method="post" action="">
          <section class="coach_section">

        <fieldset>
        <div class="search_sec">
<?php if(isset($coaches)){?>
       <label>Search by Coach:</label>
<select name="coach_id" class="text" style="margin-left:50px;">
<option value=''>Select Coach</option>
<option value='0'>Not Applicable</option>
<?php foreach($coaches as $coach)
    echo "<option value='".$coach['Coach']['account_id']."'>".$coach['Coach']['name']."</option>";
?>
</select><br /><br />
<?php }?>
<div style="float:left; width:100%;"><br />
                <label>Search by name/email:</label>
<input type="text" class="text" name="keyword" style="width:300px; margin-bottom:10px" id="search_id" value="Name/Email" onblur="if(this.value=='')this.value='Name/Email'" onFocus="if(this.value=='Name/Email')this.value=''"/>
</div>
<div style="float:left; width:100%; text-align:center" >
          <a href="javascript://" onclick="searchClient()" class="refresh_btn">SEARCH</a>
		  </div>
          </fieldset>
        <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>
<div id="msg" class="success"></div>
<section id="search_section">
</section>
        </section>
          </form>
         </section>     